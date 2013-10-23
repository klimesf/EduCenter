<?php

namespace EduCenter;

use Nette;

class UnitRepository extends Repository {

    public function getUnitName($unitId) {
	return $this->getTable()->get($unitId)->name;
    }

}