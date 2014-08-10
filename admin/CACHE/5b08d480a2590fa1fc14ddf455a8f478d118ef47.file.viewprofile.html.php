<?php /* Smarty version Smarty-3.1.15, created on 2014-08-10 13:15:47
         compiled from "view/viewprofile.html" */ ?>
<?php /*%%SmartyHeaderCode:1427637053e70003b30247-59957290%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b08d480a2590fa1fc14ddf455a8f478d118ef47' => 
    array (
      0 => 'view/viewprofile.html',
      1 => 1406096940,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1427637053e70003b30247-59957290',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_53e70003b69451_61495428',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53e70003b69451_61495428')) {function content_53e70003b69451_61495428($_smarty_tpl) {?><<?php ?>?php defined ('MICRODATA') or exit ( 'Forbidden Access' ); ?<?php ?>>


<h1>Setting Profile CDC</h1>
<form method="post" action="<<?php ?>?=$basedomain?<?php ?>>profile/profileinp" enctype="multipart/form-data">
<fieldset>
<legend>Tentang CDC</legend>
<table>
	<tr>
		<td>Header</td>
		<td><input type="text" name="header_tentang" value="<<?php ?>?=(isset($data[0]['brief']) ? $data[0]['brief'] : '');?<?php ?>>" /></td>
	</tr>
	<tr>
		<td>Title</td>
		<td><input type="text" name="title_tentang" value="<<?php ?>?=(isset($data[0]['title']) ? $data[0]['title'] : '');?<?php ?>>" /></td>
	</tr>
	<tr>
		<td>Content</td>
		<td><textarea name="tentang"><<?php ?>?=(isset($data[0]['content']) ? $data[0]['content'] : '');?<?php ?>></textarea></td>
		<input type="hidden" name="id_tentang" value="<<?php ?>?=(isset($data[0]['id']) ? $data[0]['id'] : '');?<?php ?>>" />
		<input type="hidden" name="tags_tentang" value="<<?php ?>?=(isset($data[0]['tags']) ? $data[0]['tags'] : 'TCDC');?<?php ?>>" />
	</tr>
</table>
</fieldset>
<fieldset>
<legend>Sejarah CDC</legend>
<table>
	<tr>
		<td>Header</td>
		<td><input type="text" name="header_sejarah" value="<<?php ?>?=(isset($data[1]['brief']) ? $data[1]['brief'] : '');?<?php ?>>" /></td>
	</tr>
	<tr>
		<td>Title</td>
		<td><input type="text" name="title_sejarah" value="<<?php ?>?=(isset($data[1]['title']) ? $data[1]['title'] : '');?<?php ?>>" /></td>
	</tr>
	<tr>
		<td>Content</td>
		<td><textarea name="sejarah"><<?php ?>?=(isset($data[1]['content']) ? $data[1]['content'] : '');?<?php ?>></textarea></td>
		<input type="hidden" name="id_sejarah" value="<<?php ?>?=(isset($data[1]['id']) ? $data[1]['id'] : '');?<?php ?>>" />
		<input type="hidden" name="tags_sejarah" value="<<?php ?>?=(isset($data[1]['tags']) ? $data[1]['tags'] : 'SCDC');?<?php ?>>" />
	</tr>
</table>
</fieldset>
<fieldset>
<legend>Visi & Misi</legend>
<table>
	<tr>
		<td>Header</td>
		<td><input type="text" name="header_visi" value="<<?php ?>?=(isset($data[2]['brief']) ? $data[2]['brief'] : '');?<?php ?>>" /></td>
	</tr>
	<tr>
		<td>Title</td>
		<td><input type="text" name="title_visi" value="<<?php ?>?=(isset($data[2]['title']) ? $data[2]['title'] : '');?<?php ?>>" /></td>
	</tr>
	<tr>
		<td>Visi</td>
		<td><textarea name="visi"><<?php ?>?=(isset($data[2]['content']) ? $data[2]['content'] : '');?<?php ?>></textarea></td>
		<input type="hidden" name="id_visi" value="<<?php ?>?=(isset($data[2]['id']) ? $data[2]['id'] : '');?<?php ?>>" />
		<input type="hidden" name="tags_visi" value="<<?php ?>?=(isset($data[2]['tags']) ? $data[2]['tags'] : 'VCDC');?<?php ?>>" />
	</tr>
	<tr>
		<td>Misi</td>
		<td><textarea name="misi"><<?php ?>?=(isset($data[3]['content']) ? $data[3]['content'] : '');?<?php ?>></textarea></td>
		<input type="hidden" name="id_misi" value="<<?php ?>?=(isset($data[3]['id']) ? $data[3]['id'] : '');?<?php ?>>" />
		<input type="hidden" name="tags_misi" value="<<?php ?>?=(isset($data[3]['tags']) ? $data[3]['tags'] : 'MCDC');?<?php ?>>" />
	</tr>
</table>
</fieldset>
<input type="submit" value="Submit" id="submit" />
</form><?php }} ?>
