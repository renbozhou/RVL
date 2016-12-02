<link rel="stylesheet" href="/css/pass.css" type="text/css" media="screen"/>		
<script type="text/javascript" src="/js/pass.js"></script>

<div id="password_wrapper">
<div id="pw_form">
	<h1>New Password</h1><br />
	<?php
		echo form_open('login/change_password'); 
		$val = array( 'name' => 'password', 'id' => 'password');
		echo form_password($val);
	?>
	<br /><h1>Confirm New Password</h1><br />
	<?php
		$val = array( 'name' => 'password_con', 'id' => 'password_con' );
		echo form_password($val).'<br>';
		echo form_submit('pw_submit', 'Submit');
		echo form_close();
	?>
	</div>
	<hr />
	<span id="warn">
		If you reset your password you will be logged out and have to log in with the new password
	</span>
</div>