<?php /* Smarty version Smarty-3.1.15, created on 2014-09-01 17:12:53
         compiled from "./view/sidebar.html" */ ?>
<?php /*%%SmartyHeaderCode:16282585953e468847590e2-58028832%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd064259dbd57878c55967c97fc189d9b7462e5cb' => 
    array (
      0 => './view/sidebar.html',
      1 => 1408779836,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16282585953e468847590e2-58028832',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_53e468847866b5_35182162',
  'variables' => 
  array (
    'basedomain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53e468847866b5_35182162')) {function content_53e468847866b5_35182162($_smarty_tpl) {?>
<div id="sidebar-wrapper" class="collapse sidebar-collapse">
	
	<div id="search">
		<form>
			<input class="form-control input-sm" type="text" name="search" placeholder="Search..." />

			<button type="submit" id="search-btn" class="btn"><i class="fa fa-search"></i></button>
		</form>		
	</div> <!-- #search -->

	<nav id="sidebar">		
		
		<ul id="main-nav" class="open-active">			
			
			
			<li class="dropdown active">
				<a href="javascript:;">
					<i class="fa fa-file-text"></i>
					Article 
					<span class="caret"></span>
				</a>				
				<ul class="sub-nav">
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
article/addarticle">
							<i class="fa fa-plus"></i> 
							Add New Article
						</a>
					</li>
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
home">
							<i class="fa fa-list-alt"></i> 
							Article List
						</a>
					</li>
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
article/trash">
							<i class="fa fa-trash-o"></i>
							Trash
						</a>			
					</li>
				</ul>
			</li>

			<li class="dropdown">
				<a href="javascript:;">
					<i class="fa fa-picture-o"></i>
					Upload Frame & Cover 
					<span class="caret"></span>
				</a>				
				<ul class="sub-nav">
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
article/upload">
							<i class="fa fa-facebook"></i> 
							Facebook
						</a>
					</li>
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
article/uploadtwt">
							<i class="fa fa-twitter"></i> 
							Twitter
						</a>
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
home/frame">
							<i class="fa fa-list-alt"></i> 
							Frame List
						</a>
					</li>
				</ul>
			</li>	
			
		</ul>
				
	</nav> <!-- #sidebar -->

</div> <!-- /#sidebar-wrapper --><?php }} ?>
