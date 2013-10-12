<?php

namespace EduCenter;

use Nette\Application\UI\Control;

class QuestionReportListControl extends Control {
    /** @var EduCenter\QuestionReportRepository */
    private $questionReportRepository;
    /** @var int */
    private $questionId;
    
    /**
     * Konstruktor třídy
     * @param \EduCenter\QuestionReportRepository $questionReportRepository
     */
    public function __construct(QuestionReportRepository $questionReportRepository, $questionId = null) {
	parent::__construct();
	$this->questionReportRepository = $questionReportRepository;
	$this->questionId = $questionId;
    }
    
    public function handleMarkResolved($id) {
	$this->questionReportRepository->setResolved($id, $this->getPresenter()->getUser()->getId());
	$this->flashMessage('Problém vyřešen.', 'success');
    }
    
    /**
     * Vypisujeme reporty pro konkrétní otázku
     */
    public function renderByQuestion() {
	$this->template->setFile(__DIR__ . '/QuestionReportList.latte');
	$this->template->reports = $this->questionReportRepository->findByQuestion($this->questionId)->order('date DESC');
	$this->template->render();
    }
    
    /**
     * Render vypisující všechny reporty
     */
    public function renderAll() {
	$this->template->setFile(__DIR__ . '/QuestionReportList.latte');
	$this->template->reports = $this->questionReportRepository->findAllUnresolved()->order('date DESC');
	$this->template->render();
    }
}