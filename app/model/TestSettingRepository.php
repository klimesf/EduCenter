<?php

namespace EduCenter;

use Nette;

class TestSettingRepository extends Repository {
    public function findByTest($testId) {
	return $this->findBy(array("id_test" => $testId));
    }
}