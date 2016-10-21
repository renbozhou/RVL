<?php
/* edit_site page to edit sites
 * 
 */
//if ($data['id'] ==  $this->session->userdata('userid'))
//	echo "if you change the current user's info you must log out and back in to see changes"; 

?>


<link rel="stylesheet" href="/css/permission.css" type="text/css" media="screen"/>
<div id="edit_user">
	<div id="site_info">
        <?php //var_dump($data);?>
        <?php 
        if($data['id'] == "-1") 
            echo "<h1>New Site:</h1>";
        else
            echo "<h1>Site Id: ".$data['id']."</h1>";
                
        ?>
	</div>
	<hr/>
	<div id="editsite">
	<form name="input" action="/index.php/rvl_portal/update_site" method="post">
	<div id="editsite_div">
	<h3>Site</h3>
	<div id="site_list">
		<input type="hidden" id="id" name="id" value="<?php echo $data['id'];?>" />
        <p>
        Code<br />
		<input type="text" name="code" value="<?php echo $data['site']['code'];?>" />
        </p>
        <br />
        <p>Description<br />
        <input type="text" name="description" value="<?php echo $data['site']['description'];?>" /><br />
        </p>
	</div></div>

		<div id="enter">
		<br/>
			<input type="submit" value="Submit Changes"/>
		</div>
	</form>
	</div>
	
</div>
