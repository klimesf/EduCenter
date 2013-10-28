<?php //netteCache[01]000372a:2:{s:4:"time";s:21:"0.86005300 1382882787";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:50:"D:\Web\EduCenter\app\templates\Test\evaluate.latte";i:2;i:1382882729;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Test\evaluate.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'jd192sso2i')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb15a57dc6e5_title')) { function _lb15a57dc6e5_title($_l, $_args) { extract($_args)
?>Výsledky testu - <?php echo Nette\Templating\Helpers::escapeHtml($test->name, ENT_NOQUOTES) ?>

<?php
}}

//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbdde816bd4f_content')) { function _lbdde816bd4f_content($_l, $_args) { extract($_args)
?><h1>Výsledky testu - <?php echo Nette\Templating\Helpers::escapeHtml($test->name, ENT_NOQUOTES) ?></h1>
<div class="test-results">
<div>Správně zodpovězeno otázek: <span><?php echo Nette\Templating\Helpers::escapeHtml(sizeof($correctArray)-sizeof($wrongAnswers), ENT_NOQUOTES) ?>
 z <?php echo Nette\Templating\Helpers::escapeHtml(sizeof($correctArray), ENT_NOQUOTES) ?></span></div>
<div>Úspěšnost: <span><?php echo Nette\Templating\Helpers::escapeHtml($successRate, ENT_NOQUOTES) ?>%</span></div>
</div>
<h2>Posledních 5 výsledků</h2>
<?php $_ctrl = $_control->getComponent("testResultsList"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>

<p class="center"><a class="button" href="<?php echo htmlSpecialChars($_control->link("Test:wrongAnswers")) ?>
">Procházet špatně zodpovězené otázky</a></p>
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
call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()) ; call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 