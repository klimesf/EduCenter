<?php

use Nette\Application\UI,
	Nette\Application\UI\Form,
	Nette\Http\FileUpload,
	Nette\Utils\Strings;

class QuestionPresenter extends BasePresenter {

    /** @var EduCenter\UserRepository */
    private $userRepository;

    /** @var EduCenter\Authenticator */
    private $authenticator;

    /** @var EduCenter\QuestionRepository */
    private $questionRepository;

    /** @var EduCenter\AnswerRepository */
    private $answerRepository;
    
    /** @var EduCenter\UnitRepository */
    private $unitRepository;
    
    /** @var EduCenter\QuestionReportRepository */
    private $questionReportRepository;
    
    /** Id zobrazované otázky @var int(11) */
    private $questionId = null;
    
    /** @var Nette\Database\Table\Selection */
    private $selection;
    /** @var boolean Zobrazujeme zodpovězenou otázku? */
    private $answered = false;

    public function inject(EduCenter\UserRepository $userRepository, EduCenter\Authenticator $authenticator, EduCenter\QuestionRepository $questionRepository,
	    EduCenter\AnswerRepository $answerRepository, EduCenter\UnitRepository $unitRepository, EduCenter\QuestionReportRepository $questionReportRepository)
    {
	$this->userRepository = $userRepository;
	$this->authenticator = $authenticator;
	$this->questionRepository = $questionRepository;
	$this->unitRepository = $unitRepository;
	$this->answerRepository = $answerRepository;
	$this->questionReportRepository = $questionReportRepository;
    }
    
    protected function startup() {
	parent::startup();
	// Tento presenter je nepřístupný pro nepřihlášené uživatele
	if (!$this->getUser()->isLoggedIn()) {
	    $this->redirect('Sign:in');
	}
    }

    
    /* --- AKCE --------------------------------------------------------------*/
    
    
    public function actionDefault() {
    }
    
    public function renderDefault() {
	$this->template->units = $this->unitRepository->findAll();
	$this->template->questionRepository = $this->questionRepository;
    }
    
    public function actionBrowseByUnit($unitId) {
	// Nastavení paginatoru
	$eduPaginator = new EduCenter\QuestionPaginator($this, 'questionPaginator');
	$paginator = $eduPaginator->getPaginator();
	$paginator->setItemCount($this->questionRepository->findByUnit($unitId)->count());
	$paginator->setItemsPerPage(1);
	
	$this->selection = $this->questionRepository->findByUnit($unitId)->limit($paginator->getLength(), $paginator->getOffset());
	if(!$this->selection) {
	    $this->flashMessage ('Tato kategorie neobsahuje žádné otázky.', 'error');
	    $this->redirect('Question:');
	}	
    }
    
    public function renderBrowseByUnit($unitId) {
	$this->template->unitName = $this->unitRepository->getUnitName($unitId);
    }
    
    public function actionBrowse($questionId) {
	$this->selection = $this->questionRepository->findBy(array('id' => $questionId));
	//$this->questionId = $questionId;
	if(!$this->selection) {
	    $this->flashMessage ('Otázka neexistuje.', 'error');
	    $this->redirect('Question:');
	}
    }
    
    public function actionAdd() {

    }
    
    public function actionEdit($questionId) {
	if (!$this->getUser()->isInRole('admin')) {
	    $this->redirect('Question:');
	}
	$this->questionId = $questionId;
	$this->selection = $this->questionRepository->findById($questionId);
    }
    
    public function actionReports() {
	if (!$this->getUser()->isInRole('admin')) {
	    $this->redirect('Question:');
	}
    }
    
    public function actionReportsByQuestion($questionId) {
	if (!$this->getUser()->isInRole('admin')) {
	    $this->redirect('Question:');
	}
	$this->questionId = $questionId;
	$this->answered = true;
	$this->selection = $this->questionRepository->findById($questionId);
    }
    
    public function actionAddReport($questionId) {
	if (!$this->getUser()->isInRole('admin')) {
	    $this->redirect('Question:');
	}
	$this->questionId = $questionId;
    }
    
    /* --- Továrničky --------------------------------------------------------*/
    
    /**
     * Továrnička vytvářející komponentu QuestionDisplay
     * @return \EduCenter\QuestionDisplayControl    vytvořená komponenta
     */
    protected function createComponentQuestionDisplay() {
	return new EduCenter\QuestionDisplayControl($this->answerRepository,
		$this->context->session, $this->questionReportRepository, $this->selection, $this->questionId);
    }
    
    /**
     * Továrnička vytvářející komponentu QuestionReportList
     * @return \EduCenter\QuestionReportListControl	vytvořená komponenta
     */
    protected function createComponentQuestionReportList() {
	if($this->questionId === null)
	    return new EduCenter\QuestionReportListControl($this->questionReportRepository);
	else
	    return new EduCenter\QuestionReportListControl($this->questionReportRepository, $this->questionId);
    }
    
