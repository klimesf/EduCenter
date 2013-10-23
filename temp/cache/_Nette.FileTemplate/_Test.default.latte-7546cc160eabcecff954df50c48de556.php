<?php //netteCache[01]000371a:2:{s:4:"time";s:21:"0.33477000 1382018071";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:49:"D:\Web\EduCenter\app\templates\Test\default.latte";i:2;i:1382018069;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Test\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'mzonmoavr7')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbe83609badb_content')) { function _lbe83609badb_content($_l, $_args) { extract($_args)
;call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars())  ?>

<div class="unit-list">
<?php $iterations = 0; foreach ($tests as $test): ?>
<a href="<?php echo htmlSpecialChars($_control->link("Test:overview", array($test->id))) ?>
">
<div class="unit">
    <img src="<?php echo htmlSpecialChars($basePath) ?>/images/tests/<?php echo htmlSpecialChars($test->img) ?>
" alt="<?php echo htmlSpecialChars($test->name) ?>" />
    <div class="name"><?php echo Nette\Templating\Helpers::escapeHtml($test->name, ENT_NOQUOTES) ?></div>
    <div class="desc"><?php echo $test->desc ?></div>
</div>
</a>
<?php $iterations++; endforeach ?>
</div>

<?php
}}

//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb108a35717f_title')) { function _lb108a35717f_title($_l, $_args) { extract($_args)
?><h1>Seznam dostupných testů</h1>
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