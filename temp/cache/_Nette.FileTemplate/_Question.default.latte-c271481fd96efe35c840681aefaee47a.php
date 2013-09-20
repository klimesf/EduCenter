<?php //netteCache[01]000375a:2:{s:4:"time";s:21:"0.12080400 1378530613";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:53:"D:\Web\EduCenter\app\templates\Question\default.latte";i:2;i:1378530610;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"80a7e46 released on 2013-08-08";}}}?><?php

// source file: D:\Web\EduCenter\app\templates\Question\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '0d6v5yefyr')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb9442aac720_content')) { function _lb9442aac720_content($_l, $_args) { extract($_args)
?><table class="units">
<thead>
	<tr>
		<th>Název</th>
		<th>Popis</th>
		<th>Otázky</th>
	</tr>
</thead>
<tbody>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator($units) as $unit): ?>
	<tr<?php if ($_l->tmp = array_filter(array($iterator->odd ? 'odd' : 'even'))) echo ' class="' . htmlSpecialChars(implode(" ", array_unique($_l->tmp))) . '"' ?>>
		<td><a href="<?php echo htmlSpecialChars($_control->link("Question:browseByUnit", array($unit->id))) ?>
"><?php echo Nette\Templating\Helpers::escapeHtml($unit->name, ENT_NOQUOTES) ?></a></td>
		<td><?php echo Nette\Templating\Helpers::escapeHtml($unit->description, ENT_NOQUOTES) ?></td>
		<td class="number"><?php echo Nette\Templating\Helpers::escapeHtml($questionRepository->countByUnit($unit->id), ENT_NOQUOTES) ?></td>
	</tr>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
</tbody>
</table>

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
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars())  ?>


<?php Nette\Diagnostics\Debugger::barDump(get_defined_vars(), "Template " . str_replace(dirname(dirname($template->getFile())), "\xE2\x80\xA6", $template->getFile())) ;