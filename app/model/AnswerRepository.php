<?php

namespace EduCenter;

use Nette;

class AnswerRepository extends Repository {
    
    /**
     * Vrací řádky odpovědí patřící k jedné otázce
     * 
     * @param $id id otázky
     * @return Nette\Database\Table\Selection
     */
    public function findByQuestion($id)
    {
	return $this->findBy(array('id_question' => $id));
    }
    
    /**
     * Vrátí odpověď podle daného Id
     * @param int $id Id hledané odpovědi
     * @return EduCenter\Answer
     */
    public function getById($id) {
	$sel = $this->getTable()->get($id);
	return new Answer($sel->id, $sel->text, $sel->correct, $sel->questionId);
    }
    
    /**
     * Vrátí pole odpovědí patřící otázce s daným Id
     * @param int $questionId
     * @return array EduCenter\Answer
     */
    /*public function findByQuestion($questionId) {
	$sel = $this->getTable()->findBy(array('id_question' => $questionId));
	$arr = array();
	foreach($sel as $sel) {
	    $arr[] = new Answer($sel->id, $sel->text, $sel->correct, $sel->questionId);
	}
	return $arr;
    }*/
     
    public function addAnswer($text, $correct, $question_id)
    {
	return $this->getTable()->insert(array(
		'text' => $text,
		'correct' => $correct,
		'id_question' => $question_id
	));
    }
    
    public function updateAnswer($id, $text, $correct)
    {
	$data = array(
	    'text' => $text,
	    'correct' => $correct
	);
	return $this->getTable()->where(array('id' => $id))->update($data);
    }
}