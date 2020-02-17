<?php

/**
 * /application/core/MY_Controller.php
 *
 */

class MY_Controller extends CI_Controller {
    
    function __construct()
    {
         
        parent::__construct();
        
       if($this->uri->segment(1) == 'admin' && strtolower($this->uri->segment(2)) != 'login'){
		   if($this->session->userdata('admin_loggedin') != 1){
			   redirect('admin/Login/');
		   }
	   }
       
       
    }
}
