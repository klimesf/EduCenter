<?php
/**
 * Presenter Test, který má na starosti obsluhovat běh testů, vyhodnocovat je a zobrazit výsledky
 * © 2013, Filip Klimeš
 */
class TestPresenter extends BasePresenter {
    private $testRepository;
    private $testSettingRepository;
    private $questionRepository;
    private $questionReportRepository;
    private $answerRepository;
    private $testId;
    private $questionId;
    private $selection;
    private $successRate;
    private $testResultRepository;
    private $testResultsLimit;
    
    /**
     * Startup presenteru
     */
    protected function startup() {
	parent::startup();
	// Tento presenter je nepřístupný pro nepřihlášené uživatele
	if (!$this->getUser()->isLoggedIn()) {
	    $this->redirect('Sign:in');
	}
    }
    
    /**
     * Akce pro injekci závislostí (DI)
     * @param EduCenter\TestRepository $testRepository
     * @param EduCenter\TestSettingRepository $testSettingRepository
     * @param EduCenter\QuestionRepository $questionRepository
     * @param EduCenter\QuestionReportRepository $questionReportRepository
     * @param EduCenter\AnswerRepository $answerRepository
     * @param EduCenter\TestResultRepository $testResultRepository
     */
    public function inject(EduCenter\TestRepository $testRepository, EduCenter\TestSettingRepository $testSettingRepository, EduCenter\QuestionRepository $questionRepository,
     EduCenter\QuestionReportRepository $questionReportRepository, EduCenter\AnswerRepository $answerRepository, EduCenter\TestResultRepository $testResultRepository) {
	$this->testRepository = $testRepository;
	$this->testSettingRepository = $testSettingRepository;
	$this->questionRepository = $questionRepository;
	$this->questionReportRepository = $questionReportRepository;
	$this->answerRepository = $answerRepository;
	$this->testResultRepository = $testResultRepository;
    }
    
    /**
     * Defaultní akce
     */
    public function actionDefault() {
	$this->template->tests = $this->testRepository->findAll();
    }
    
    /**
     * Akce pro přehled testu, před jeho spuštěním
     * @param test.id $testId
     */
    public function actionOverview($testId) {
	$this->template->test = $this->testRepository->getById($testId);
	$this->template->settings = $this->testSettingRepository->findByTest($testId);
    }
    
    /**
     * Akce pro běh testu
     * @param test.id $testId
     * @param EduCenter\QuestionRepository\ActiveRow $question
     * @param boolean $makeNew
     */
    public function actionRun($testId, $question = null, $makeNew = null) {
	$this->testId = $testId;
	// Zjistíme, zda už byl test vytvořen
	$session = $this->session->getSection('Test');
	if(!isset($session->questionArray) || $session->testId != $testId || $makeNew == true) {
	    $this->assembleTest($testId);
	}
	
	// Nastavení vykreslované otázky
	if($question == null) {
	    $question = 1;
	}
	$questionArray = $session->questionArray;
	$this->selection = $this->questionRepository->findById($questionArray[$question-1]);	// Kvůli počítání iterator musíme posunout o -1
    }

    /**
     * Render pro akci Run - běh testu
     * @param test.id $testId
     * @param EduCenter\QuestionRepository\ActiveRow $question
     * @param boolean $makeNew
     */
    public function renderRun($testId, $question = null, $makeNew = null) {
	if($question == null) {
	    $question = 1;
	}
	
	$this->template->questionArray = $this->session->getSection('Test')->questionArray;
	$this->template->testId = $testId;
	$this->template->questionNo = $question;
	$this->template->questionId = $this->session->getSection('Test')->questionArray[$question-1];
	$this->template->checkedAnswers = new \EduCenter\CheckedAnswers();
	$this->template->checkedAnswers->unserialize($this->session->getSection('QuestionDisplay')->checkedAnswers);
	$this->template->isLastQuestion = isset($this->session->getSection('Test')->questionArray[$question]) ? false : true; //  Kvůli počítání iterator musíme posunout o -1
    }
    
