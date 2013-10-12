<?php
namespace EduCenter;
use Nette\Application\UI\Control;
use Nette\Object;
use Nette\Http\Session;
use Nette\Application\UI\Form;

class QuestionDisplayControl extends Control {
    /**
     * Je zobrazovaná otázka zodpovězena?
     * @var type boolean
     */
    protected $answered;
    /**
     * Id zobrazované otázky
     * @var type int(11)
     */
    private $selection;
    /** @var int(11) */
    protected $questionId;
    /** @var EduCenter\QuestionRepository */
    protected $questionRepository;
    /** @var EduCenter\AnswerRepository */
    protected $answerRepository;
    /** @var EduCenter\UnitRepository */
    protected $unitRepository;
    /** @var EduCenter\QuestoinReportRepository */
    protected $questionReportRepository;
    /** @var session */
    private $session;
    /**
     * Třída obsahující zaškrtnuté obrázky
     * @var EduCenter\CheckedAnswers
     */
    private $checkedAnswers;
    /**
     * Pole obsahující výběr otázek
     * @var array
     */
    private $questionArray = array();
    /**
     * Příznak zobrazování navigace mezi otázkami
     * @var boolean
     */
    private $displayNav = true;
    /**
     * Příznak
     */
    private $testMode = false;
    
    /**
     * Konstuktor
     * @param type $question_id Id zobrazované otázky
     * @param EduCenter\QuestionRepository $questionRepository
     * @param EduCenter\AnswerRepository $answerRepository
     */
    public function __construct(QuestionRepository $questionRepository, AnswerRepository $answerRepository, Session $session, UnitRepository $unitRepository, QuestionReportRepository $questionReportRepository,\Nette\Database\Table\Selection $selection, $questionId = NULL, $testMode = NULL, $answered = NULL) {
	parent::__construct();
	$this->questionRepository = $questionRepository;
	$this->answerRepository = $answerRepository;
	$this->unitRepository = $unitRepository;
	$this->questionReportRepository = $questionReportRepository;
	if($testMode != null)
	    $this->testMode = $testMode;
	else
	    $this->testMode = false;
		
	// Práce se sessions
	$this->session = $session->getSection('QuestionDisplay');
	$this->session->setExpiration(0);
	
	// Načteme zaškrtnuté otázky ze session
	$this->checkedAnswers = new CheckedAnswers($this->answerRepository);
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);

	$this->selection = $selection;
	
	foreach($this->selection as $question) {
	    $this->questionArray[] = $question->id;
	}
	
	// Zvolíme id otázky, kterou budeme zobrazovat
	if($questionId != null) {
	    $this->questionId = $questionId;	// Primárně bereme z parametru
	} else if(isset($this->session->questionId) && array_search($this->session->questionId, $this->questionArray) != null){
	    $this->questionId = $this->session->questionId;
	} else {
	    $this->questionId = $this->questionArray[0];
	}
	// Nakonec předáme do session
	$this->session->questionId = $this->questionId;
	
	// Nastavíme zda zobrazovat navigaci
	if(count($this->questionArray) < 2) {
	    $this->displayNav = false;
	}
	
