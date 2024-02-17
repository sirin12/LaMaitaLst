<?php

class Seo extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->auth->check_access('Admin', true);
        $this->load->model('Settings_model');
        $this->lang->load('settings');
        $this->load->helper('inflector');
    }

    function index() {
        $data = $this->Settings_model->get_settings($this->current_site->link);
		
		if($this->input->post('submitted'))
		{
			  $save['script_seo'] = $this->input->post('script_seo');
			  $save['seo_title'] = $this->input->post('seo_title');
			  $save['meta_description'] = $this->input->post('meta_description');
			  $this->Settings_model->save_settings($this->current_site->link, $save);
			  redirect('admin_site/seo');
		}
        $this->view('seo', $data);
    }
}
