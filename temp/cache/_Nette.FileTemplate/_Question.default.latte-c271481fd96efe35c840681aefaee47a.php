<?php //netteCache[01]000375a:2:{s:4:"time";s:21:"0.71812100 1381851740";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:53:"D:\Web\EduCenter\app\templates\Question\default.latte";i:2;i:1381851734;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Question\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'ce7ytto751')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb0776a74c9c_content')) { function _lb0776a74c9c_content($_l, $_args) { extract($_args)
;call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars())  ?>
<div class="unit-list">
<?php $iterations = 0; foreach ($units as $unit): ?>
<a href="<?php echo htmlSpecialChars($_control->link("Question:browseByUnit", array($unit->id))) ?>
">
<div class="unit">
    <img src="<?php echo htmlSpecialChars($basePath) ?>/images/units/<?php echo htmlSpecialChars($unit->img) ?>
" alt="<?php echo htmlSpecialChars($unit->name) ?>" />
    <div class="name"><?php echo Nette\Templating\Helpers::escapeHtml($unit->name, ENT_NOQUOTES) ?></div>
    <div class="desc"><?php echo Nette\Templating\Helpers::escapeHtml($unit->description, ENT_NOQUOTES) ?></div>
    <div class="numberOfQuestions">Počet otázek: <?php echo Nette\Templating\Helpers::escapeHtml($questionRepository->countByUnit($unit->id), ENT_NOQUOTES) ?></div>
</div>
</a>
<?php $iterations++; endforeach ?>
</div>
<?php
}}

//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb3ee33597ea_title')) { function _lb3ee33597ea_title($_l, $_args) { extract($_args)
?><h1>Procházení otázek</h1>
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
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 