<?php 
/*
 *  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
 *  Sign in form to create a session
**/
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#loginform").validate();
	$("#loginform")[0].reset();
});
</script>

<div id="logindiv">
	<h1>Lenovo RVL Portal Access</h1>
	<div id="li_box">
		<?php $form = array('class'=>'login', 'id'=>'loginform'); ?>
		<?= form_open('login/checkcred', $form); ?>
		<?= form_label('Email Address: ', 'email').'<br>'; ?>
		<?= form_input('email', '', 'required').'<br>'; ?>
		<?= form_label('Password: ', 'password').'<br>'; ?>
		<?= form_password('password','','required').'<br>'; ?>
		<?= form_label('Auth Code: ', 'autcode').'<br>'; ?>
		<div class="div_h_30">
			<div class='left autcode'>
				<?= form_input('autcode', '', 'required').'&nbsp;&nbsp;'; ?>
			</div>
			<div class='left'><?=$captcha_image.''; ?></div>
			<div class='left'><a href="<?=site_url('login/index')?>">刷新验证码</a></div>
			<div class="clear"></div>
		</div>
		<br />
		<?= form_submit('submit','Login'); ?>
	</div>
	<hr>
	<?= anchor('login/signup', 'Signup', 'id="signuplink"').'<br>'; ?>
	<?= anchor('login/forgot', 'Forgot Password', 'id="forgotpw"'); ?>
</div>