<?php 
/*
 * Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
**/

// get variables from session
$is_logged_in = $this->session->userdata('is_logged_in');
$admin = $this->session->userdata('use_admin');
$uname = $this->session->userdata('username');
$alias = $this->session->userdata('alias');
$uid = $this->session->userdata('userid');
$siteinfo =  $this->session->userdata('site');
$userma = $this->session->userdata('use_rma');
$inv = $this->session->userdata('permission');
$lc = $this->session->userdata('use_lc');

?>
<div id="user">
<?php if (isset($is_logged_in) && $is_logged_in == true): ?>
<?= anchor('rvl_portal/userpage/'.$uid, $alias." - ".$siteinfo.' - '.ENVIRONMENT,'title="userinfo page"'); ?>
<?php endif; ?>
</div>

<div id="header"></div>
<div id="headmenubar">
	<div id="headmenu">
		<div id="head_navigation">
			<?php if (isset($is_logged_in) && $is_logged_in == true): ?>
				<div id="navhome"><a href="/">Home</a></div>

				<?php if(isset($is_logged_in) && $admin != 0): ?>
					<div id="navfilem"> 
					<?= anchor('rvl_portal/adminpage/'.$uid,'User Manager','title="Users"'); ?>
					</div>
				    <div id="navsitem"> 
					<?= anchor('rvl_portal/sitepage/'.$uid,'Site Manager','title="Sites"'); ?>
					</div>
				<?php endif; ?>

				<?php if ($userma > 0): ?>
					<div id="myrmaheader"> 
					<?= anchor('/rvl_portal/edit', 'RMA'); ?>
					</div>
				<?php endif; ?>

				<?php if ($inv > 0) : ?>
					<div id="inventory_upload">
					<?= anchor('/rvl_portal/upload', 'Inventory'); ?>
					</div>
				<?php endif; ?>

				<?php if ($lc > 0): ?>
					<div id="learningcenter">
					<?= anchor('/rvl_portal/learning', 'Learning Center'); ?>
					</div>
				<?php endif; ?>
				
				<div id="help">
					<?= anchor('/rvl_portal/help', 'Help'); ?>
				</div>
				<div id="logout">
				<?= anchor('login/logout', 'Logout'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>