<?php

namespace EduCenter;

use Nette;

class QuestionRepository extends Repository {
    
    /**
     * Vrací otázku podle id
     * @param type $id
     */
    public function getById($id) {
	return $this->getTable()->get($id);
    }
    
    public function findById($id) {
	return $this->getTable()->where(array('id' => $id));
    }
    
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
   
    /**
     * 
     * @param type $id
     * @param type $text
     * @param type $img
     * @param type $points
     * @param type $unit
     */
    public function updateQuestion($id, $text, $img, $points, $unit)
    {
	$data = array(
	    'text' => $text,
	    'points' => $points,
	    'id_unit' => $unit
	);
	if($img != null) {  // Pokud uživatel vložil obrázek, uložíme ho
	    $data['img'] = $img;
	}
	return $this->getTable()->where(array('id' => $id))->update($data);
    }
    
    public function countByUnit($unit_id)
    {
	//return $this->getTable()->where(array('id_unit' => $unit_id))->count();
	return $this->getTable()->where(array('id_unit' => $unit_id))->count('id');
    }
    
}