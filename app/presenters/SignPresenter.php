<?php

use Nette\Application\UI;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{

    public function actionSettings()
    {
	
    }
    
    public function actionOut()
    {
	$this->getUser()->logout();
	$this->flashMessage('Byl jste odhlášen.');
	$this->redirect('in');
    }
    
    protected function createComponentSettingsForm()
    {
	
    }
    
    public function settingsFormSucceeded()
    {
	
    }
    
    /**
     * Sign-in form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm()
    {
	    $form = new UI\Form;
	    $form->addText('username', 'Alias:', 40)
		    ->setRequired('Prosím vyplňte své přihlašovací jméno.');

	    $form->addPassword('password', 'Heslo:', 40)
		    ->setRequired('Prosím zadejte heslo.');

	    $form->addCheckbox('remember', 'Zapamatovat si mě na tomto počítači');

	    $form->addSubmit('send', 'Přihlásit se');

	    // call method signInFormSucceeded() on success
	    $form->onSuccess[] = $this->signInFormSucceeded;
	    return $form;
    }


    public function signInFormSucceeded($form) {
	$values = $form->getValues();

	if ($values->remember) {
	    $this->getUser()->setExpiration('+30 days', FALSE);
	} else {
	    $this->getUser()->setExpiration('20 minutes', TRUE);
	}

	try {
	    $this->getUser()->login($values->username, $values->password);
	    $this->flashMessage('Přihlášení bylo úspěšné', 'success');
	    $this->redirect('Homepage:');
	} catch (Nette\Security\AuthenticationException $e) {
	    $form->addError($e->getMessage());
	}
    }
}
