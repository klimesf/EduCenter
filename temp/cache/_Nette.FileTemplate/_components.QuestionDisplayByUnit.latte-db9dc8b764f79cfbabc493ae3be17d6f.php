<?php //netteCache[01]000381a:2:{s:4:"time";s:21:"0.49232800 1381947497";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:59:"D:\Web\EduCenter\app\components\QuestionDisplayByUnit.latte";i:2;i:1381947495;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\components\QuestionDisplayByUnit.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 's9bzzzo07n')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb4d3847f2b2_title')) { function _lb4d3847f2b2_title($_l, $_args) { extract($_args)
?>Procházení otázek &gt; <?php echo Nette\Templating\Helpers::escapeHtml($question->unit->name, ENT_NOQUOTES) ?>
 &gt; <?php echo Nette\Templating\Helpers::escapeHtml($numberOfCurrentQuestion, ENT_NOQUOTES) ?>
/<?php echo Nette\Templating\Helpers::escapeHtml($numberOfQuestions, ENT_NOQUOTES) ;
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


<div class="question-viewer">
<?php if ($displayNav): ?>
	<h1>Procházení otázek > <?php echo Nette\Templating\Helpers::escapeHtml($question->unit->name, ENT_NOQUOTES) ?></h1>

	<div class="nav">
	    Otázka <?php echo Nette\Templating\Helpers::escapeHtml($numberOfCurrentQuestion, ENT_NOQUOTES) ?>
 z <?php echo Nette\Templating\Helpers::escapeHtml($numberOfQuestions, ENT_NOQUOTES) ?></br>
<?php if ($firstId): ?>
		<a href="<?php echo htmlSpecialChars($_control->link("goTo!", array($firstId))) ?>
">|&lt;</a>
<?php endif ;if ($skipDownId): ?>
		<a href="<?php echo htmlSpecialChars($_control->link("goTo!", array($skipDownId))) ?>
">&lt;&lt;</a>
<?php endif ;if ($previousId): ?>
		<a accesskey="q" href="<?php echo htmlSpecialChars($_control->link("goTo!", array($previousId))) ?>
">&lt; Předchozí</a>
<?php endif ;if ($nextId): ?>
		<a accesskey="w" href="<?php echo htmlSpecialChars($_control->link("goTo!", array($nextId))) ?>
">Další &gt;</a>
<?php endif ;if ($skipUpId): ?>
		<a href="<?php echo htmlSpecialChars($_control->link("goTo!", array($skipUpId))) ?>
">&gt;&gt;</a>
<?php endif ;if ($lastId): ?>
		<a href="<?php echo htmlSpecialChars($_control->link("goTo!", array($lastId))) ?>
">&gt;|</a>
<?php endif ?>
	</div>
<?php endif ?>
    <div class="question">
	<?php echo $question->text ?>

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
"><?php echo Nette\Templating\Helpers::escapeHtml($AnswerIteratorMask::getChar($iterator->getCounter()), ENT_NOQUOTES) ?></a>
<?php else: ?>
	    <a href="<?php echo htmlSpecialChars($_control->link("checkAnswer!", array($answer->id))) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($AnswerIteratorMask::getChar($iterator->getCounter()), ENT_NOQUOTES) ?></a>
<?php endif ?>
	</div>
	<div colspan="2"<?php if ($_l->tmp = array_filter(array('answer'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>
><?php echo $answer->text ?></div>
<?php else: ?>
	<div<?php if ($_l->tmp = array_filter(array($checkedAnswers->isAnswerChecked($answer->id) ? 'checkbox-checked' : 'checkbox'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>
><a><?php echo Nette\Templating\Helpers::escapeHtml($AnswerIteratorMask::getChar($iterator->getCounter()), ENT_NOQUOTES) ?></a></div>
	<div colspan="2"<?php if ($_l->tmp = array_filter(array($answer->correct ? 'correct' : 'answer'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>
><?php echo $answer->text ?></div>
<?php endif ?>
    </div>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
    <div class="bottom-bar">
<?php if (!$answered && ($user->isInRole('member') || $user->isInRole('admin'))): ?>
	<a class="button" accesskey="a" href="<?php echo htmlSpecialChars($_control->link("evaluate!")) ?>
">Vyhodnotit</a>
<?php endif ;$iterations = 0; foreach ($flashes as $flash): ?>    <div class="flash <?php echo htmlSpecialChars($flash->type) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; endforeach ?>
    </div>
<?php if ($user->isInRole('admin')): ?>
    <span class="smaller"><a href="<?php echo htmlSpecialChars($_presenter->link("Question:edit", array($question->id))) ?>
">Upravit otázku</a> | <a href="<?php echo htmlSpecialChars($_presenter->link("Question:reportsByQuestion", array($question->id))) ?>
">Vypsat nahlášení</a> | Počet nevyřešených problémů: <?php echo Nette\Templating\Helpers::escapeHtml($numberOfUnresolvedReports, ENT_NOQUOTES) ?></span><br />
<?php endif ?>
    <span class="smaller">Je v otázce chyba? <a href="#report-form" class="topopup">Nahlašte</a> ji.</span>

    <div id="toPopup">
    <div id="report-form" class="">
	<h2>Nahlášení problému s otázkou</h2>
<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("reportForm") ? "reportForm" : $_control["reportForm"]), array()) ;if (is_object($form)) $_ctrl = $form; else $_ctrl = $_control->getComponent($form); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render('errors') ?>
	    <div class="pair">
<?php $_input = is_object("text") ? "text" : $_form["text"]; if ($_label = $_input->getLabel()) echo $_label->addAttributes(array()) ?>
		<div class="input"><?php $_input = (is_object("text") ? "text" : $_form["text"]); echo $_input->getControl()->addAttributes(array()) ?></div>
	    </div>
	    <div class="pair">
		<div class="input"><?php $_input = (is_object("report") ? "report" : $_form["report"]); echo $_input->getControl()->addAttributes(array()) ?></div>
	    </div>
<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
    </div>
    </div>
    <div class="loader"></div>
    <div id="backgroundPopup"></div>
</div>