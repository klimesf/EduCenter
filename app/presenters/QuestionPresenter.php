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
    
    /**
     * Id zobrazované otázky
     * @var int(11) 
     */
    private $question_id;

    public function inject(EduCenter\UserRepository $userRepository, EduCenter\Authenticator $authenticator, EduCenter\QuestionRepository $questionRepository,
	    EduCenter\AnswerRepository $answerRepository, EduCenter\UnitRepository $unitRepository)
    {
	$this->userRepository = $userRepository;
	$this->authenticator = $authenticator;
	$this->questionRepository = $questionRepository;
	$this->unitRepository = $unitRepository;
	$this->answerRepository = $answerRepository;
    }
    
    protected function startup() {
	parent::startup();
	// Tento presenter je nepřístupný pro nepřihlášené uživatele
	if (!$this->getUser()->isLoggedIn()) {
	    $this->redirect('Sign:in');
	}
    }

    
    /* --- AKCE --------------------------------------------------------------*/
    
    
    public function actionDefault()
    {
	$this->template->units = $this->unitRepository->findAll();
	$this->template->questionRepository = $this->questionRepository;
    }
    
    public function actionBrowseByUnit($unit_id) {
	$select = $this->questionRepository->findBy(array('id_unit' => $unit_id))->order('id ASC')->fetch();
	if($select) {
	    $this->redirect('Question:browse', $select->id);
	} else {
	    $this->flashMessage ('Tato kategorie neobsahuje žádné otázky.', 'error');
	    $this->redirect('Question:');
	}
    }
    
    public function actionBrowse($question_id)
    {
	$this->question_id = $question_id;
    }
    
    public function actionAdd()
    {

    }
    
    public function actionEdit($question_id) {
	$this->template->question_id = $question_id;
	
    }
    
    
    /* --- Továrničky --------------------------------------------------------*/
    
    /**
     * Továrnička vytvářející komponentu QuestionDisplay
     * @param type $id		id zobrazované otázky
     * @param type $answered	volitelná proměnná - je otázka zodpovězena?
     * @return \EduCenter\QuestionDisplayControl    vytvořená komponenta
     */
    protected function createComponentQuestionDisplay() {
	return new EduCenter\QuestionDisplayControl($this->questionRepository, $this->answerRepository, $this->context->session, $this->question_id);
    }
    
    
    
    
    protected function createComponentNewQuestionForm()
    {
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

	$form->addSubmit('insert', 'Vložit');

	// call method signInFormSucceeded() on success
	$form->onSuccess[] = $this->newQuestionFormSucceeded;
	return $form;
    }
    
    
    
    public function newQuestionFormSucceeded(Form $form) {
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
    
    
    
    protected function createComponentEditQuestionForm()
    {
	$question = $this->questionRepository->findBy(array('id' => $this->template->question_id))->fetch();
	$answers = $this->answerRepository->findBy(array('id_question' => $this->template->question_id));
	if(!$question) {
	    throw new BadRequestException;
	}
	$unitPairs = $this->unitRepository->findAll()->fetchPairs('id', 'name');
	
	$form = new UI\Form;
	$form->addHidden('id')->setValue($question->id);
	$form->addTextArea('text', 'Zadání otázky:')
		->setRequired('Prosím vyplňte zadání otázky.')
		->setValue($question->text);
	
	$form->addUpload('img', 'Obrázek k otázce:')
		->addCondition(Form::FILLED)
		->addRule(Form::IMAGE, 'Soubor musí být obrázek.');
	
	$form->addSelect('unit', 'Kategorie:', $unitPairs)
		->setDefaultValue($question->id_unit)
		->addRule(Form::FILLED, 'Je nutné vybrat do jaké kategorie otázka patří.');
	
	$form->addText('points', 'Počet bodů:', 3)
		->addRule(Form::INTEGER, 'Počet bodů musí být číslo.')
		->setValue($question->points);
	
	
	$i = 1;
	foreach($answers as $answer) {
	    $form->addHidden('answer'.$i.'id')->setValue($answer->id);
	    $form->addText("answer".$i, 'První odpověď:', 50, 255)
		    ->setRequired('Prosím vyplňte znění odpovědi.')
		    ->setValue($answer->text);
	    $form->addCheckbox("answer".$i."correct", 'Správná odpověď');
	    
	    $i++;
	}

	$form->addSubmit('save', 'Uložit');

	// call method signInFormSucceeded() on success
	$form->onSuccess[] = $this->editQuestionFormSucceeded;
	return $form;
    }
    
    public function editQuestionFormSucceeded(Form $form) {
	$update = array(
	    'text' => $form->values->text,
	    'id_unit' => $form->values->unit,
	    'points' => $form->values->points
	);
	$this->questionRepository->update(array('id' => $form->values->id), $update);
	
	$this->flashMessage('Otázka upravena.', 'success');
    }
    
    protected function createComponentQuestionViewer() {
	
    }
}