<?php 
	echo anchor('login/signup', 'Signup', 'id="signuplink"');
	echo '<br>';
	echo anchor('login/index', 'Sign-in', 'id="sign-in_link"');
	?>
	<p>please enter in your email address and if you have an account, an email will be sent to 
	your email address with your current password</p>
<form name="password" action="/index.php/login/recover_pw" method="post">
Email address: <input type="text" name="email">
<input type="submit" value="Submit">
</form>