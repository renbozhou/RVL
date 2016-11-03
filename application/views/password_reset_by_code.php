<link rel="stylesheet" href="/css/pass.css" type="text/css" media="screen"/>
<div id="password_wrapper">
	<h1>Change Password Page</h1><br />
	<div id="pw_form">
		<h1>New Password</h1><br />
		<?php
			echo form_open('login/change_password_by_code');
			echo form_password(array( 'name' => 'password', 'id' => 'password', 'value' => ''));
		?>
		<br /><h1>Confirm New Password</h1><br />
		<?php
			echo form_password(array( 'name' => 'password_con', 'id' => 'password_con','value' => '' )).'<br>';
			echo form_hidden('token',$token);
			echo form_submit('pw_submit', 'Submit');
			echo form_close();
		?>
	</div>
	<hr />
	<span id="warn">
		If you reset your password you will be logged out and have to log in with the new password
	</span>
</div>