    /**
     * Akce vyhodnocení testu
     * @param test.id $testId
     */
    public function actionEvaluate($testId) {
	$this->testId = $testId;
	$this->testResultsLimit = 5;
	// Načteme ze session zaškrtnuté odpovědi
	$checkedAnswers = new \EduCenter\CheckedAnswers();
	$checkedAnswers->unserialize($this->session->getSection('QuestionDisplay')->checkedAnswers);
	
	// Vytvoříme pole správných odpovědí
	$correctArray = array();
	$questionArray = $this->session->getSection('Test')->questionArray;
	foreach($questionArray as $questionId) {
	    // Načteme správné odpovědi
	    $answers = $this->answerRepository->findByQuestion($questionId)->where(array('correct' => 1));
	    // Vložíme je do pole správných odpovědí
	    $correctArray[$questionId] = array();
	    foreach($answers as $answer) {
		$correctArray[$questionId][] = $answer->id;
	    }
	}
	
	// Vyhodnotíme test
	$wrongAnswers = $checkedAnswers->evaluateTest($correctArray);
	if($wrongAnswers === true) {
	    $this->successRate = 100;
	} else {
	    $nOfQuest = sizeof($questionArray);
	    $nOfWrong = sizeof($wrongAnswers);
	    $this->successRate = round((($nOfQuest - $nOfWrong) / $nOfQuest) * 100, 0, PHP_ROUND_HALF_UP);
	}
	
	$this->template->correctArray = $correctArray;
	$this->template->wrongAnswers = $wrongAnswers;
	$this->testResultRepository->insert($this->testId, $this->getUser()->getId(), date('Y-m-d'), $this->successRate);
	
	// Vymažeme vylosované otázky
	unset($this->session->getSection('Test')->questionArray);
	unset($this->session->getSection('QuestionDisplay')->checkedAnswers);
    }
    
    /**
     * Render akce Evaluate - vyhodnocení testu
     * @param test.id $testId 
     */
    public function renderEvaluate($testId) {
	$this->template->successRate = $this->successRate;
	$this->template->test = $this->testRepository->getById($testId);
	// Vybereme posledních 5 výsledků daného testu
	$this->template->testresults = $this->testResultRepository->
		findByTest($testId)->where(array("id_user" => $this->getUser()->getId()))->
		order('date DESC')->limit(5);
    }
    
    
    
    public function actionWrongAnswers() {}
    
    public function renderWrongAnswers() {}
    
    /**
     * Sestaví test podle zadaného Id
     * @param type $testId
     */
    protected function assembleTest($testId) {
	// TODO ----------------------------------------------------------------
	//  vylepšit random select otázek, order by RAND() bude problém při
	//  velké tabule otázek, což by se mohlo stát
	//	- nyní ovšem nevadí, pokud je v Unit otázek méně než je
	//	    požadováno v testu
	// /TODO ---------------------------------------------------------------
	
	
	$this->testId = $testId;
	$session = $this->session->getSection('Test');
	$questionArray = array();
	
	// Načteme nastavení testu
	$settings = $this->testSettingRepository->findByTest($testId);
	foreach($settings as $setting) {
	    // Pro každé nastavení vybereme otázky
	    $questions = $this->questionRepository->findByUnit($setting->id_unit)->order("RAND()")->limit($setting->number_of_questions);
	    foreach($questions as $question) {
		$questionArray[] = $question->id;
	    }
	}
	$session->testId = $testId;
	$session->questionArray = $questionArray;
    }
    
    /**
     * Továrnička pro komponentu QuestionDisplay
     * @return \EduCenter\QuestionDisplayControl
     */
    protected function createComponentQuestionDisplay() {
	return new EduCenter\QuestionDisplayControl($this->answerRepository, $this->context->session, 
		$this->questionReportRepository, $this->selection, true, false);
    }
    
    /**
     * Továrnička pro komponentu TestResultsList
     * @return \EduCenter\TestResultsListControl
     */
    protected function createComponentTestResultsList() {
	return new EduCenter\TestResultsListControl($this->testResultRepository, $this->testId, $this->testResultsLimit);
    }
}