    /**
     * Továrnička pro formulář, který vytváří a edituje otázku a její odpovědi
     * @return \Nette\Application\UI\Form   vytvořený formulář
     */
    protected function createComponentQuestionForm() {
	$unitPairs = $this->unitRepository->findAll()->fetchPairs('id', 'name');
	
	$form = new UI\Form;
	$form->addTextArea('text', 'Zadání otázky:')
		->setRequired('Prosím vyplňte zadání otázky.');
	
	$form->addUpload('img', 'Obrázek k otázce:')
		->addCondition(Form::FILLED)
		->addRule(Form::IMAGE, 'Soubor musí být obrázek.');
	
	$form->addSelect('unit', 'Kategorie:', $unitPairs)
		->setPrompt('- Vyberte -')
		->addRule(Form::FILLED, 'Je nutné vybrat do jaké kategorie otázka patří.');
	
	$form->addText('points', 'Počet bodů:', 3)
		->setDefaultValue(1)
		->addRule(Form::INTEGER, 'Počet bodů musí být číslo.');

	$form->addText('answer1', 'První odpověď:', 50, 255)
		->setRequired('Prosím vyplňte znění odpovědi.');
	$form->addCheckbox('answer1correct', 'Správná odpověď');
	$form->addText('answer2', 'Druhá odpověď:', 50, 255)
		->setRequired('Prosím vyplňte znění odpovědi.');
	$form->addCheckbox('answer2correct', 'Správná odpověď');
	$form->addText('answer3', 'Třetí odpověď:', 50, 255)
		->setRequired('Prosím vyplňte znění odpovědi.');
	$form->addCheckbox('answer3correct', 'Správná odpověď');
	$form->addText('answer4', 'Čtvrtá odpověď:', 50, 255)
		->setRequired('Prosím vyplňte znění odpovědi.');
	$form->addCheckbox('answer4correct', 'Správná odpověď');

	$form->addSubmit('insert', 'Uložit');

		
	// Pokud editujeme otázku, načteme data
	if($this->questionId != null) {
	    $form->addHidden('questionId', $this->questionId);
	    
	    $question = $this->questionRepository->findBy(array('id' => $this->questionId))->fetch();
	    if(!$question) {	// Pokud nám někdo podstrčil špatné id
		throw Nette\Application\BadRequestException;
	    }
	    $answers = $this->answerRepository->findBy(array('id_question' => $this->questionId));
	    
	    // Naplnění defaultních hodnot
	    $defaults = array(
		'text' => $question->text,
		'unit' => $question->id_unit,
		'points' => $question->points
	    );
	    $i = 1;
	    foreach($answers as $answer) {  // a pro každou odpověď
		$form->addHidden('answer'.$i.'id', $answer->id);
		$defaults['answer'.$i] = $answer->text;
		$defaults['answer'.$i.'correct'] = $answer->correct;
		$i++;
	    }
	    
	    $form->setDefaults($defaults);
	    $form->onSuccess[] = $this->questionFormEditSucceeded;
	} else {
	    $form->onSuccess[] = $this->questionFormSucceeded;
	}
	return $form;
    }
    
    public function questionFormSucceeded(Form $form) {
	$file = $form['img']->getValue();
	$file_name = NULL;
	
	if ($file->isOK()) {
	    $file_name=Strings::lower($file->name);
            $file->move($this->context->parameters['wwwDir'] . "/images/questions/". $file_name);
	}
	
	// Uložení otázky
	$row = $this->questionRepository->addQuestion($form->values->text, $file_name, $form->values->points, $form->values->unit);
	$question_id = $row->getPrimary();
	
	// Uložení odpovědí
	$this->answerRepository->addAnswer($form->values->answer1, $form->values->answer1correct, $question_id);
	$this->answerRepository->addAnswer($form->values->answer2, $form->values->answer2correct, $question_id);
	$this->answerRepository->addAnswer($form->values->answer3, $form->values->answer3correct, $question_id);
	$this->answerRepository->addAnswer($form->values->answer4, $form->values->answer4correct, $question_id);
	$this->flashMessage('Otázka přidána.', 'success');
    }

    public function questionFormEditSucceeded(Form $form) {
	$file = $form['img']->getValue();
	$file_name = NULL;
	
	if ($file->isOK()) {
	    $file_name=Strings::lower($file->name);
            $file->move($this->context->parameters['wwwDir'] . "/images/questions/". $file_name);
	}
	
	$this->questionId = $form->values->questionId;
	
	// Uložení otázky
	$this->questionRepository->updateQuestion($this->questionId, $form->values->text, $file_name, $form->values->points, $form->values->unit);
	
	// Uložení odpovědí
	$this->answerRepository->updateAnswer($form->values->answer1id, $form->values->answer1, $form->values->answer1correct);
	$this->answerRepository->updateAnswer($form->values->answer2id, $form->values->answer2, $form->values->answer2correct);
	$this->answerRepository->updateAnswer($form->values->answer3id, $form->values->answer3, $form->values->answer3correct);
	$this->answerRepository->updateAnswer($form->values->answer4id, $form->values->answer4, $form->values->answer4correct);
	$this->flashMessage('Otázka upravena.', 'success');
    }    
}