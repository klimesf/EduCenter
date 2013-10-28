<?php //netteCache[01]000366a:2:{s:4:"time";s:21:"0.43594700 1382572395";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:44:"D:\Web\EduCenter\app\templates\@layout.latte";i:2;i:1382572394;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\@layout.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '641uj2j0rt')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbe0a9a935cb_title')) { function _lbe0a9a935cb_title($_l, $_args) { extract($_args)
;
}}

//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lbb4977d46ac_head')) { function _lbb4977d46ac_head($_l, $_args) { extract($_args)
;
}}

//
// block _flashMessages
//
if (!function_exists($_l->blocks['_flashMessages'][] = '_lb7c25c31f05__flashMessages')) { function _lb7c25c31f05__flashMessages($_l, $_args) { extract($_args); $_control->validateControl('flashMessages')
;$iterations = 0; foreach ($flashes as $flash): ?>	    <div class="flash <?php echo htmlSpecialChars($flash->type) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; endforeach ;
}}

//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lbd9ebb9d090_scripts')) { function _lbd9ebb9d090_scripts($_l, $_args) { extract($_args)
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
ob_start(); call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()); echo $template->striptags(ob_get_clean())  ?> | EduCenter</title>

	<link rel="stylesheet" media="screen,projection,tv" href="<?php echo htmlSpecialChars($basePath) ?>/css/screen.css" />
	<link rel="stylesheet" media="print" href="<?php echo htmlSpecialChars($basePath) ?>/css/print.css" />
	<link rel="shortcut icon" href="<?php echo htmlSpecialChars($basePath) ?>/favicon.ico" />
	<?php call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars())  ?>

</head>

<body>
    <script> document.documentElement.className+=' js' </script>

    <div id="panel">
	<div id="header">
	    <div id="header-inner">
		<div class="title"><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>
"><img src="<?php echo htmlSpecialChars($basePath) ?>/images/check_box.png" height="24" />EduCenter</a></div>

		<div class="user">
<?php if ($user->isLoggedIn()): ?>
		    <span class="icon user"><a href="<?php echo htmlSpecialChars($_control->link("User:")) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($user->getIdentity()->name, ENT_NOQUOTES) ?></a></span> |
		    <a href="<?php echo htmlSpecialChars($_control->link("User:settings")) ?>">Nastavení</a> |
		    <a href="<?php echo htmlSpecialChars($_control->link("Sign:out")) ?>">Odhlásit se</a>
<?php else: ?>
		    <a href="<?php echo htmlSpecialChars($_control->link("Sign:in")) ?>">Přihlásit se</a> |
		    <a href="<?php echo htmlSpecialChars($_control->link("User:register")) ?>">Registrovat</a>
<?php endif ?>
		</div>
	    </div>
	</div>
    </div>

    <div id="horizontal-menu-container">
	<div id="horizontal-menu">
<?php if ($user->isLoggedIn()): ?>
	    <ul>
		<li><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>">Domů</a></li>
		<li><a href="<?php echo htmlSpecialChars($_control->link("Test:")) ?>">Testování</a></li>
		<li><a href="<?php echo htmlSpecialChars($_control->link("Question:")) ?>">Procházení otázek</a></li>
<?php if ($user->isInRole('admin')): ?>
		<!--<li><a>Administrace</a>
		    <ul>
			<li><a n:href="Question:add">Přidat otázku</a></li>
			<li><a n:href="Question:reports">Procházet nahlášené</a></li>
		    </ul>
		</li>-->
		<li><a href="<?php echo htmlSpecialChars($_control->link("Question:add")) ?>">Přidat otázku</a></li>
		<li><a href="<?php echo htmlSpecialChars($_control->link("Question:reports")) ?>
">Procházet nahlášené</a></li>
<?php endif ?>
	    </ul>
<?php else: ?>
	    <ul>
		<li><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>">Domů</a></li>
	    </ul>
<?php endif ?>
	</div>
    </div>

    <div id="container">
<?php if ($user->isLoggedIn()): ?>
	<!-- <div id="sidebar">
	    <ul>
		<ul>
		<h3>Navigace</h3>
		<li><a n:href="Homepage:">Domů</a></li>
		<li><a n:href="Test:">Testování</a></li>
		<li><a n:href="Question:">Procházení otázek</a></li>
		</ul>
<?php if ($user->isInRole('admin')): ?>
		<ul>
		<h3>Administrace</h3>
		<li><a n:href="Question:add">Přidat otázku</a></li>
		<li><a n:href="Question:reports">Procházet nahlášené</a></li>
		</ul>
<?php endif ?>
	    </ul>
	</div> -->
<?php endif ?>
	<div id="content">
<div id="<?php echo $_control->getSnippetId('flashMessages') ?>"><?php call_user_func(reset($_l->blocks['_flashMessages']), $_l, $template->getParameters()) ?>
</div><?php Nette\Latte\Macros\UIMacros::callBlock($_l, 'content', $template->getParameters()) ?>
	</div>
    </div>
    <div id="footer-container">
	<div id="footer">
	    <span class="smaller">(c) Filip Klimeš 2013, powered by <a href="http://nette.org">Nette Framework</a></span>
	</div>
    </div>

<?php call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars())  ?>
</body>
</html>