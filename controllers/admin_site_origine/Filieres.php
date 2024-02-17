<?php
class Filieres extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model('Filieres_model');
    }

    function index() {
        $data['page_title'] = 'filieres';
        $data['filieres'] = $this->Filieres_model->get();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('filieres', $data);
    }

    /*     * ******************************************************************
      edit categorie
     * ****************************************************************** */

    function form($id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        //set the default values
        $data['id'] = '';
		$data['name'] = '';
		
        $data['page_title'] = 'filieres';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $filiere = $this->Filieres_model->get($id);
				
            if (!$filiere) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/filieres');
            }

            //set values to db values
            $data['id'] = $filiere->id;
			$data['name'] = $filiere->name;
        }

        $this->form_validation->set_rules('name', 'name', 'trim');

        // Validate the form
        if ($this->form_validation->run() == true) {
            $this->load->helper('text');

			$save = array();
			$save['id'] = $id;
			$save['name'] = $this->input->post('name');
			$filieres_id = $this->Filieres_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/filieres');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $membre = $this->md_commun->get_row('filieres',array('id'=>$id));

        if (membre) {
			
            $this->Filieres_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/filieres');
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
