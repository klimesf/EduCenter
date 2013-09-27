<?php

class TestPresenter extends BasePresenter {
    
    protected function startup() {
	parent::startup();
	// Tento presenter je nepřístupný pro nepřihlášené uživatele
	if (!$this->getUser()->isLoggedIn()) {
	    $this->redirect('Sign:in');
	}
    }
    
    public function actionDefault() {
	
    }
    
}