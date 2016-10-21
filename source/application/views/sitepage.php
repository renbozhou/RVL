<?php /*
*  Created by David Brenchley 12/4/2013 
*	$users = users that will be displayed (and array of users)
*/
 //$id = $this->session->userdata('username');
 
?>
<link href="/css/user.css" rel="stylesheet" type="text/css" />
<p>
<?php echo anchor('rvl_portal/editsite/'.'-1', 'New Site'); ?>
</p>
<div id="sitesdiv">
<table id="sitetable" >
<tr>
<th>Id</th>
<th>Code</th>
<th>Description</th>
</tr>
<?php foreach ($sites as $site){
// list all users except for the current user ?>
	
<tr>
<td><?php echo anchor('rvl_portal/editsite/'.$site['id'], $site['id']); ?></td>
<td><?php echo $site['code'];?></td>
<td><?php echo $site['description'];?></td>
</tr>
<?php }?>
</table>
<?php //print_r($site);?>
</div>