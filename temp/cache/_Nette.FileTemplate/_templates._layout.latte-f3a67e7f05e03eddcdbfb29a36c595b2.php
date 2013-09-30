<?php //netteCache[01]000366a:2:{s:4:"time";s:21:"0.39343300 1380396937";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:44:"D:\Web\EduCenter\app\templates\@layout.latte";i:2;i:1380396935;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\@layout.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '0jsvco7x83')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbecf59766d6_title')) { function _lbecf59766d6_title($_l, $_args) { extract($_args)
?>EduCenter<?php
}}

//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lb75dbdb500b_head')) { function _lb75dbdb500b_head($_l, $_args) { extract($_args)
;
}}

//
// block _flashMessages
//
if (!function_exists($_l->blocks['_flashMessages'][] = '_lb5d21559da0__flashMessages')) { function _lb5d21559da0__flashMessages($_l, $_args) { extract($_args); $_control->validateControl('flashMessages')
;$iterations = 0; foreach ($flashes as $flash): ?>		<div class="flash <?php echo htmlSpecialChars($flash->type) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; endforeach ;
}}

//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lbe442c8ba71_scripts')) { function _lbe442c8ba71_scripts($_l, $_args) { extract($_args)
?><script src="<?php echo htmlSpecialChars($basePath) ?>/js/jquery.js"></script>
<script src="<?php echo htmlSpecialChars($basePath) ?>/js/netteForms.js"></script>
<script src="<?php echo htmlSpecialChars($basePath) ?>/js/nette.ajax.js"></script> 
<script src="<?php echo htmlSpecialChars($basePath) ?>/js/main.js"></script>
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
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="description" content="" />
<?php if (isset($robots)): ?>	<meta name="robots" content="<?php echo htmlSpecialChars($robots) ?>" />
<?php endif ?>

	<title><?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
ob_start(); call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()); echo $template->striptags(ob_get_clean())  ?></title>

	<link rel="stylesheet" media="screen,projection,tv" href="<?php echo htmlSpecialChars($basePath) ?>/css/screen.css" />
	<link rel="stylesheet" media="print" href="<?php echo htmlSpecialChars($basePath) ?>/css/print.css" />
	<link rel="shortcut icon" href="<?php echo htmlSpecialChars($basePath) ?>/favicon.ico" />
	<?php call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars())  ?>

</head>

<body>
    <script> document.documentElement.className+=' js' </script>

    <div id="header">
	<div id="header-inner">
	    <div class="title"><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>
"><img src="<?php echo htmlSpecialChars($basePath) ?>/images/check_box.png" height="24" />EduCenter</a></div>

<?php if ($user->isLoggedIn()): ?>	    <div class="user">
		<span class="icon user"><?php echo Nette\Templating\Helpers::escapeHtml($user->getIdentity()->name, ENT_NOQUOTES) ?></span> |
		<a href="<?php echo htmlSpecialChars($_control->link("User:settings")) ?>">Nastavení</a> |
		<a href="<?php echo htmlSpecialChars($_control->link("Sign:out")) ?>">Odhlásit se</a>
	    </div>
<?php endif ?>
	</div>
    </div>

    <div id="container">
<?php if ($user->isLoggedIn()): ?>
	<div id="sidebar">
	    <ul>
		<li><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>">Domů</a></li>
		<li><a href="<?php echo htmlSpecialChars($_control->link("Question:add")) ?>">Přidat otázku</a></li>
		<!-- <li><a n:href="Question:edit 2">Editovat otázku</a></li> -->
		<li><a href="<?php echo htmlSpecialChars($_control->link("Test:")) ?>">Testování</a></li>
		<li><a href="<?php echo htmlSpecialChars($_control->link("Question:")) ?>">Procházení otázek</a></li>
	    </ul>
	</div>
<?php endif ?>
	<div id="content">
<div id="<?php echo $_control->getSnippetId('flashMessages') ?>"><?php call_user_func(reset($_l->blocks['_flashMessages']), $_l, $template->getParameters()) ?>
</div>
<?php Nette\Latte\Macros\UIMacros::callBlock($_l, 'content', $template->getParameters()) ?>
	</div>

	<div id="footer">
	(c) Filip Klimeš 2013, powered by <a href="http://nette.org">Nette Framework</a>
	</div>
</div>

<?php call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars())  ?>
</body>
</html>