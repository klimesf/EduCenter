<?php //netteCache[01]000375a:2:{s:4:"time";s:21:"0.54372400 1380301226";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:53:"D:\Web\EduCenter\app\components\QuestionDisplay.latte";i:2;i:1380301220;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\components\QuestionDisplay.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'pab7bxbg1z')
;
// prolog Nette\Latte\Macros\UIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>
<div class="question-viewer">
	<div class="question">
	    <?php echo Nette\Templating\Helpers::escapeHtml($question->text, ENT_NOQUOTES) ?>

<?php if ($question->img): ?>
	    <img src="<?php echo htmlSpecialChars($www_dir . $question->img) ?>" alt="Obrázek k otázce" />
<?php endif ?>
	</div>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($answers) as $answer): ?>
	<div<?php if ($_l->tmp = array_filter(array($iterator->odd ? 'odd' : 'even'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>>
<?php if (!$answered): ?>
		<div<?php if ($_l->tmp = array_filter(array($checkedAnswers->isAnswerChecked($answer->id) ? 'checkbox-checked' : 'checkbox'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>>
<?php if ($checkedAnswers->isAnswerChecked($answer->id)): ?>
		    <a href="<?php echo htmlSpecialChars($_control->link("uncheckAnswer!", array($answer->id))) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($iterator->getCounter(), ENT_NOQUOTES) ?></a>
<?php else: ?>
		    <a href="<?php echo htmlSpecialChars($_control->link("checkAnswer!", array($answer->id))) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($iterator->getCounter(), ENT_NOQUOTES) ?></a>
<?php endif ?>
		</div>
		<div colspan="2"<?php if ($_l->tmp = array_filter(array('answer'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>
><?php echo Nette\Templating\Helpers::escapeHtml($answer->text, ENT_NOQUOTES) ?></div>
<?php else: ?>
		<div<?php if ($_l->tmp = array_filter(array($checkedAnswers->isAnswerChecked($answer->id) ? 'checkbox-checked' : 'checkbox'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>
><a><?php echo Nette\Templating\Helpers::escapeHtml($iterator->getCounter(), ENT_NOQUOTES) ?></a></div>
		<div colspan="2"<?php if ($_l->tmp = array_filter(array($answer->correct ? 'correct' : 'answer'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>
><?php echo Nette\Templating\Helpers::escapeHtml($answer->text, ENT_NOQUOTES) ?></div>
<?php endif ?>
	</div>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ;if (!$answered): ?>
	<a href="<?php echo htmlSpecialChars($_control->link("evaluate!")) ?>">Vyhodnotit</a>
<?php endif ?>
</div>