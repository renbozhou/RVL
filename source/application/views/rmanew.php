<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*		 
*		
*
*/?>

<script src="/js/rma.js"></script>
<div id="newrma">
<?php 
	echo validation_errors('<p class="error">');
	echo form_open('rvl_portal/saverma'); ?>
    <fieldset>
<input type="hidden" name="company_name_is_valid" value="true"/>
<input type="hidden" name="ret_part_desc_is_valid" value="true"/>
<input type="hidden" name="replacement_part_num_is_valid" value="true"/>
<input type="hidden" name="ret_part_desc_is_valid" value="true"/>
<input type="hidden" name="iomega_sn_is_empty" value="true"/>
<input type="hidden" name="iomega_sn_is_valid" value="true"/>
<input type="hidden" name="bare_hdd_sn_is_valid" value="true"/>
<input type="hidden" name="ret_part_num_is_valid" value="true"/>                  
<input type="hidden" name="customer_rma_num_is_valid" value="true"/>
<fieldset>
<legend>Basic Info</legend>
<?php
	echo form_label('Customer Type: ', 'customertype');
	echo form_dropdown('customertype', $customertype , 'End User', 'id="custdd"');  
?>
<hr>
<?php
	$rmatype [] = ('Select Customer Type'); 
	echo form_label('RMA Type: ', 'rmatype');
	echo form_dropdown('rmatype', $rmatype, 'Select Customer Type', 'id="rma_type"');  
?>
<hr>
<?php	
	echo form_label('Product Type: ', 'producttype');
	echo form_dropdown('producttype', $producttype);  
?>
<hr>
<?php

	$info = array('id' => 'customer_rma_num', 'class' => 'rmanumber', 'name' => 'customer_rma_num');
	echo form_label('Customer RMA number: ', 'customer_rma_num');
	echo form_input($info); 
?>
<hr>
<?php
	echo form_label('Company Name: ', 'cname');
	echo form_input('cname'); 
?>
<hr>
<?php

	$info = array('id' => 'fname', 'class' => 'required', 'name' => 'fname');
	echo form_label('First Name: ', 'fname');
	echo form_input('fname'); 
?>
<hr>
<?php
	echo form_label('Last Name: ', 'lname');
	echo form_input('lname'); 
?>
</fieldset>
<fieldset><legend>Return Info</legend>
<?php
	$info = array('id' => 'receipt_date', 'class' => 'dateinput', 'name' => 'receipt_date'); 
	echo form_label('Receipt Date: ', 'receipt_date') ; 
	echo form_input($info); 
?><hr>
<?php
	echo form_label('Returned Unit Serial Number: ', 'iomegasn');
	echo form_input('iomegasn'); 
?>
<p>-OR-</p>
<?php
	echo form_label('Returned Bare HDD Serial Number: ', 'bhddsn');
	echo form_input('bhddsn'); 
?>
<hr>
<?php
	echo form_label('Returning Part Number: ', 'partnumber');
	echo form_input('partnumber'); 
?>
<hr>
<?php
	echo form_label('Returning MTM #: ', 'returned_mtm');
	echo form_input('returned_mtm'); 
?>
<hr>
<?php
	echo form_label('Returning Part Description: ', 'partdesc');
	echo form_input('partdesc'); 
?>
 <hr>
</fieldset>
<fieldset><legend>Shipping Info</legend>

<?php
	$info = array('id' => 'shipped_date', 'class' => 'dateinput', 'name' => 'shipped_date'); 
	echo form_label('Shipped Date: ', 'shipped_date') ; 
	echo form_input($info); 
?>
<hr>
<?php
	echo form_label('Replacement S/N: ', 'replacesn');
	echo form_input('replacesn'); 
?>
<hr><?php
	echo form_label('Replacement Part Number', 'replacenum');
	echo form_input('replacenum'); 
?>
<hr><?php
	echo form_label('Replacement Part Description: ', 'replacedesc');
	echo form_input('replacedesc'); 
?>
<hr>
<?php
	echo form_label('Shipped MTM #: ', 'shipped_mtm');
	echo form_input('shipped_mtm'); 
?>
<hr>
<?php
	echo form_label('Courier Tracking Number: ', 'couriertrack');
	echo form_input('couriertrack'); 
?>
<hr>
<?php
	$info = array('id' => 'screen_date', 'class' => 'dateinput', 'name' => 'screen_date'); 
	echo form_label('Screen Date: ', 'screen_date') ; 
	echo form_input($info); 
?>
<hr>
<?php
	echo form_label('Shipment Document Number: ', 'shipdocnum');
	echo form_input('shipdocnum'); 
?>
<hr><?php
	echo form_label('Replacement Mode: ', 'replacemode');
	echo form_input('replacemode'); 
?>
<hr>
<?php	// Screen and repair
	echo form_label('FA Cause Code: ', 'facausecode');
	echo form_dropdown('facausecode', $facodes); 
?>
<hr>
<?php // Screen and repair
	$prdpos = array('Return to Stock', 'RTV', 'Scrap', 'WIP'); 	
	echo form_label('Product Disposition: ', 'productdisposition');
	echo form_dropdown('productdisposition', $prdpos);  

?>
<hr>
<?php
	$rtv = array('Hard Drive', 'Enclosure', 'Accessory'); 	
	echo form_label('RTV Category: ', 'rtvcat');
	echo form_dropdown('rtvcat', $rtv);  
?>
<hr>
<?php
	
	echo form_label('Raw HDD Serial Number: ', 'raw_hdd_sn');
	echo form_input('raw_hdd_sn'); 

?><hr>
<?php
	
	echo form_label('Raw HDD Part Number: ', 'raw_hdd_part_num');
	echo form_input('raw_hdd_part_num');  

?><hr>
<?php
	
	echo form_label('Raw HDD Serial Number 2: ', 'raw_hdd_part_num2');
	echo form_input('raw_hdd_part_num2');   

?><hr>
<?php
	
	echo form_label('Raw HDD Serial Number 3: ', 'raw_hdd_part_num3');
	echo form_input('raw_hdd_part_num3'); 

?>
 
 <hr>
<?php
	
	echo form_label('Supplier: ', 'supplier');
	echo form_dropdown('supplier', $suppliers);  
?>
<hr>
<?php	
	echo form_label('Supplier RMA: ', 'supplierrma');
	echo form_input('supplierrma'); 
?>
<hr>
<?php	
	echo form_label('Notes: ', 'notes');
	echo form_textarea('notes'); 
?>
<hr>
<?php	
	$status = array('Open', 'Closed');
	echo form_label('Status: ', 'status');
	echo form_dropdown('status', $status);
?>
<hr>
<?php 	echo form_submit('submit', 'Save');?>
 <input type="button" id="clone" value="Save &amp; Clone">
 <input type="reset" id="reset" value="Reset">
 <input type="button" id="cancel" class="cancel" value="Cancel">
</fieldset>
<?php echo form_close();?>
</div><br><hr>
<script type="text/javascript">
	$('document').ready(function(){
		$("form").validate(); 
		}); 
</script>
