<?php
class Coefficient extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Coefficient_model','Class_model','Filieres_model','Matieres_model'));
    }

    function index() {
        $data['page_title'] = 'Coefficient';
        $data['coefficients'] = $this->Coefficient_model->get();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('coefficient', $data);
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
		$data['class'] = '';
		$data['filiere'] = '';
		$data['coefficient'] = '';
		$data['matiere'] = '';
		$data['td'] = '';
		$data['tp'] = '';
		$data['principal'] = '';
		
        $data['page_title'] = 'Coefficient';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $coefficient = $this->Coefficient_model->get($id);
				
            if (!$coefficient) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/coefficient');
            }

            //set values to db values
            $data['id'] = $coefficient->id;
			$data['class'] = $coefficient->class;
			$data['filiere'] = $coefficient->filiere;
			$data['coefficient'] = $coefficient->coefficient;
			$data['matiere'] = $coefficient->matiere;
			$data['td'] = $coefficient->td;
			$data['tp'] = $coefficient->tp;
			$data['principal'] = $coefficient->principal;
        }

        $this->form_validation->set_rules('class', 'class', 'trim');

        // Validate the form
        if ($this->form_validation->run() == true) {
            $this->load->helper('text');

			$save = array();
			$save['id'] = $id;
			$save['class'] = $this->input->post('class');
			$save['filiere'] = $this->input->post('filiere');
			$save['coefficient'] = $this->input->post('coefficient');
			$save['matiere'] = $this->input->post('matiere');
			$save['td'] = $this->input->post('td');
			$save['tp'] = $this->input->post('tp');
			$save['principal'] = $this->input->post('principal');
			
			$coefficient_id = $this->Coefficient_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/coefficient');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $membre = $this->md_commun->get_row('coefficient',array('id'=>$id));

        if (membre) {
			
            $this->Coefficient_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/coefficient');
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
