<?php //netteCache[01]000375a:2:{s:4:"time";s:21:"0.47008500 1381851862";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:53:"D:\Web\EduCenter\app\templates\Homepage\default.latte";i:2;i:1381851846;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Homepage\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'wqp8fm4hy9')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb7be282d83c_title')) { function _lb7be282d83c_title($_l, $_args) { extract($_args)
?>Domovská stránka<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb44ac875b84_content')) { function _lb44ac875b84_content($_l, $_args) { extract($_args)
?><h1>EduCenter</h1>

<h2>O projektu</h2>
<p>Projekt vznikl za účelem snadného e-testování. Podnětem bylo blížící se studium k přijmacím zkouškám na medicínu. První databáze otázek jsou tedy modelové otázky pro přijímací zkoušky na <i>2. Lékařskou Fakultu Univerzity Karlovy</i>.
Dále bych chtěl databázi rozšířit o další sady otázek k přijímacím zkouškám.</p>
<h2>Zdravím Mišáka a přeji příjemné učení :P</2>

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
if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars())  ?>



<?php call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 