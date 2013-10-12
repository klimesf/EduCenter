<?php //netteCache[01]000377a:2:{s:4:"time";s:21:"0.59781600 1381590087";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:55:"D:\Web\EduCenter\app\templates\Question\addReport.latte";i:2;i:1381590086;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Question\addReport.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'dnpbtwzf14')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbab914b215b_content')) { function _lbab914b215b_content($_l, $_args) { extract($_args)
?><h1>Nahlášení problému s otázkou</h1>
<div class="new-question-form">
<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("reportForm") ? "reportForm" : $_control["reportForm"]), array()) ;if (is_object($form)) $_ctrl = $form; else $_ctrl = $_control->getComponent($form); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render('errors') ?>
    <div class="pair">
<?php $_input = is_object("text") ? "text" : $_form["text"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
	<div class="input"><?php $_input = (is_object("text") ? "text" : $_form["text"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>
    <div class="pair">
	<div class="input"><?php $_input = (is_object("report") ? "report" : $_form["report"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>
    <div class="spacer"></div>
<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
</div>
<h2>Znění otázky</h2>
<?php $_ctrl = $_control->getComponent("questionDisplay"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->renderById() ;
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
if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 