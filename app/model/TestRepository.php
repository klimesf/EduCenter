<?php

namespace EduCenter;

use Nette;

class TestRepository extends Repository {
    public function getById($id) {
	return $this->getTable()->get($id);
    }
}