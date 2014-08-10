<?php /* Smarty version Smarty-3.1.15, created on 2014-08-10 23:34:04
         compiled from "view/inputuser.html" */ ?>
<?php /*%%SmartyHeaderCode:108349411453e70047df8ad6-70939684%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '586251b3b29b55c004e02cfc43be6ae717f94a18' => 
    array (
      0 => 'view/inputuser.html',
      1 => 1407684843,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '108349411453e70047df8ad6-70939684',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_53e70047e306b6_98066130',
  'variables' => 
  array (
    'basedomain' => 0,
    'admin' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53e70047e306b6_98066130')) {function content_53e70047e306b6_98066130($_smarty_tpl) {?>
<script>
function confirmpass(){
		var pass1 = $('#password').val();
		var pass2 = $('#repassword').val();
		
		if(pass1 != pass2){
			alert('Re-enter password did not match');
			return false;
		}
	}

function changePass(){
	$('.hid').removeAttr("style");
	$('#old_password').removeAttr("disabled");
	$('#password').removeAttr("disabled");
	$('#repassword').removeAttr("disabled");
}
</script>

<div id="content-header">
	<h1><i class="fa fa-cogs"></i> Settings</h1>
</div> <!-- #content-header -->	

<div id="content-container">

	<div class="row">
		<div class="col-md-9 col-sm-8">

		  <div class="tab-content stacked-content">
			<div class="tab-pane fade in active" id="profile-tab">
			  
			  <h3 class="">Admin Configuration</h3>

			  <hr />

			  <br />

			  <form id="validate-enhanced" class="form-horizontal parsley-form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['basedomain']->value;?>
profile/setting" enctype="multipart/form-data" onsubmit="return confirmpass()">

				
				<div class="form-group">

					<label class="col-md-3">Username</label>

					<div class="col-md-7">
						<input type="text" name="username" id="username" value="<?php echo $_smarty_tpl->tpl_vars['admin']->value['username'];?>
" class="form-control" data-required="true" />
					</div> <!-- /.col -->
				<span class="help-block" id="help-username"></span>
				</div> <!-- /.form-group -->
				
				<div class="form-group">

					<label class="col-md-3">Name</label>

					<div class="col-md-7">
						<input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['admin']->value['name'];?>
" class="form-control" data-required="true" data-required="true"/>
					</div> <!-- /.col -->

				</div> <!-- /.form-group -->

				<div class="form-group">

					<label class="col-md-3">Email Address</label>

					<div class="col-md-7">
						<input type="text" name="email" value="<?php echo $_smarty_tpl->tpl_vars['admin']->value['email'];?>
" class="form-control" data-required="true"/>
					</div> <!-- /.col -->

				</div> <!-- /.form-group -->

				<div class="hid form-group" style="display:none;">

					<label class="col-md-3">Old Password</label>

					<div class="col-md-7">
						<input type="password" name="old_password" id="old_password" value="" class="form-control" disabled required/>
					</div> <!-- /.col -->

				</div> <!-- /.form-group -->

				<div class="hid form-group" style="display:none;">

					<label class="col-md-3">New Password</label>

					<div class="col-md-7">
						<input type="password" name="password" id="password" value="" class="form-control" disabled required/>
					</div> <!-- /.col -->

				</div> <!-- /.form-group -->
				
				<div class="hid form-group" style="display:none;">

					<label class="col-md-3">Re-enter Password</label>

					<div class="col-md-7">
						<input type="password" name="repassword" id="repassword" value="" class="form-control" disabled required/>
					</div> <!-- /.col -->

				</div> <!-- /.form-group -->
				

				<br />

				<div class="form-group">

					<div class="col-md-7 col-md-push-3">
						<button type="submit" class="btn btn-success">Save change</button>
						&nbsp;
						<button type="button" class="btn btn-primary" onclick="return changePass()">Change Password</button>
						&nbsp;
						<button type="reset" class="btn btn-default">Cancel</button>
					</div> <!-- /.col -->

				</div> <!-- /.form-group -->
				
				<!-- hidden -->
				<input type="hidden" name="token" value="1">
				<!-- hidden -->
			  </form>


			</div>
		  </div>

	</div> <!-- /.col -->
	</div>
</div><?php }} ?>
