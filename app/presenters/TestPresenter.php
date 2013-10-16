<?php

class TestPresenter extends BasePresenter {
    private $testRepository;
    private $testSettingRepository;
    private $testId;
    
    protected function startup() {
	parent::startup();
	// Tento presenter je nepřístupný pro nepřihlášené uživatele
	if (!$this->getUser()->isLoggedIn()) {
	    $this->redirect('Sign:in');
	}
    }
    
    public function inject(EduCenter\TestRepository $testRepository, EduCenter\TestSettingRepository $testSettingRepository) {
	$this->testRepository = $testRepository;
	$this->testSettingRepository = $testSettingRepository;
    }
    
    public function actionDefault() {
	$this->template->tests = $this->testRepository->findAll();
    }
    
    public function actionOverview($testId) {
	$this->template->test = $this->testRepository->getById($testId);
	$this->template->settings = $this->testSettingRepository->findByTest($testId);
    }
    
    public function actionRun($testId) {
	// Zjistíme, zda už byl test vytvořen
	$session = $this->session->getSection('Test');
	if(!isset($session->test)) {
	    $this->assembleTest($testId);
	}
    }

    /**
     * Sestaví test podle zadaného Id
     * @param type $testId
     */
    protected function assembleTest($testId) {
	$this->testId = $testId;
	$session = $this->session->getNamespace('Test');
	if(isset($session->testId)) {
	    
	}
    }
    
    
}