	if($answered) {
	    $this->answered = $answered;
	} else {
	    $this->answered = false;
	}
    }
    
    /* --- Formuláře ---------------------------------------------------------*/
    protected function createComponentReportForm() {
	$form = new \Nette\Application\UI\Form;
	$form->addTextArea('text', 'Popis problému')
		->setRequired('Prosím vyplňte popis problému.');
	$form->addHidden('questionId', $this->questionId);
	$form->addSubmit('report', 'Nahlásit problém');
	
	$form->onSuccess[] = $this->reportFormSucceeded;
	
	return $form;
    }
    
    public function reportFormSucceeded(\Nette\Application\UI\Form $form) {
	$this->questionReportRepository->addReport($form->values->text, $this->getPresenter()->getUser()->getId(), $form->values->questionId);
	$this->flashMessage('Problém nahlášen', 'success');
    }
    
    /* --- Obsluha signálů ---------------------------------------------------*/
    /**
     * Obsluha signálu checkAnswer
     * @param int(11) $answerId
     */
    public function handleCheckAnswer($answerId) {
	// Obsluha
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);
	$this->checkedAnswers->addCheckedAnswer($answerId);
	
	$this->session->checkedAnswers = $this->checkedAnswers->serialize();
    }

    public function handleUncheckAnswer($answerId) {
	// Obsluha
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);
	$this->checkedAnswers->deleteCheckedAnswer($answerId);
	
	$this->session->checkedAnswers = $this->checkedAnswers->serialize();
    }
    
    public function handleEvaluate() {
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);
	
	$this->answered = true;	    // Nastavíme zobrazení zodpovězené otázky
	
	// Kontrola, zda je otázka správně zodpovězena
	//  načteme data
	$correctAnswers = $this->answerRepository->findBy(array('id_question' => $this->questionId, 'correct' => 1));
	if($this->checkedAnswers->areCorrect($correctAnswers)) {
	    $this->flashMessage('Otázka byla zodpovězena správně', 'success');
	} else {
	    $this->flashMessage('Otázka byla zodpovězena nesprávně', 'error');
	}
	
	// Vymažeme data o zaškrtnutých odpovědích
	unset($this->session->checkedAnswers);
    }

    public function handleGoTo($questionId) {
	$this->questionId = $questionId;
	$this->session->questionId = $questionId;
    }
    /* -----------------------------------------------------------------------*/
    
    /**
     * Vrátí id otázky
     * @param int $jump relativní posun od aktuálně zvolené otázky, nebo klíčová slova 'last' a 'first'
     * @return mixed Vrátí id otázky nebo false, pokud otázka neexistuje
     */
    protected function getQuestionId($jump = null) {
	if($jump == 'last') {
	    return $this->questionArray[sizeof($this->questionArray)-1];
	}
	if($jump == 'first') {
	    return $this->questionArray[0];
	}
	$key = array_search($this->questionId, $this->questionArray);
	if(isSet($this->questionArray[$key+$jump])) {
	    return $this->questionArray[$key+$jump];
	} else {
	    return false;
	}
    }
    
    /**
     * Vykreslení komponenty
     */
    public function renderByUnit() {
	// Nastavení šablony
	$template = $this->template;
	$template->setFile(__DIR__ . '/QuestionDisplayByUnit.latte');
	
	// Získáme data pro vykreslování
	$question = $this->questionRepository->getById($this->questionId);
	$answers = $this->answerRepository->findByQuestion($this->questionId);
	
	// Předáme veškerá potřebná data šabloně
	$this->template->question = $question;
	$this->template->answers = $answers;
	$this->template->answered = $this->answered;
	$this->template->checkedAnswers = $this->checkedAnswers;
	$this->template->displayNav = $this->displayNav;
	$this->template->previousId = $this->getQuestionId(-1);
	$this->template->nextId = $this->getQuestionId(+1);
	$this->template->numberOfQuestions = sizeof($this->questionArray);
	$this->template->numberOfCurrentQuestion = array_search($this->questionId, $this->questionArray)+1;
	// Předáme odkaz na první a poslední otázku, pokud jsme na první nebo poslední, odkaz nepředáme
	if($this->getQuestionId('last') != $this->questionId) {
	    $this->template->lastId = $this->getQuestionId('last');
	} else {
	    $this->template->lastId = false;
	}
	if($this->getQuestionId('first') != $this->questionId) {
	    $this->template->firstId = $this->getQuestionId('first');
	} else {
	    $this->template->firstId = false;
	}
	// Skok dolů a nahorů
	$this->template->skipDownId = $this->getQuestionId(-10);
	$this->template->skipUpId = $this->getQuestionId(10);
	$this->template->numberOfUnresolvedReports = $this->questionReportRepository->findByQuestion($this->questionId)->count();
	
	
	$unit = $this->unitRepository->findBy(array('id' => $question->id_unit))->fetch();
	$this->template->unitName = $unit->name;
	$this->template->AnswerIteratorMask = new AnswerIteratorMask;
	
	// Vykreslíme šablonu
	$template->render();
    }
    
    public function renderById() {
	$template = $this->template;
	$template->setFile(__DIR__ . '/QuestionDisplayById.latte');
	
	$question = $this->questionRepository->getById($this->questionId);
	$answers = $this->answerRepository->findByQuestion($this->questionId);
	
	$this->template->question = $question;
	$this->template->answers = $answers;
	$this->template->answered = true;
	$this->template->displayNav = false;
	$this->template->AnswerIteratorMask = new AnswerIteratorMask;
	
	$template->render();
    }
}


/**
 * Třída reprezentující úložiště zaškrtnutých odpovědí pro zobrazovanou otázku
 */
class CheckedAnswers extends Object implements \Serializable {
    /**
     * Pole držící data o zaškrtnutých odpovědích
     * @var type 
     */
    private $array = array();
    
    /**
     * Přidá zaškrtnutou odpověď
     * @param int(11) $answerId
     */
    public function addCheckedAnswer($answerId) {
	// Zabráníme duplicitě záznamů kvůli pozdějšímu porovnávání polí
	$key = array_search($answerId, $this->array);
	if($key === false)
	    $this->array[] = $answerId;	// Vložíme záznam na konec pole
    }
    
    /**
     * Vymaže záznam o zaškrtnuté odpovědi
     * @param int(11) $answerId
     */
    public function deleteCheckedAnswer($answerId) {
	$key = array_search($answerId, $this->array);
	unset($this->array[$key]);
    }
    
    /**
     * Vrátí příznak o tom, zda je odpověď zaškrtnuta
     * @param int(11) $answerId
     * @return boolean
     */
    public function isAnswerChecked($answerId) {
	foreach($this->array as $array) {
	    if($array == $answerId)
		return true;
	}
	return false;
    }
    
    /**
     * Zjistí, zda jsou zaškrtnuté odpovědi správné
     */
    public function areCorrect($correctAnswers) {
	// Vytvoříme pole obsahující správné otázky
	$corAnsIds = array();
	foreach($correctAnswers as $answer) {
	    $corAnsIds[] = $answer->id;
	}
	
	// Porovnáme pole se správnými otázkami s polem zaškrtnutých otázek
	//  nejprve obě pole seřadíme
	sort($this->array, SORT_NUMERIC);
	sort($corAnsIds, SORT_NUMERIC);
	
	/*DEBUGGER::Dump($this->array);
	DEBUGGER::Dump($corAnsIds);*/
	
	if($this->array == $corAnsIds)
	    return true;
	else
	    return false;
    }
    
    /**
     * Serializuje data objektu
     * @return array
     */
    public function serialize() {
        return serialize($this->array);
    }
    
    /**
     * Deserializuje předaná data a uloží je
     * @param CheckedAnswers::Array $array
     */
    public function unserialize($array) {
	$this->array = unserialize($array);
    }
}

/**
 * Třída nahrazující čísla otázek za písmena
 */
class AnswerIteratorMask extends \Nette\Object {
    /**
     * Vrátí místo čísla písmeno A-Z
     * @param int Pořadí prvku
     * @return char Výsledné písmeno
     */
    public static function getChar($i) {
	// Potřeba předělat
	//  Po Z jde @ a pak znova A (iterátor začíná od 1)
	$i = ($i % 27)+64;
	return chr($i);
    }
}