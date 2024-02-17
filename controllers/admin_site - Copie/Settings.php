<?php

class Settings extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
        $this->load->model('Settings_model');
        $this->lang->load('settings');
        $this->load->helper('inflector');
    }

    function index() {

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('company_name', 'lang:company_name', 'required');
        $this->form_validation->set_rules('email', 'lang:cart_email', 'required');
        $this->form_validation->set_rules('country_id', 'lang:country');
        $this->form_validation->set_rules('address', 'lang:address');
        $data = $this->Settings_model->get_settings($this->current_site->link);
        $data['config'] = $data;
        $data['page_title'] = lang('common_smart_configuration');
        $data['page_icon'] = ' icon-cogs';
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
            $this->view(  'settings', $data);
        } else {
            $this->session->set_flashdata('message', lang('config_updated_message'));
            $save = $this->input->post();
            $this->Settings_model->save_settings($this->current_site->link, $save);
			/*----journal delete--*/
			$admin_admin = $this->auth->get_connected();
			$this->journal->add($admin_admin['id'],'Modification Paramétre', '');
			/*----end journal--*/
            redirect(config_item('admin_folder') . '/settings');
        }
    }

   function trace()
	  {
	
		$data['page_title'] = 'Traçabilité';
		$data['traces'] 		= $this->Settings_model->get_traces();
		$this->view('tracabilite', $data);
	  }
}
