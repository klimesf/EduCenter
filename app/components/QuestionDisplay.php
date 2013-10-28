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
    private $question;
    /** @var int(11) */
    protected $questionId;
    /** @var EduCenter\QuestionRepository */
    protected $questionRepository;
    /** @var EduCenter\AnswerRepository */
    protected $answerRepository;
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
     * Příznak zobrazování navigace mezi otázkami
     * @var boolean
     */
    private $displayNav = true;
    /**
     * Příznak zda zobrazujeme data pro testovací účely
     */
    private $testMode = false;
    
    /**
     * Konstuktor
     * @param type $question_id Id zobrazované otázky
     * @param EduCenter\QuestionRepository $questionRepository
     * @param EduCenter\AnswerRepository $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository, Session $session, QuestionReportRepository $questionReportRepository, \Nette\Database\Table\Selection $selection, $testMode = NULL, $answered = NULL) {
	parent::__construct();
	$this->answerRepository = $answerRepository;
	$this->questionReportRepository = $questionReportRepository;
	
	// Pokud jsme v testovacím módu, znamená to pro nás změnu některých nastavení
	$this->testMode = ($testMode == null) ? false : $testMode;
		
	// Práce se sessions
	$this->session = $session->getSection('QuestionDisplay');
	$this->session->setExpiration(0);
	
	// Načteme zaškrtnuté otázky ze session
	$this->checkedAnswers = new CheckedAnswers($this->answerRepository);
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);

	$this->question = $selection->fetch();
	
	// Nakonec předáme do session
	$this->session->questionId = $this->question->id;
	
	// Zobrazujeme zodpovězenou otázku?
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
	$form->addHidden('questionId', $this->question->id);
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
	// TODO-----------------------------------------------------------------
	// - Spojit answeredQuestions a checkedAnswers
	//	    + umožní oddělení vyhodnocení samotných otázek a celého testu
	//	    + promazávání checkedAnswers v Question:browse při přechodu
	//		na jinou otázku
	// /TODO ---------------------------------------------------------------	    
	    
	// Zápis do zaškrtnutých odpovědí
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);
	$this->checkedAnswers->addCheckedAnswer($answerId, $this->question->id);
	
	$this->session->checkedAnswers = $this->checkedAnswers->serialize();	
    }

    public function handleUncheckAnswer($answerId) {
	// Obsluha
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);
	$this->checkedAnswers->deleteCheckedAnswer($answerId, $this->question->id);
	
	$this->session->checkedAnswers = $this->checkedAnswers->serialize();
    }
    
    public function handleEvaluate() {
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);
	
	$this->answered = true;	    // Nastavíme zobrazení zodpovězené otázky
	
	// Kontrola, zda je otázka správně zodpovězena
	//  načteme data
	$correctAnswers = $this->answerRepository->findBy(array('id_question' => $this->question->id, 'correct' => 1));
	if($this->checkedAnswers->isQuestionCorrect($correctAnswers, $this->question->id)) {
	    $this->flashMessage('Otázka byla zodpovězena správně', 'success');
	} else {
	    $this->flashMessage('Otázka byla zodpovězena nesprávně', 'error');
	}
	
	// Pokud nejsme v test-mode, vymažeme data o zaškrtnutých odpovědích
	if(!$this->testMode) {
	    unset($this->session->checkedAnswers);
	}
    }
    /* -----------------------------------------------------------------------*/
    
    /**
     * Vrátí id otázky
     * @param int $jump relativní posun od aktuálně zvolené otázky, nebo klíčová slova 'last' a 'first'
     * @return mixed Vrátí id otázky nebo false, pokud otázka neexistuje
     */
    protected function getQuestionId() {
	return $this->question->id;
    }
    
    /**
     * Vykreslení komponenty
     */
    public function render() {
	// Nastavení šablony
	$template = $this->template;
	$template->setFile(__DIR__ . '/QuestionDisplay.latte');
	
	// Získáme data pro vykreslování
	$answers = $this->answerRepository->findByQuestion($this->question->id);
	
	// Předáme veškerá potřebná data šabloně
	$this->template->question = $this->question;
	$this->template->answers = $answers;
	$this->template->testMode = $this->testMode;
	$this->template->answered = $this->answered;
	$this->template->checkedAnswers = $this->checkedAnswers;
	$this->template->numberOfUnresolvedReports = $this->questionReportRepository->findByQuestion($this->question->id)->count();
	$this->template->AnswerIteratorMask = new AnswerIteratorMask;
	
	// Vykreslíme šablonu
	$template->render();
    }
}


/**
 * Třída reprezentující úložiště zaškrtnutých odpovědí pro zobrazovanou otázku
 */
class CheckedAnswers extends Object implements \Serializable {
    /**
     * Dvojrozměrné pole držící data o zaškrtnutých odpovědích
     *	array[id_otázky][id_zaškrtnunté_odpovědi]
     * @var type 
     */
    private $checkedAnswers = array();
    
