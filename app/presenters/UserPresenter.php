<?php

use Nette\Application\UI\Form;


/**
 * @property callable $passwordFormSubmitted
 */
class UserPresenter extends BasePresenter {

    /** @var EduCenter\UserRepository */
    private $userRepository;

    /** @var EduCenter\Authenticator */
    private $authenticator;
    
    /** @var EduCenter\TestResultsRepository */
    private $testResultRepository;
    
    /** @var int $testResultsLimit limit zobrazených výsledků testů */
    private $testResultsLimit;
    
    /** @var test.id $testId */
    private $testId;
    
    /**
     * Injekce závislostí (DI)
     * @param EduCenter\UserRepository $userRepository
     * @param EduCenter\Authenticator $authenticator
     * @param EduCenter\TestResultRepository $testResultRepository
     */
    public function inject(EduCenter\UserRepository $userRepository, EduCenter\Authenticator $authenticator, EduCenter\TestResultRepository $testResultRepository) {
	$this->userRepository = $userRepository;
	$this->authenticator = $authenticator;
	$this->testResultRepository = $testResultRepository;
    }

    /**
     * Startup presenteru
     */
    protected function startup() {
	parent::startup();
	// Tento presenter je nepřístupný pro nepřihlášené uživatele
	if (!$this->getUser()->isLoggedIn()) {
	    $this->redirect('Sign:in');
	}
    }

    /**
     * Defaultní akce
     */
    public function actionDefault() {
	// Nastavení pro TestResultsList
	$this->testResultsLimit = 5;
	$this->testId = null;
    }
    
    /**
     * Render defaultní akce
     */
    public function renderDefault() {
	
    }

    /**
     * Továrnička pro komponentu TestResultsList
     * @return \EduCenter\TestResultsListControl
     */
    protected function createComponentTestResultsList() {
	return new EduCenter\TestResultsListControl($this->testResultRepository, $this->testId, $this->testResultsLimit);
    }
    
    /**
     * @return Nette\Application\UI\Form
     */
    protected function createComponentPasswordForm() {
	$form = new Form();
	$form->addPassword('oldPassword', 'Staré heslo:', 30)
	    ->addRule(Form::FILLED, 'Je nutné zadat staré heslo.');
	$form->addPassword('newPassword', 'Nové heslo:', 30)
	    ->addRule(Form::MIN_LENGTH, 'Nové heslo musí mít alespoň %d znaků.', 6);
	$form->addPassword('confirmPassword', 'Potvrzení hesla:', 30)
	    ->addRule(Form::FILLED, 'Nové heslo je nutné zadat ještě jednou pro potvrzení.')
	    ->addRule(Form::EQUAL, 'Zadná hesla se musejí shodovat.', $form['newPassword']);

	$form->addSubmit('set', 'Změnit heslo');
	$form->onSuccess[] = $this->passwordFormSubmitted;

	return $form;
    }

    /**
     * Metoda volaná při úspěšném odeslání PasswordForm
     * @param \Nette\Application\UI\Form $form
     */
    public function passwordFormSubmitted(Form $form) {
	$values = $form->getValues();
	$user = $this->getUser();

	try {
	    $this->authenticator->authenticate(array(
		$user->getIdentity()->username,
		$values->oldPassword
	    ));
	    $this->authenticator->setPassword($user->getId(), $values->newPassword);

	    $this->flashMessage('Heslo bylo změněno.', 'success');
	    $this->redirect('Homepage:');

	} catch (Nette\Security\AuthenticationException $e) {
	    $form->addError('Zadané heslo není správné.');
	}
    }
}