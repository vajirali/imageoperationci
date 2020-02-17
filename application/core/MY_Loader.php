<?php

/**
 * /application/core/MY_Loader.php
 *
 */
class MY_Loader extends CI_Loader {

    function __construct() {
        parent::__construct();
    }

    public function template($template_name, $vars = array()) {
        $this->view('header here', $vars);
        $this->view($template_name, $vars);
        $this->view('header here', $vars);
    }
    

}
