<?php //netteCache[01]000372a:2:{s:4:"time";s:21:"0.41532800 1382556684";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:50:"D:\Web\EduCenter\app\templates\Test\evaluate.latte";i:2;i:1382556403;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Test\evaluate.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'h1ohguktqj')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbfcb9e74e15_title')) { function _lbfcb9e74e15_title($_l, $_args) { extract($_args)
?>Výsledky testu
<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb4024a51270_content')) { function _lb4024a51270_content($_l, $_args) { extract($_args)
;
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
call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()) ; call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; Nette\Diagnostics\Debugger::barDump(array('$successRate' => $successRate), "Template " . str_replace(dirname(dirname($template->getFile())), "\xE2\x80\xA6", $template->getFile())) ;Nette\Diagnostics\Debugger::barDump(array('$correctArray' => $correctArray), "Template " . str_replace(dirname(dirname($template->getFile())), "\xE2\x80\xA6", $template->getFile())) ;Nette\Diagnostics\Debugger::barDump(array('$wrongAnswers' => $wrongAnswers), "Template " . str_replace(dirname(dirname($template->getFile())), "\xE2\x80\xA6", $template->getFile())) ;