    /**
     * Přidá zaškrtnutou odpověď
     * @param int(11) $answerId
     */
    public function addCheckedAnswer($answerId, $questionId) {
	// Zabráníme duplicitě záznamů kvůli pozdějšímu porovnávání polí
	if(array_key_exists($questionId, $this->checkedAnswers) === false) {
	    $this->checkedAnswers[$questionId] = array();	// Vložíme záznam
	}
	    
	// Přidání odpovědi
	if((array_search($answerId, $this->checkedAnswers[$questionId]) === false))
		$this->checkedAnswers[$questionId][] = $answerId;
    }
    
    /**
     * Vymaže záznam o zaškrtnuté odpovědi
     * @param int(11) $answerId
     */
    public function deleteCheckedAnswer($answerId, $questionId) {
	// Pokud nám zbývá poslední zaškrtnutá odpověď, smažeme celou otázku 
	if(sizeof($this->checkedAnswers[$questionId]) < 2) {
	    unset($this->checkedAnswers[$questionId]);
	} else {
	    $key = array_search($answerId, $this->checkedAnswers[$questionId]);
	    unset($this->checkedAnswers[$questionId][$key]);
	}
    }
    
    /**
     * Vrátí příznak o tom, zda je odpověď zaškrtnuta
     * @param id $answerId
     * @return boolean
     */
    public function isAnswerChecked($answerId, $questionId) {
	if(!isset($this->checkedAnswers[$questionId]))
	    return false;

	foreach($this->checkedAnswers[$questionId] as $array) {
	    if($array == $answerId)
		return true;
	}
	return false;
    }
    
    /**
     * Vrátí příznak o tom, zda je u otázky zaškrtnuta alespoň jedna odpověď
     * @param id $questionId
     * @return boolean
     */
    public function isQuestionAnswered($questionId) {
	if(!isset($this->checkedAnswers[$questionId]))
	    return false;
	else
	    return true;
    }
    
    /**
     * Zjistí, zda jsou zaškrtnuté odpovědi správné
     */
    public function isQuestionCorrect($correctAnswers, $questionId) {
	// Vytvoříme pole obsahující správné otázky
	$corAnsIds = array();
	$checkAnsIds = (isset($this->checkedAnswers[$questionId])) ? $this->checkedAnswers[$questionId] : array();
	foreach($correctAnswers as $answer) {
	    $corAnsIds[] = $answer->id;
	}
	
	// Porovnáme pole se správnými otázkami s polem zaškrtnutých otázek
	//  nejprve obě pole seřadíme
	sort($checkAnsIds, SORT_NUMERIC);
	sort($corAnsIds, SORT_NUMERIC);
	
	/*DEBUGGER::Dump($this->array);
	DEBUGGER::Dump($corAnsIds);*/
	
	if($checkAnsIds == $corAnsIds)
	    return true;
	else
	    return false;
    }
    
    /**
     * Funkce, která vyhodnotí test
     * @param array $correctArray pole správných odpovědí [id_otázky][id_správné_odpovědi]
     * @return array $answeredWrong pole špatně zodpovězených otázek [id_otázky][id_zaškrtnuté odpovědi]
     * ! časově náročná operace
     */
    public function evaluateTest($correctArray) {
	$answeredWrong = array();   // Pole pro správně zodpovězené otázky
	if(!is_array($this->checkedAnswers)) {
	    $this->checkedAnswers = array();
	}
	
	// Projíždíme pole správných odpovědí
	foreach($correctArray as $question => $answers) {
	    // Pokud nebyla otázka vůbec zodpovězena
	    if(!array_key_exists($question, $this->checkedAnswers)) {
		$answeredWrong[$question] = array();	// Přidáme ji celou do špatně odpovězených
	    } else {	// Pokud byla otázka zodpovězena, zkontrolujeme, zda byla zodpovězena správně
		// Seřadíme, abychom mohli porovnat
		sort($correctArray[$question], SORT_NUMERIC);
		sort($this->checkedAnswers[$question], SORT_NUMERIC);
		// Pokud nejsou stejné, přidáme do špatně zodpovězených
		if(!($correctArray[$question] == $this->checkedAnswers[$question])) {
		    $answeredWrong[$question] = $answers;
		}
	    }
	}
	// Nakonec vrátíme množinu špatných odpovědí, nebo true pokud byl test
	//  splněn na 100%;
	if(empty($answeredWrong)) {
	    return true;
	} else {
	    return $answeredWrong;
	}
    }
    
    /**
     * Serializuje data objektu
     * @return array
     */
    public function serialize() {
        return serialize($this->checkedAnswers);
    }
    
    /**
     * Deserializuje předaná data a uloží je
     * @param CheckedAnswers::Array $array
     */
    public function unserialize($array) {
	$this->checkedAnswers = unserialize($array);
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