<?php /* Smarty version Smarty-3.1.15, created on 2014-08-10 20:48:08
         compiled from "view/home.html" */ ?>
<?php /*%%SmartyHeaderCode:90671886953e4688432f4a2-72027671%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c1bdcd6c9b0c8d1a6a267d96d10c4045e955f2c' => 
    array (
      0 => 'view/home.html',
      1 => 1407674886,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90671886953e4688432f4a2-72027671',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_53e4688443c757_51634438',
  'variables' => 
  array (
    'basedomain' => 0,
    'data' => 0,
    'var' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53e4688443c757_51634438')) {function content_53e4688443c757_51634438($_smarty_tpl) {?><script type="text/javascript">
	function AreAnyCheckboxesChecked () {
	  if ($("#Form2 input:checkbox:checked").length > 0)
		{
		    $("#btn-dis").removeAttr("disabled");
		}
		else
		{
		   $('#btn-dis').attr("disabled","disabled");
		}
	}
</script>
<div id="content-header">
	<h1>Article</h1>
</div> <!-- #content-header -->	

<div id="content-container">

	<div class="row">

		<div class="col-md-12">

			<div class="portlet">

				<div class="portlet-header">

					<h3>
						<i class="fa fa-table"></i>
						Article List
					</h3>

				</div> <!-- /.portlet-header -->

				<div class="portlet-content">						

					<div class="table-responsive">

					<form action="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
article/articledel" method=POST name="checks" ID="Form2" onsubmit="return confirm('Are you sure want to delete?');">

					<a href="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
article/addarticle"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Add New</button></a>

					<button type="submit" class="btn btn-primary btn-sm" id="btn-dis" disabled><i class="fa fa-trash-o"></i> Delete</button>
					
					<table 
						class="table table-striped table-bordered table-hover table-highlight table-checkable" 
						data-provide="datatable" 
						data-display-rows="10"
						data-info="true"
						data-paginate="true"
					>
							<thead>
								<tr>
									<th class="checkbox-column">
										<input type="checkbox" class="icheck-input" onchange="return AreAnyCheckboxesChecked();">
									</th>
									<th data-filterable="true" data-sortable="true" >Title</th>
									<th data-filterable="true" data-sortable="true" >Status</th>
									<th data-filterable="true" data-sortable="true">Created Date</th>
									<th data-filterable="true" data-sortable="true">Author</th>
								</tr>
							</thead>
							<tbody>
								<?php  $_smarty_tpl->tpl_vars['var'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['var']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['var']->key => $_smarty_tpl->tpl_vars['var']->value) {
$_smarty_tpl->tpl_vars['var']->_loop = true;
?>
								<tr>
									<td class="checkbox-column">
										<input type="checkbox" class="icheck-input" name="ids[]" value="<?php echo $_smarty_tpl->tpl_vars['var']->value['id'];?>
" onchange="return AreAnyCheckboxesChecked();">
									</td>
									<td><a href="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
article/addarticle/?id=<?php echo $_smarty_tpl->tpl_vars['var']->value['id'];?>
" data-toggle="tooltip" data-placement="right" title="Edit or view <?php echo $_smarty_tpl->tpl_vars['var']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['var']->value['title'];?>
</a></td>
									<td style="color:<?php echo $_smarty_tpl->tpl_vars['var']->value['status_color'];?>
"><?php echo $_smarty_tpl->tpl_vars['var']->value['n_status'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['var']->value['created_date'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['var']->value['username'];?>
</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</form>
					</div> <!-- /.table-responsive -->
					

				</div> <!-- /.portlet-content -->

			</div> <!-- /.portlet -->

		

		</div> <!-- /.col -->

	</div> <!-- /.row -->

</div><?php }} ?>
