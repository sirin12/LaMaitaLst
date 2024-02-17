<?php
class Examen extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Class_model','Filieres_model','Examen_model'));
    }

    function index() {
        $data['page_title'] = 'Examen';
        $data['examens'] = $this->Examen_model->get();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('examen', $data);
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
		$data['type'] = '';
		$data['class'] = '';
		$data['filiere'] = '';
		$data['date'] = '';
		$data['time'] = '';

        $data['page_title'] = 'Examen';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $examen = $this->Examen_model->get($id);
				
            if (!$examen) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Examen');
            }

            //set values to db values
            $data['id'] = $examen->id;
			$data['name'] = $examen->name;
			$data['type'] = $examen->type;
			$data['class'] = $examen->class;
			$data['filiere'] = $examen->filiere;
			$data['date'] = $examen->date;
			$data['time'] = $examen->time;
        }

        $this->form_validation->set_rules('societe', 'societe', 'trim');

        // Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('examen_form', $data);
        } else {
            $this->load->helper('text');

				$save = array();
				$save['id'] = $id;
				$save['name'] = $this->input->post('name');
				$save['type'] = $this->input->post('type');
				$save['class'] = $this->input->post('class');
				$save['filiere'] = $this->input->post('filiere');
				$save['date'] = DateToMysqlFormat($this->input->post('date'));
				$save['time'] = $this->input->post('time');
				$Examen_id = $this->Examen_model->save($save);
				$this->session->set_flashdata('message', lang('message_saved_categorie'));
				redirect($this->config->item('admin_folder') . '/Examen');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $membre = $this->md_commun->get_row('examen',array('id'=>$id));

        if (membre) {
			
            $this->Examen_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Examen');
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
