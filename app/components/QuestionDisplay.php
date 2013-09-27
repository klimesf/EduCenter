<?php
namespace EduCenter;
use Nette\Application\UI\Control;
use Nette\Object;
use Nette\Http\Session;
use Nette\Diagnostics\Debugger;

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
    protected $questionId;
    protected $questionRepository;
    protected $answerRepository;
    private $session;
    private $checkedAnswers;
    
    /**
     * Konstuktor
     * @param type $question_id Id zobrazované otázky
     * @param \EduCenter\EduCenter\QuestionRepository $questionRepository
     * @param \EduCenter\EduCenter\AnswerRepository $answerRepository
     */
    public function __construct(QuestionRepository $questionRepository, AnswerRepository $answerRepository, Session $session, $question_id, $answered = NULL) {
	parent::__construct();
	$this->questionRepository = $questionRepository;
	$this->answerRepository = $answerRepository;
	
	// Práce se sessions
	$this->session = $session->getSection('QuestionDisplay');
	$this->session->setExpiration(0);
	
	// Načteme zaškrtnuté otázky ze session
	$this->checkedAnswers = new CheckedAnswers;
	if(isset($this->session->checkedAnswers))
	    $this->checkedAnswers->unserialize($this->session->checkedAnswers);
		
	$this->questionId = $question_id;
	if($answered) {
	    $this->answered = $answered;
	} else {
	    $this->answered = false;
	}
    }
    
    
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
	$this->answered = true;
    }
	    
    /**
     * Vykreslení komponenty
     */
    public function render() {
	// Nastavení šablony
	$template = $this->template;
	$template->setFile(__DIR__ . '/QuestionDisplay.latte');
	
	// Získáme data pro vykreslování
	$question = $this->questionRepository->findBy(array('id' => $this->questionId))->fetch();
	$answers = $this->answerRepository->findBy(array('id_question' => $this->questionId))->order('RAND()');
	
	// Předáme veškerá potřebná data šabloně
	$this->template->question = $question;
	$this->template->answers = $answers;
	$this->template->answered = $this->answered;
	$this->template->checkedAnswers = $this->checkedAnswers;
	
	// Vykreslíme šablonu
	$template->render();
    }
}



class CheckedAnswers extends Object implements \Serializable {
    private $array = array();
    
    public function addCheckedAnswer($answerId) {
	$this->array[] = $answerId;
    }
    
    public function deleteCheckedAnswer($answerId) {
	$key = array_search($answerId, $this->array);
	unset($this->array[$key]);
    }
    
    public function isAnswerChecked($answerId) {
	foreach($this->array as $array) {
	    if($array == $answerId)
		return true;
	}
	return false;
    }
    
    public function serialize() {
        return serialize($this->array);
    }
    
    public function unserialize($array) {
	$this->array = unserialize($array);
    }
}