<?php

namespace EduCenter;

use Nette\Application\UI\Control;
use Nette\Utils\Paginator;

class QuestionPaginator extends Control {
    /** @var Nette\Paginator */
    private $paginator;

    /** @persistent */
    public $page = 1;

    /**
     * @return Nette\Paginator
     */
    public function getPaginator() {
	if (!$this->paginator) {
	    $this->paginator = new Paginator;
	}
	return $this->paginator;
    }

    /**
     * Renderuje paginator
     * @return void
     */
    public function render()
    {
	$paginator = $this->getPaginator();
	$page = $paginator->page;
	if ($paginator->pageCount < 2) {
	    $steps = array($page);

	} else {
	    $arr = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
	    $count = 4;
	    $quotient = ($paginator->pageCount - 1) / $count;
	    for ($i = 0; $i <= $count; $i++) {
		$arr[] = round($quotient * $i) + $paginator->firstPage;
	    }
	    sort($arr);
	    $steps = array_values(array_unique($arr));
	}

	$this->template->steps = $steps;
	$this->template->paginator = $paginator;
	$this->template->setFile(dirname(__FILE__) . '/QuestionPaginator.latte');
	$this->template->render();
    }

    /**
     * Renderuje paginator pro test
     * @return void
     */
    /*public function renderTest() {
	$this->template->steps = $steps;
	$this->template->paginator = $paginator;
	$this->template->setFile(dirname(__FILE__) . '/paginator.latte');
	$this->template->render();
    }*/

    /**
     * Loads state informations.
     * @param  array
     * @return void
     */
    public function loadState(array $params)
    {
	    parent::loadState($params);
	    $this->getPaginator()->page = $this->page;
    }
}