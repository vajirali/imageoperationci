<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <title>Codeigniter 3 - Crop Image Example using Croppie Js</title>
  <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/croppie.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-3.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/croppie.css">
</head>
<body>
    
<div class="container">
	<div class="panel panel-default">
	  <div class="panel-heading">Codeigniter 3 - Crop Image Example using Croppie Js</div>
	  <div class="panel-body">     
	  	<div class="row">
	  		<div class="col-md-4 text-center">
				<div id="upload-demo" style="width:350px"></div>
	  		</div>
	  		<div class="col-md-4" style="padding-top:30px;">
				<strong>Select Image:</strong>
				<br/>
				<input type="file" id="upload">
				<br/>
				<button class="btn btn-success upload-result" style="display:none;">Upload Image</button>
	  		</div>
	  		<div class="col-md-4" style="">
				<div id="upload-demo-i" style="background:#e1e1e1;width:300px;padding:30px;height:300px;margin-top:30px"></div>
	  		</div>
	  	</div>      
	  </div>
	</div>
	
	<div class="panel panel-default">
	  <div class="panel-heading">Codeigniter 3 - upload image with Thumbnail</div>
	  <div class="panel-body">     
	  	<div class="row">
	  		<div class="col-md-12" style="padding-top:30px;">
				<strong>Select Image:</strong>
				<br/>
				<?php if($this->session->flashdata('error')){
						echo '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>';
				} if($this->session->flashdata('success')){
						echo '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>';
				} ?>
				<form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>welcome/makeImage">
					<input type="file" name="myimage" class="form-group" />
					<input type="submit" class="btn btn-success" />
				</form>
			</div>
	  	</div>      
	  </div>
	</div>
	
</div>
     
<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
});
     
$('#upload').on('change', function () { 
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
    	}).then(function(){
    		console.log('jQuery bind complete');
			$('.upload-result').show();
    	}); 
    }
    reader.readAsDataURL(this.files[0]);
});
     
$('.upload-result').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
		$.ajax({
			url: "<?php echo base_url(); ?>welcome/uploadImage",
			type: "POST",
			data: {"image":resp},
			success: function (data) {
				html = '<img src="' + resp + '" />';
				$("#upload-demo-i").html(html);
			}
		});
	});
});
    
</script>
    
</body>
</html>