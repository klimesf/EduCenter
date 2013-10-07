<?php

class TestPresenter extends BasePresenter {
    private $testId;
    
    protected function startup() {
	parent::startup();
	// Tento presenter je nepřístupný pro nepřihlášené uživatele
	if (!$this->getUser()->isLoggedIn()) {
	    $this->redirect('Sign:in');
	}
    }
    
    public function actionDefault() {
	
    }
    
    public function actionBrowse($testId) {
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
    public function assembleTest($testId) {
	$this->testId = $testId;
    }
    
    
}