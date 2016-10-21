<?php /*
*  Created by Cody Hillyard 6/19/2013 codyhillyard@gmail.com
*  basic template for all the pages... should have 
*  $main_content (page name that fills the main portion)
*  $data (for all the data passed from the controller)
*/

	$this->load->view('includes/header.php');
	
	$is_logged_in = $this->session->userdata('is_logged_in'); 
	echo '<div id="main">';
	$this->load->view('includes/h_banner.php');
	
	if (isset($is_logged_in) && $is_logged_in == true)
	{
		
		$this->load->view('includes/menu.php');
	}
	if (!isset($data))
	{
		$data = array (); 
	}
		
	$this->load->view($main_content, $data); 
	echo '</div>'; 
	$this->load->view('includes/footer.php'); 
	
	?>
