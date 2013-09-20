<?php //netteCache[01]000369a:2:{s:4:"time";s:21:"0.65536400 1378250489";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:47:"D:\Web\NetteSandbox\app\templates\@layout.latte";i:2;i:1378250423;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\NetteSandbox\app\templates\@layout.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'pq54mb56vg')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block title
//
if (!function_exists($_l->blocks['title'][] = '_lbf81b36e3c8_title')) { function _lbf81b36e3c8_title($_l, $_args) { extract($_args)
;
}}

//
// block head
//
if (!function_exists($_l->blocks['head'][] = '_lb42e2a5704b_head')) { function _lb42e2a5704b_head($_l, $_args) { extract($_args)
;
}}

//
// block _flashMessages
//
if (!function_exists($_l->blocks['_flashMessages'][] = '_lb912a32379f__flashMessages')) { function _lb912a32379f__flashMessages($_l, $_args) { extract($_args); $_control->validateControl('flashMessages')
;$iterations = 0; foreach ($flashes as $flash): ?>		<div class="flash <?php echo htmlSpecialChars($flash->type) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; endforeach ;
}}

//
// block scripts
//
if (!function_exists($_l->blocks['scripts'][] = '_lb4906228094_scripts')) { function _lb4906228094_scripts($_l, $_args) { extract($_args)
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
ob_start(); call_user_func(reset($_l->blocks['title']), $_l, get_defined_vars()); echo $template->trim($template->stripTags(ob_get_clean()))  ?> | Úkolníček</title>

	<link rel="stylesheet" href="<?php echo htmlSpecialChars($basePath) ?>/css/screen.css" />
	<link rel="shortcut icon" href="<?php echo htmlSpecialChars($basePath) ?>/favicon.ico" />
	<?php call_user_func(reset($_l->blocks['head']), $_l, get_defined_vars())  ?>

</head>

<body>
<div id="header">
	<div id="header-inner">
		<div class="title"><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>">Úkolníček</a></div>

<?php if ($user->isLoggedIn()): ?>		<div class="user">
			<span class="icon user"><?php echo Nette\Templating\Helpers::escapeHtml($user->getIdentity()->name, ENT_NOQUOTES) ?></span> |
			<a href="<?php echo htmlSpecialChars($_control->link("User:password")) ?>">Změna hesla</a> |
			<a href="<?php echo htmlSpecialChars($_control->link("Sign:out")) ?>">Odhlásit se</a>
		</div>
<?php endif ?>
	</div>
</div>

<div id="container">
	<div id="sidebar">
<?php if ($user->isLoggedIn()): ?>
		<h2><a href="<?php echo htmlSpecialChars($_control->link("Homepage:")) ?>">Přehled</a></h2>

		<div class="task-lists">
			<h2>Seznamy</h2>
			<ul>
<?php $iterations = 0; foreach ($lists as $list): ?>				<li><a href="<?php echo htmlSpecialChars($_control->link("Task:", array($list->id))) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($list->title, ENT_NOQUOTES) ?></a></li>
<?php $iterations++; endforeach ?>
			</ul>
		</div>

		<fieldset>
			<legend>Nový seznam</legend>
<?php Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = (is_object("newListForm") ? "newListForm" : $_control["newListForm"]), array()) ?>
				<div class="new-list-form">
<?php if (is_object($form)) $_ctrl = $form; else $_ctrl = $_control->getComponent($form); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render('errors') ?>

<?php $_input = (is_object("title") ? "title" : $_form["title"]); echo $_input->getControl()->addAttributes(array()) ;$_input = (is_object("create") ? "create" : $_form["create"]); echo $_input->getControl()->addAttributes(array()) ?>
				</div>
<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form) ?>
		</fieldset>
<?php endif ?>
	</div>

	<div id="content">
<div id="<?php echo $_control->getSnippetId('flashMessages') ?>"><?php call_user_func(reset($_l->blocks['_flashMessages']), $_l, $template->getParameters()) ?>
</div>
<?php Nette\Latte\Macros\UIMacros::callBlock($_l, 'content', $template->getParameters()) ?>
	</div>

	<div id="footer">
	</div>
</div>

<?php call_user_func(reset($_l->blocks['scripts']), $_l, get_defined_vars())  ?>
</body>
</html>