<?php
class Car extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }

	function index() {
        $data['page_title'] = 'Véhicule';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		$data['annee']=$annee=$this->md_commun->get_row('annees',array('active'=>1));
		$data['annees']=$this->md_commun->fetch('annees',array(),'asc',1000,0);
		$data['cars']=$this->md_commun->fetchcde('car',array(),'asc',10000,0);
        $data['page_icon'] = 'icon-file-alt';

        $this->view('car', $data);
    }

	function car_list($id) {
        $data['page_title'] = 'Véhicule';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		$data['annee']=$annee=$this->md_commun->get_row('annees',array('active'=>1));
		$data['annees']=$this->md_commun->fetch('annees',array(),'asc',1000,0);
		$data['car']=$this->md_commun->get_row('car',array('CDMAC'=>$id));
		$data['id']=$id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('car_list', $data);
    }
	
	function upload($file)
    {
      $config['upload_path'] = 'uploads/avatars/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png';
      $config['encrypt_name'] = true;
      $config['required'] = false;

      $this->load->library('upload', $config);
      $uploaded = $this->upload->do_upload($file);

      if ($uploaded) {
        $image = $this->upload->data();
        return $image['file_name'];
      }else
      return false;
    }
    function notfound() {
        $this->view('404');
    }


}
