<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*	$users = users that will be displayed (and array of users)
*/
 $id = $this->session->userdata('username');
 
?>
<link href="/css/user.css" rel="stylesheet" type="text/css" />
<div id="admindiv">
<table id="usertable" >
<tr>
<th>Email</th>
<th>Username</th>
<th>new ID</th>
<th>oid ID</th>
<th>use rma</th>
<th>Site ID</th>
<th>e rma</th>
<th>use lc</th>
<th>edit lc</th>
<th>use admin</th>
<th>admin s</th>
<th>admin r</th>
</tr>
<?php foreach ($users as $user){
// list all users except for the current user ?>
	
<tr>
<td><?php echo anchor('rvl_portal/edituser/'.$user['id'], $user['email']); ?></td>
<td><?php echo $user['alias'];?></td>
<td><?php echo $user['id'];?></td>
<td><?php echo $user['tracking_id'];?></td>
<td><?php echo $user['use_rma'];?></td>
<td><?php echo $user['site'];?></td>
<td><?php echo $user['edit_rma'];?></td>
<td><?php echo $user['use_lc'];?></td>
<td><?php echo $user['edit_lc'];?></td>
<td><?php echo $user['use_admin'];?></td>
<td><?php echo $user['admin_search'];?></td>
<td><?php echo $user['admin_report'];?></td>
</tr>
<?php }?>
</table>
<?php //print_r($site);?>
</div>