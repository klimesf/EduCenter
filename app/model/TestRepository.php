<?php

namespace EduCenter;

use Nette;

class TestRepository extends Repository {
    public function getById($id) {
	$this->getTable()->get($id);
    }
}