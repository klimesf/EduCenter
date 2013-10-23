<?php

namespace EduCenter;

use Nette;

class TestResultRepository extends Repository {
    public function findByTest($testId) {
	return $this->findBy(array("id_test" => $testId));
    }
    
    public function findByUser($userId) {
	return $this->findBy(array('id_user' => $userId));
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
