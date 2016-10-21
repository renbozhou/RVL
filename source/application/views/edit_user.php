<div id="user_form">
<?php 
	 
	$data = array( 'class' => 'login','id' => 'signupform');
	echo form_open('login/create_member', $data);
	echo form_label('Email Address: ', 'email');
	echo '<br>';
	echo form_input('email', set_value('email'), 'required');	
	echo '<br>';
	echo form_label('Password: ', 'pw1'); 
	echo '<br>';
	echo form_input('pw1', set_value('pw1'), 'required'); 
	echo '<br>';
	echo form_label('Password Confirm: ', 'pw2');
	echo '<br>';
	echo form_input('pw2',set_value('pw2'), 'required'); 
	echo '<br>';	
	echo form_submit('submit', 'Create User'); 
	echo '</div>';
	echo validation_errors('<p class="error">'); 
	echo '<hr>'; 
	echo anchor('login/index', 'Log in an Existing User', 'id="loginlink"');
	
?>

</div>