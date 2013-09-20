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
    
    public function addAnswer($text, $correct, $question_id)
    {
	return $this->getTable()->insert(array(
		'text' => $text,
		'correct' => $correct,
		'id_question' => $question_id
	));
    }
}