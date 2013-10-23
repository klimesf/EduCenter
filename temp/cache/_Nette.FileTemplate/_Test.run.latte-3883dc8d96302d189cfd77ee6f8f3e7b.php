<?php //netteCache[01]000367a:2:{s:4:"time";s:21:"0.31524600 1382538290";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:45:"D:\Web\EduCenter\app\templates\Test\run.latte";i:2;i:1382538277;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Test\run.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'ii8z7l7vd7')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb21e10550af_title')) { function _lb21e10550af_title($_l, $_args) { extract($_args)
?>Testování
<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb8ad507510c_content')) { function _lb8ad507510c_content($_l, $_args) { extract($_args)
?><div class="paginator left">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($questionArray) as $question): if ($questionNo==$iterator->getCounter()): ?>
<a class="active"><?php echo Nette\Templating\Helpers::escapeHtml($iterator->getCounter(), ENT_NOQUOTES) ?></a>
<?php else: ?>
<a <?php if ($checkedAnswers->isQuestionAnswered($questionArray[$iterator->getCounter()-1])): ?>
 class="answered"<?php endif  ?> href="<?php echo htmlSpecialChars($_control->link("Test:run", array($testId,$iterator->getCounter()))) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($iterator->getCounter(), ENT_NOQUOTES) ?></a>
<?php endif ;$iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
</div>
<?php $_ctrl = $_control->getComponent("questionDisplay"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>
<p class="center">
<?php if (!$isLastQuestion): ?>
<a class="button" href="<?php echo htmlSpecialChars($_control->link("Test:run", array($testId,$questionNo+1))) ?>
">Další otázka</a>
<?php else: ?>
<a class="button" href="<?php echo htmlSpecialChars($_control->link("Test:evaluate", array($testId))) ?>
">Vyhodnotit</a>
<?php endif ?>
</p>
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