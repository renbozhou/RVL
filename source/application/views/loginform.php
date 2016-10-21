<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*		 
*		Sign in form to create a session
*
*/?>
<script type="text/javascript">
$().ready(function() {

	$("#loginform").validate();
	});
</script>

<div id="logindiv">
	<h1>Lenovo RVL Portal Access</h1>
	<?php
		echo ('<div id="li_box">'); 
		$data = array(
				'class'          => 'login',
				'id'   => 'loginform'); 
		echo form_open('login/checkcred', $data); 
	
		
		echo form_label('Email Address: ', 'email');
		echo '<br>';
		echo form_input('email', '', 'required'); 
		echo '<br>'; 
		echo form_label('Password: ', 'password');
		echo '<br>';
		echo form_password('password','','required'); 
		echo '<br>';
		echo form_submit('submit','Login');  
		echo ('</div>');
	?>
	<hr>
	<?php 
	echo anchor('login/signup', 'Signup', 'id="signuplink"');
	echo '<br>';
	echo anchor('login/forgot', 'Forgot Password', 'id="forgotpw"'); 
	
	?>
	
</div>