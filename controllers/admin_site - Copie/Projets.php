<?php
class Projets extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }
	
	function index() {
        $data['page_title'] = 'Projets';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['projets']=$this->md_commun->fetch('projets',array(),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('projets', $data);
    }

    /*     * ******************************************************************
      edit form_matiere
     * ****************************************************************** */
	function form($id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['projets'] = '';
	
		if($id){
			$projets_id==$this->md_commun->get_row('projets',array('id'=>$id));
			if (!$projets_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/projets');
            }
			$data['id']=$id;
			$data['projets']=$projets_id->projet;
		}
		
		$this->form_validation->set_rules('gare', 'lang:projets', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('projets_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['projets'] = $this->input->post('projets');
			
			$projets_id = $this->md_commun->save('projets',$save);
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/projets');
        }
    }
	

	
    /*     * ******************************************************************
      delete_matiere
     * ****************************************************************** */

    function delete($id) {

        $projets_id=$this->md_commun->get_row('projets',array('id'=>$id));

        if ($projets_id) {
			
            $this->md_commun->delete('projets',$id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/projets');
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
