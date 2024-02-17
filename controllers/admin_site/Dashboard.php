<?php

class Dashboard extends Admin_Controller {

    function __construct() {
        parent::__construct();
      
        $this->load->helper('date');
        $this->load->model(array('statistics_model','inbox_model'));
    }

    function index() {
        $data['page_title'] = lang('dashboard');
        $data['page_icon'] = 'icon-dashboard';
        //$this->view('dashboard', $data);
		redirect('admin_site/Projets');
    }

}
