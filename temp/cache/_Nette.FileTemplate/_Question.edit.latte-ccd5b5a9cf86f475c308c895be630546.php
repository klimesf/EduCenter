<?php //netteCache[01]000372a:2:{s:4:"time";s:21:"0.01900000 1379638733";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:50:"D:\Web\EduCenter\app\templates\Question\edit.latte";i:2;i:1379638730;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Question\edit.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'idiksaow50')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb4417fd7334_content')) { function _lb4417fd7334_content($_l, $_args) { extract($_args)
?><h1>Upravit otázku</h1>

<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("editQuestionForm") ? "editQuestionForm" : $_control["editQuestionForm"]), array()) ?>
<div class="new-question-form">
<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $_control->getComponent($form); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render('errors') ?>
    <div class="pair">
<?php $_input = is_object("text") ? "text" : $_form["text"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
	<div class="input"><?php $_input = (is_object("text") ? "text" : $_form["text"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>

    <div class="pair">
	<?php $_input = is_object("img") ? "img" : $_form["img"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
 <div class="input"><?php $_input = (is_object("img") ? "img" : $_form["img"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>

    <div class="pair">
	<?php $_input = is_object("unit") ? "unit" : $_form["unit"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
 <div class="input"><?php $_input = (is_object("unit") ? "unit" : $_form["unit"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>

    <div class="pair">
	<?php $_input = is_object("points") ? "points" : $_form["points"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
 <div class="input"><?php $_input = (is_object("points") ? "points" : $_form["points"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>

    <div class="spacer"></div>

    <div class="pair">
<?php $_input = is_object("answer1") ? "answer1" : $_form["answer1"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
	<div class="input"><?php $_input = (is_object("answer1") ? "answer1" : $_form["answer1"]); echo $_input->getControl()->addAttributes(array()) ?></div>
	<div class="input"><?php $_input = (is_object("answer1correct") ? "answer1correct" : $_form["answer1correct"]); echo $_input->getControl()->addAttributes(array()) ?>
 <?php $_input = is_object("answer1correct") ? "answer1correct" : $_form["answer1correct"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?></div>
    </div>

    <div class="pair">
<?php $_input = is_object("answer2") ? "answer2" : $_form["answer2"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
	<div class="input"><?php $_input = (is_object("answer2") ? "answer2" : $_form["answer2"]); echo $_input->getControl()->addAttributes(array()) ?></div>
	<div class="input"><?php $_input = (is_object("answer2correct") ? "answer2correct" : $_form["answer2correct"]); echo $_input->getControl()->addAttributes(array()) ?>
 <?php $_input = is_object("answer2correct") ? "answer2correct" : $_form["answer2correct"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?></div>
    </div>

    <div class="pair">
<?php $_input = is_object("answer3") ? "answer3" : $_form["answer3"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
	<div class="input"><?php $_input = (is_object("answer3") ? "answer3" : $_form["answer3"]); echo $_input->getControl()->addAttributes(array()) ?></div>
	<div class="input"><?php $_input = (is_object("answer3correct") ? "answer3correct" : $_form["answer3correct"]); echo $_input->getControl()->addAttributes(array()) ?>
 <?php $_input = is_object("answer3correct") ? "answer3correct" : $_form["answer3correct"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?></div>
    </div>

    <div class="pair">
<?php $_input = is_object("answer4") ? "answer4" : $_form["answer4"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
	<div class="input"><?php $_input = (is_object("answer4") ? "answer4" : $_form["answer4"]); echo $_input->getControl()->addAttributes(array()) ?></div>
	<div class="input"><?php $_input = (is_object("answer4correct") ? "answer4correct" : $_form["answer4correct"]); echo $_input->getControl()->addAttributes(array()) ?>
 <?php $_input = is_object("answer4correct") ? "answer4correct" : $_form["answer4correct"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?></div>
    </div>

    <div class="pair">
	<div class="input"><?php $_input = (is_object("save") ? "save" : $_form["save"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>

</div>
<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>

<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>

<?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 