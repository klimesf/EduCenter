<?php

namespace EduCenter;

class QuestionReportRepository extends Repository {
    public function findAllUnresolved() {
	return $this->getTable()->where(array('resolved' => 0));
    }
    
    public function findByQuestion($questionId) {
	return $this->findBy(array('questionId' => $questionId));
    }

    public function addReport($text, $userId, $questionId) {
	
	$date = new \Nette\DateTime('NOW');
	return $this->getTable()->insert(array(
	    'text' => $text,
	    'addedBy' => $userId,
	    'questionId' => $questionId,
	    'date' => $date->format("Y-m-d")
	));
    }
    
    public function setResolved($id, $userId) {
	return $this->getTable()->where(array('id' => $id))->update(array('resolved' => 1, 'resolvedBy' => $userId));
    }
    
    public function addComentary($id, $commentary) {
	return $this->getTable()->where(array('id' => $id))->update(array('commentary' => $commentary));
    }
}