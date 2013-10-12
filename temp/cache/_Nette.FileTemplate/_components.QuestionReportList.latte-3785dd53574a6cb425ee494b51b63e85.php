<?php //netteCache[01]000378a:2:{s:4:"time";s:21:"0.56373800 1381600873";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:56:"D:\Web\EduCenter\app\components\QuestionReportList.latte";i:2;i:1381600872;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\components\QuestionReportList.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'p3bryp0l5u')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbe919df901b_content')) { function _lbe919df901b_content($_l, $_args) { extract($_args)
?>    <div class="report-list">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($reports) as $report): ?>
	<div<?php if ($_l->tmp = array_filter(array($iterator->odd ? 'odd' : 'even', $report->resolved ? 'resolved':null))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>>
	    <div class="text"><strong>Popis problému:</strong> <?php echo Nette\Templating\Helpers::escapeHtml($report->text, ENT_NOQUOTES) ?></div>
	    <div class="commentary"><?php echo Nette\Templating\Helpers::escapeHtml($report->commentary, ENT_NOQUOTES) ?></div>
	    <div class="date"><strong>Přidáno:</strong> <?php echo Nette\Templating\Helpers::escapeHtml($report->date->format("d.m.Y"), ENT_NOQUOTES) ?></div>
	    <a href="<?php echo htmlSpecialChars($_presenter->link("Question:edit", array($report->questionId))) ?>">Zobrazit otázku</a>
<?php if (!$report->resolved): ?>
	    | <a href="<?php echo htmlSpecialChars($_control->link("markResolved!", array($report->id))) ?>
">Označit jako vyřešené</a>
<?php endif ?>
	</div>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
    </div>
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