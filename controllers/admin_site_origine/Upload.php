<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends Admin_Controller {

	 function __construct()
	{
		parent::__construct();

		//remove_ssl();
	
		$this->lang->load('slider');
		$this->lang->load('admin_common');
		$this->load->model('slider_model');
		

	}
		
	public function index()
	{
		$this->load->view('admin/404');
	}
	 function image_form($id, $idcomponent=false)
	{
		$data				= (array) $this->slider_model->get_slider($id);
		$data['components']=$this->slider_model->get_slider_components($id);
		
		if($idcomponent)
		$data['element']=$this->slider_model->get_slider_component($idcomponent);
		$data['file_name'] = false;
		$data['error']	= false;
		$data['id']=$id;
		$this->load->view('admin_site/sliders/slider_image_uploader', $data);
	}
	
	 function image_upload($id, $idcomponent=false)
	{
		if($this->input->post('delete'))
		{
			$this->slider_model->delete_component($idcomponent);
			redirect('admin_site/upload/image_upload/'.$id);
		}
		
		
		
		$config['allowed_types'] = 'jpg|png|PNG|mp4|flv|avi|3gp';
		//$config['max_size']	= $this->config->item('size_limit');
		$config['upload_path'] = 'uploads/sliders/'.$id.'/';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;
		$config['overwrite'] = true;
		//$config['required'] = false; 
		
		$this->form_validation->set_rules('submitted', 'submitted', 'trim|required');
		
		if($this->form_validation->run())
		{
			if (!is_dir('uploads/sliders/' . $id)) {
    		if (!mkdir('./uploads/sliders/' . $id, 0777, TRUE)) {
					echo "Cannot create directory";
				}
		}
		
			$this->load->library('upload', $config);
			
				$save = array();
				
				if ($this->upload->do_upload())
				{
					$upload_data	= $this->upload->data();
					$save['image']				=  $upload_data['file_name'];
				}
			
				
				if($idcomponent)
				$save['id']=$idcomponent;
				else
				$save['id']=false;
				
				$save['slider_id']			= $id;
				
				$save['title']				= $this->input->post('title'); 
				$save['title_ar']			= $this->input->post('title_ar'); 
				$save['title_eng']			= $this->input->post('title_eng'); 
				$save['link']				= $this->input->post('link'); 
				$save['type']				= $this->input->post('type'); 
				$save['top']				= $this->input->post('top'); 
				$save['left']				= $this->input->post('left');
				$save['slidedirection']		= $this->input->post('slidedirection');
				$save['slideoutdirection']  = $this->input->post('slideoutdirection');
				$save['scalein']  			= $this->input->post('scalein');
				$save['scaleout']  			= $this->input->post('scaleout');
				$save['delayin']  			= $this->input->post('delayin');
				$save['other']  			= $this->input->post('other');
                                $save['color']  			= $this->input->post('color');
				
				$this->md_commun->save('slider_components',$save);
		}
		
		$data				= (array) $this->slider_model->get_slider($id);
		$data['components']=$this->slider_model->get_slider_components($id);
		
		if($idcomponent)
		$data['element']=$this->slider_model->get_slider_component($idcomponent);
		$data['file_name'] = false;
		$data['error']	= false;
		$data['id']=$id;
		
		
		$this->load->view('admin_site/sliders/slider_image_uploader', $data);
	}
	
	
	 function form($id)
	{
		$data['img']=$this->md_commun->get_row_by_id('slider_components',$id);
		
		
		$this->form_validation->set_rules('x', 'X', 'required|trim');
		$this->form_validation->set_rules('y', 'Y', 'required|trim');
		$this->form_validation->set_rules('z', 'Z-index', 'required|trim');
		
		if ($this->form_validation->run())
		{
			$ext=explode(".", $data['img']->image);
			$new=$this->input->post('z').'_'.$this->input->post('y').'_'.$this->input->post('x').'.'.$ext[1];
			$dir='uploads/sliders/'.$data['img']->slider_id.'/';
			rename($dir.$data['img']->image, $dir.$new);
			
			$save = array();
			$save['id']=$id;
			$save['image']=$new;
			$this->md_commun->save('slider_components',$save);
		}
		
		$this->view('sliders/image_form', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */