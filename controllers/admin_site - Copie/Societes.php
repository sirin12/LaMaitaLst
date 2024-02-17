<?php
class Societes extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }
	
	function index() {
        $data['page_title'] = 'Societes';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['societes']=$this->md_commun->fetch('societes',array(),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('societes', $data);
    }
	function contacts($societe_id) {
        $data['page_title'] = 'Contacts';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['contacts']=$this->md_commun->fetch('contacts',array('societe_id'=>$societe_id),'asc',100,0);
		$data['societe_id']=$societe_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('contacts', $data);
    }

    /*     * ******************************************************************
      edit form_societes
     * ****************************************************************** */
	function form($id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['societes'] = '';
	
		if($id){
			$projets_id==$this->md_commun->get_row('societes',array('id'=>$id));
			if (!$projets_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/societes');
            }
			$data['id']=$id;
			$data['societes']=$projets_id->societes;
		}
		
		$this->form_validation->set_rules('societes', 'lang:societes', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('societes_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['societes'] = $this->input->post('societes');
			
			$projets_id = $this->md_commun->save('societes',$save);
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/societes');
        }
    }
	
	/*     * ******************************************************************
      edit form_contact
     * ****************************************************************** */
	function form_contact($societe_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['societe_id'] = '';
	
		if($id){
			$projets_id==$this->md_commun->get_row('societes',array('id'=>$id));
			if (!$projets_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/societes');
            }
			$data['id']=$id;
			$data['societes']=$projets_id->societes;
			$data['societe_id']=$societe_id;
		}
		
		$this->form_validation->set_rules('societes', 'lang:societes', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('contacts_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['societes'] = $this->input->post('societes');
			
			$projets_id = $this->md_commun->save('societes',$save);
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/societes');
        }
    }
	
    /*     * ******************************************************************
      delete_matiere
     * ****************************************************************** */

    function delete($id) {

        $projets_id=$this->md_commun->get_row('societes',array('id'=>$id));

        if ($projets_id) {
			
            $this->md_commun->delete('societes',$id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/societes');
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
