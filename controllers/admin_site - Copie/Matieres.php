<?php
class Matieres extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Matieres_model','Annees_model'));
    }

    function index() {
        $data['page_title'] = 'Matieres';
        $data['matieres'] = $this->Matieres_model->get();
		$data['annee']=$annee=$this->md_commun->get_row('annee',array('etat'=>1));
		$data['semestres']=$this->md_commun->fetch('annee_duree',array('annee_id'=>$annee->id),'asc',1000,0);
        $data['page_icon'] = 'icon-file-alt';

        $this->view('matieres', $data);
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
		
        $data['page_title'] = 'Matieres';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $matiere = $this->Matieres_model->get($id);
				
            if (!$matiere) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Matieres');
            }

            //set values to db values
            $data['id'] = $matiere->id;
			$data['name'] = $matiere->name;
        }

        $this->form_validation->set_rules('name', 'name', 'trim');

        // Validate the form
        if ($this->form_validation->run() == true) {
            $this->load->helper('text');

			$save = array();
			$save['id'] = $id;
			$save['name'] = $this->input->post('name');
			$save['semestre_id'] = $this->input->post('semestre_id');
			$Matieres_id = $this->Matieres_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Matieres');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $membre = $this->md_commun->get_row('matieres',array('id'=>$id));

        if (membre) {
			
            $this->Matieres_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Matieres');
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
