<?php //netteCache[01]000375a:2:{s:4:"time";s:21:"0.34013200 1378182623";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:53:"D:\Web\NetteSandbox\app\templates\User\password.latte";i:2;i:1378182329;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\NetteSandbox\app\templates\User\password.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'jwrf0yb99i')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbdabd630414_content')) { function _lbdabd630414_content($_l, $_args) { extract($_args)
;call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars())  ?>

<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("passwordForm") ? "passwordForm" : $_control["passwordForm"]), array()) ?>
<div class="password-form">
<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $_control->getComponent($form); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render('errors') ?>

    <div class="pair">
<?php $_input = is_object("oldPassword") ? "oldPassword" : $_form["oldPassword"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
        <div class="input"><?php $_input = (is_object("oldPassword") ? "oldPassword" : $_form["oldPassword"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>
    <div class="pair">
<?php $_input = is_object("newPassword") ? "newPassword" : $_form["newPassword"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
        <div class="input"><?php $_input = (is_object("newPassword") ? "newPassword" : $_form["newPassword"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>
    <div class="pair">
<?php $_input = is_object("confirmPassword") ? "confirmPassword" : $_form["confirmPassword"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
        <div class="input"><?php $_input = (is_object("confirmPassword") ? "confirmPassword" : $_form["confirmPassword"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>
    <div class="pair">
        <div class="input"><?php $_input = (is_object("set") ? "set" : $_form["set"]); echo $_input->getControl()->addAttributes(array()) ?></div>
    </div>
</div>
<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ;
}}

//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbab4263a2a6_title')) { function _lbab4263a2a6_title($_l, $_args) { extract($_args)
?><h1>Změna hesla</h1>
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