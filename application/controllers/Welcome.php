<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function uploadImage(){
		$data = $this->input->post('image');     
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);     
		$data = base64_decode($data); 		
        $imageName = time().'.png';
        file_put_contents('uploads/'.$imageName, $data);     
        echo 'done';
	}
	
	public function makeImage(){
		$config['upload_path']   = './uploads/';
		$config['file_name'] = time().'_'.$_FILES["myimage"]['name'];	
		//$config['file_name'] = time(); //if image name only time.jpg
		$config['allowed_types'] = 'gif|jpg|png'; 
		$config['max_size']      = 1024;
		//$config['max_width'] = '1024';
		//$config['max_height'] = '768';
		$this->load->library('upload', $config);


		if(!$this->upload->do_upload('myimage')){
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('/');
		}else{
			$uploadedImage = $this->upload->data();
			$this->resizeImage($uploadedImage['file_name']);
			$this->session->set_flashdata('success', "image uploaded successfully.");
			redirect('/');
		}
	}
	
	public function resizeImage($filename){
      $source_path = FCPATH. 'uploads/' . $filename;
	  $target_path = FCPATH. '/uploads/thumbnail/';
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => TRUE,
          'create_thumb' => TRUE,
          'thumb_marker' => '_thumb',
          'width' => 150,
          'height' => 150
      );


      $this->load->library('image_lib', $config_manip);
      if(!$this->image_lib->resize()){
          $this->session->set_flashdata('error', $this->image_lib->display_errors());
		  redirect('/');
      }
      $this->image_lib->clear();
   }
	
}
