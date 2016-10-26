<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*  Learning Center View
* $filenames = (all files in the upload folder); 
* $counted = (all files that are in both the db and the folder); 
* $badfiles = files that are in the DB but not in the folder; 		
* $newfiles = files that are in the folder but not in the DB;		 
*		
*
*/
	$admin = $this->session->userdata('use_admin');
?>

<link href="/css/learning.css" rel="stylesheet" type="text/css" />
<div id="learning">
<div id="learningheader">
<h3>Learning Center Files</h3><hr>
</div>
<div id="learninglist">
<div id="llheader">
<div class="name">File Name</div>
<div class="desc">Description</div>
</div>
<?php
if (isset($counted)){
	foreach ($counted as $item){ 
	echo '<div class="llitem"><div class="name">'; 
	echo anchor('repository/learning/' . $item['name'] , $item['name'], 'title="' . $item['desc'] .'"');
	echo '</div><div class="desc">';
	echo $item['desc'] .'</div>' ; 
		if ($admin > 0)
	{	
		echo '<div class="lldel">'; 
		echo anchor('repository/delete_lc/' . $item['name'] , 'remove', 'title="' . $item['desc'] .'"');
		echo '</div>';
	}
	echo '</div>'; 
	}}
	?>

</div>
<div id="admin">
<?php // admin area
$admin = $this->session->userdata('use_admin');

	if ($admin > 0)
	{
		echo '<div id="bf">';
		if (isset($badfiles)){
		echo "<hr><h1>Files in DB but not in Directory</h1><br>"; 
			foreach ($badfiles as $b){

			$data = array('class' => 'dbfile');
			echo form_open('rvl_portal/learn_admin', $data);
			echo $b['name']; 
			?>
			<input type="hidden" name="filename" value="<?php echo $b['name'];?>">
				<input type="submit" value="Remove">
			 <?php 
			 echo form_close(); 
			 echo "<br>"; 			
			} 
			}
		echo '</div><hr><div id="nf">'; 
		if (isset($newfiles)){
		echo "<h1>Files in Directory but not in Database</h1><br>";
			foreach ($newfiles as $n){
				$data = array('class' => 'dbfile');
				echo form_open('rvl_portal/learn_new', $data);
				echo $n;	?>
			<input type="hidden" name="filename" value="<?php echo $n;?>">
			<input type="submit" value="Define">
			 <?php 
			 echo form_close(); 
			 echo "<br>"; 	
			}
			}
		echo "</div><br><div>";
		echo "<h1>Upload File</h1><br>";
		echo form_open_multipart('rvl_portal/learn_upload');
		echo '<input type="file" name="userfile" size="20"/>'; 
		echo '<br>'; 
		echo '<input type="submit" value="Upload" />'; 
		echo form_close();
		echo '</div>'; 
		
	}


?>
</div>
</div>