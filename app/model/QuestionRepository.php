<?php

namespace EduCenter;

use Nette;

class QuestionRepository extends Repository {
    
    /**
     * Vrací řádky otázek patřící do jedné kategorie
     * 
     * @param $id id kategorie
     * @return Nette\Database\Table\Selection
     */
    public function findByUnit($id)
    {
	return $this->findBy(array('id_unit' => $id));
    }
    
    public function addQuestion($text, $img, $points, $unit)
    {
	return $this->getTable()->insert(array(
		'text' => $text,
		'img' => $img,
		'points' => $points,
		'id_unit' => $unit
	));
    }
    
    public function countByUnit($unit_id)
    {
	//return $this->getTable()->where(array('id_unit' => $unit_id))->count();
	return $this->getTable()->where(array('id_unit' => $unit_id))->count('id');
    }
    
}