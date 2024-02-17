<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Upload extends CI_Upload {
	
	 function upload_picture($file)
  {
		$uploaded = $this->do_upload($file);

		if ($uploaded) {
		$CI =& get_instance();

		  $image = $this->data();
		  $CI->load->library('image_lib');
		  //this is the larger image
		  $config['image_library'] = 'gd2';
		  $config['source_image'] = 'uploads/images/full/' . $image['file_name'];
		  $config['new_image'] = 'uploads/images/medium/' . $image['file_name'];
		  $config['maintain_ratio'] = TRUE;
		  $config['width'] = 720;
		  $config['height'] = 500;
		  $CI->image_lib->initialize($config);
		  $CI->image_lib->resize();
		  $CI->image_lib->clear();
	
		  //small image
		  $config['image_library'] = 'gd2';
		  $config['source_image'] = 'uploads/images/medium/' . $image['file_name'];
		  $config['new_image'] = 'uploads/images/small/' . $image['file_name'];
		  $config['maintain_ratio'] = TRUE;
		  $config['width'] = 235;
		  $config['height'] = 235;
		   $CI->image_lib->initialize($config);
		  $CI->image_lib->resize();
		  $CI->image_lib->clear();
	
		  //cropped thumbnail
		  $config['image_library'] = 'gd2';
		  $config['source_image'] = 'uploads/images/small/' . $image['file_name'];
		  $config['new_image'] = 'uploads/images/thumbnails/' . $image['file_name'];
		  $config['maintain_ratio'] = TRUE;
		  $config['width'] = 150;
		  $config['height'] = 150;
		  $CI->image_lib->initialize($config);
		  $CI->image_lib->resize();
		  $CI->image_lib->clear();
	
		  return $image['file_name'];
		}else
		return false;
  }

}
