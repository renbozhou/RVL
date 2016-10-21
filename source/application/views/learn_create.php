<div id="lcadmin" width="100px">
<?php 
 
	$data = array( 'class' => 'lc','id' => 'newItem');
	echo form_open('rvl_portal/learn_save', $data); ?>
	<h1><?php echo $filename;?></h1><br>
    <input id="filename" name="filename" type="hidden" value="<?php echo $filename;?>" /><br>
    <label for="desc">Description</label>
    <input id="desc" name="desc" type="text" /><br>
    <label for="type">Type</label>
			<select name="type" id="type" >
					<option value="1" >Learning Center</option>
					<option selected="selected" value="2" >Software Repostitory</option>								
					
			</select>	<br>
                                
	<?php 
	echo form_submit('submit', 'Update File'); 
	echo '</div>';
	echo validation_errors('<p class="error">'); 
	echo '<hr>'; 
	
?>
</div>