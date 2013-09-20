<?php

namespace EduCenter;

use Nette;

class QuestionViewerControl extends Nette\Application\UI\Control {
    public $answered = FALSE;
    private $answerRepository;

    public function __construct(Nette\Database\Table\Selection $selected) {
	parent::__construct(); // vždy je potřeba volat rodičovský konstruktor
	$this->selected = $selected;
    }

    public function render() {
	$this->template->setFile(__DIR__ . '/QuestionViewer.latte');
	$this->template->question = $this->selected;
	$this->template->answered = $this->answered;
	$this->template->www_dir = $this->context->parameters['wwwDir'];
	//$this->template->answers = $this->answerRepository->findBy(array('id_question' => $this->selected->id));
	$this->template->render();
    }
}