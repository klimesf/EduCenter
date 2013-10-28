<?php

namespace EduCenter;
use Nette\Application\UI\Control;

/**
 * Komponenta vypisující výsledky testů pro jednotlivého uživatele
 */
class TestResultsListControl extends Control {
    /** @var EduCenter\TestResultRepository */
    private $testResultRepository;
    /** @var test.id $testId */
    private $testId;
    /** @var int $limit */
    private $limit;
    /** @var Nette\Database\Table\Selection */
    private $selection;
    
    /**
     * Konstruktor komponenty
     * @param \EduCenter\EduCenter\TestResultRepository $testResultRepository
     * @param test.id $testId id testu, pro který vypisujeme výsledky, není povinný
     * @param int $limit kolik se má zobrazit otázek, není povinné
     */
    public function __construct(TestResultRepository $testResultRepository, $testId = null, $limit = null) {
	$this->testResultRepository = $testResultRepository;
	$this->testId = $testId;
	$this->limit = $limit;
    }
    
    /**
     * Render komponenty
     * @param test.id $testId pokud je zvoleno, najde pouze výsledky zadaného testu
     * @param int $limit pokud je zvoleno, vrátí pouze dané číslo nejnovějších příspěvků
     */
    public function render() {
	$userId = $this->getPresenter()->getUser()->getId();
	if($this->testId == null) {
	    // Pokud zobrazujeme posledních 5 výsledků, nehledě na test
	    $this->selection = $this->testResultRepository->findByUser($userId)->order('date DESC')->limit($this->limit);
	} else {
	    // Pokud je vybraný test
	    $this->selection = $this->testResultRepository->findByUserAndTest($userId, $this->testId)->order('date DESC')->limit($this->limit);
	}
	
	// Nastavíme šablonu
	$this->template->setFile(__DIR__ . '/TestResultsList.latte');
	// Předáme data šabloně
	$this->template->testResults = $this->selection;
	$this->template->hasLimit = ($this->limit != null) ? true : false;
	
	// Vykresíme šablonu
	$this->template->render();
    }
}