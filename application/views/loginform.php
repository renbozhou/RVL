<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*		 
*		Sign in form to create a session
*
*/?>
<script type="text/javascript">
$(document).ready(function(){
	$("#loginform").validate();
	$("#loginform")[0].reset();
});
</script>

<div id="logindiv">
	<h1>Lenovo RVL Portal Access</h1>
	<div id="li_box">
	<?php
		$data = array('class'=>'login', 'id'=>'loginform');
		echo form_open('login/checkcred', $data);
		echo form_label('Email Address: ', 'email').'<br>';
		echo form_input('email', '', 'required').'<br>'; 
		echo form_label('Password: ', 'password').'<br>';
		echo form_password('password','','required').'<br>';
		echo form_submit('submit','Login');
	?>
	</div>
	<hr>
	<?php 
	echo anchor('login/signup', 'Signup', 'id="signuplink"').'<br>';
	echo anchor('login/forgot', 'Forgot Password', 'id="forgotpw"'); 
	?>
</div>