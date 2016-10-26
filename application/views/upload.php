<script type="text/javascript" src="/js/functions.js"></script>

<?php 
$site_info =  $this->session->userdata('site');
$sid = $this->session->userdata('site_id');

if (isset($error))
{
	print_r($error);
}
?>
<br>
<div id="inventory_upload_div">
<?php 
	echo form_open_multipart('rvl_portal/do_upload');
?>
<div class="week-picker"></div>
<br />
<br />
<label>Week :</label> <span id="startDate"></span> - <span id="endDate"></span>
<hr>
<label>Site Code :</label>  
	<?php 
	//check for site instance  , if manager make a dropdown

	if ($sid == 0){			
		$my_sites = explode(',',$mgr);		
		echo '<select id="siteinfo" name="siteinfo" >';
		foreach ($my_sites as $site){
      //only show site if it isn't the manager site.  Don't want users selecting manager site.
      if ($site != 0)
			  echo '<option value ="' .$site .'">'.$all_sites[$site]['name'] .'</option>'; 
		} 
		echo '</select>';
		
		}else 
		{
			echo $site_info; 		
		}
	?>
	<hr>
	<input id="s_id" type="hidden" name="site_id" value="<?php echo $sid;?>">
<input type="hidden" name="filedate" value="" class="filedate" >
<input type="file" name="userfile" size="20" />

<br />

<br />

<input type="submit" value="Upload" />

<?php echo form_close(); ?>
</div>