<?php

namespace EduCenter;

/**
 * Model obsluhující tabulku 'testresult', která obsahuje výsledky testů
 * © 2013, Filip Klimeš
 */
class TestResultRepository extends Repository {
    /**
     * Vrátí výsledky testů podle zadaného testu
     * @param test.id $testId
     * @return Nette\Database\Table\Selection
     */
    public function findByTest($testId) {
	return $this->findBy(array("id_test" => $testId));
    }
    
    /**
     * Vrátí výsledky testů podle zadaného uživatele
     * @param user.id $userId
     * @return Nette\Database\Table\Selection
     */
    public function findByUser($userId) {
	return $this->findBy(array('id_user' => $userId));
    }
    
    /**
     * Vrátí výsledky testů podle zadaného testu a uživatele
     * @param user.id $userId
     * @param test.id $testId
     * @return Nette\Database\Table\Selection
     */
    public function findByUserAndTest($userId, $testId) {
	return $this->findBy(array('id_user' => $userId, 'id_test' => $testId));
    }
    
    /**
     * Vloží nový výsledek testu
     * @param type $testId	    id testu
     * @param type $userId	    id uživatele, který test absolvoval
     * @param type $date	    datum ve formátu YYYY-MM-DD
     * @param type $successRate	    úspěšnost v procentech, zaokrouhleno na celá
     */
    public function insert($testId, $userId, $date, $successRate) {
	$data = array(
	    'id_test' => $testId,
	    'id_user' => $userId,
	    'date' => $date,
	    'success_rate' => $successRate
	);
	$this->getTable()->insert($data);
    }
}
