
	<link rel="stylesheet" href="/css/pass.css" type="text/css" media="screen"/>		
	<script type="text/javascript" src="/js/pass.js"></script>

<div id="password_wrapper">
<h1>Current Password</h1><br><div id="cur_pw">
<?php echo $data; ?></div><br>
<div id="pw_form">
<h1>New Password</h1>
<?php 
echo '<br>'; 

echo form_open('login/change_password'); 

$val = array(
		'name'        => 'password',
		'id'          => 'password'
);

echo form_password($val);
echo '<br>';
?>

<h1>Confirm New Password</h1>


<?php 
echo '<br>'; 

$val = array(
		'name'        => 'password_con',
		'id'          => 'password_con'
);

echo form_password($val);

echo '<br>'; 

echo form_submit('pw_submit', 'Submit');
echo form_close(); 
?>
</div>
<hr>
<span id="warn">If you reset your password you will be logged out and have to log in with the new password</span>
</div>
