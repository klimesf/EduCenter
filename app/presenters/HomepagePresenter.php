<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter {

    protected function startup() {
	parent::startup();
	// Tento presenter je nepřístupný pro nepřihlášené uživatele
	if (!$this->getUser()->isLoggedIn()) {
	    $this->redirect('Sign:in');
	}
    }
    
    public function renderDefault() {
	$this->template->anyVariable = 'any value';
    }

}
