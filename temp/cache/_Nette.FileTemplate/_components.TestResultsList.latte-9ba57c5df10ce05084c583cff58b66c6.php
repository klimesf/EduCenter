<?php //netteCache[01]000375a:2:{s:4:"time";s:21:"0.58323900 1382889172";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:53:"D:\Web\EduCenter\app\components\TestResultsList.latte";i:2;i:1382889166;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\components\TestResultsList.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'h4yytsty4p')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb15c3eb830d_content')) { function _lb15c3eb830d_content($_l, $_args) { extract($_args)
?><div class="test-results-list">
<?php if ($testResults->count() == 0): ?>
    <div class="odd">Zatím nemáte žádné výsledky testů.</div>
<?php else: $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($testResults) as $result): ?>
	<div<?php if ($_l->tmp = array_filter(array($iterator->isOdd() ? 'odd' : 'even'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>>
	<span class="date"><?php echo Nette\Templating\Helpers::escapeHtml($result->date, ENT_NOQUOTES) ?>
:</span> <a href="<?php echo htmlSpecialChars($_presenter->link("Test:overview", array($result->id_test))) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($result->test->name, ENT_NOQUOTES) ?>
</a> - <?php echo Nette\Templating\Helpers::escapeHtml($result->success_rate, ENT_NOQUOTES) ?>%
	</div>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ;if ($hasLimit): ?>
	<a href="<?php echo htmlSpecialChars($_presenter->link("TestResult:All")) ?>" class="showAll">Zobrazit všechny výsledky</a>
<?php endif ;endif ?>
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