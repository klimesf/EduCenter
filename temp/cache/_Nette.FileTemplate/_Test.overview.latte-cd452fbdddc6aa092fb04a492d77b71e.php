<?php //netteCache[01]000372a:2:{s:4:"time";s:21:"0.33264200 1381946611";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:50:"D:\Web\EduCenter\app\templates\Test\overview.latte";i:2;i:1381946607;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Test\overview.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'yyax4cq8ut')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbf0859ed35b_content')) { function _lbf0859ed35b_content($_l, $_args) { extract($_args)
;call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars())  ?>
<h2><?php echo Nette\Templating\Helpers::escapeHtml($test->desc, ENT_NOQUOTES) ?></h2>
<p><?php echo Nette\Templating\Helpers::escapeHtml($test->about, ENT_NOQUOTES) ?></p>
<h2>Obsah testu</h2>
<p>
<?php $iterations = 0; foreach ($settings as $setting): ?>
<strong><?php echo Nette\Templating\Helpers::escapeHtml($setting->number_of_questions, ENT_NOQUOTES) ?>
 otázek</strong> z kategorie <strong><?php echo Nette\Templating\Helpers::escapeHtml($setting->unit->name, ENT_NOQUOTES) ?>
</strong> s časovým <strong>limitem <?php echo Nette\Templating\Helpers::escapeHtml($setting->time, ENT_NOQUOTES) ?> minut.</strong><br />
<?php $iterations++; endforeach ?>
</p>
<p class="center"><a class="button" href="<?php echo htmlSpecialChars($_control->link("Test:run", array($test->id))) ?>
">Spustit test</a></div>
<?php
}}

//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lb4f469dabe2_title')) { function _lb4f469dabe2_title($_l, $_args) { extract($_args)
?><h1>Přehled testu - <?php echo Nette\Templating\Helpers::escapeHtml($test->name, ENT_NOQUOTES) ?></h1>
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