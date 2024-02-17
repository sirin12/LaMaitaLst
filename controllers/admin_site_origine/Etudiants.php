<?php
class Etudiants extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Etudiants_model','Class_model'));
    }

    function index() {
        $data['page_title'] = 'Etudiants';
        $data['etudiants'] = $this->Etudiants_model->get();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('etudiants', $data);
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
		$data['nom'] = '';
		$data['prenom'] = '';
		$data['matricule'] = '';
		$data['date_naissance'] = '';
		$data['date_inscription'] = '';
		$data['email'] = '';
		$data['phone'] = '';
		$data['subject'] = '';
		$data['gender'] = '';
		$data['type'] = '';
		$data['password'] = '';
		$data['image']='';
		$data['class'] = '';
		$data['section'] = '';
		$data['classs'] = $this->Class_model->get();
		
        $data['page_title'] = 'Etudiants';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $etudiant = $this->Etudiants_model->get($id);
				
            if (!$etudiant) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Etudiants');
            }

            //set values to db values
            $data['id'] = $etudiant->id;
			$data['nom'] = $etudiant->nom;
			$data['prenom'] = $etudiant->prenom;
			$data['matricule'] = $etudiant->matricule;
			$data['date_naissance'] = $etudiant->date_naissance;
			$data['date_inscription'] = $etudiant->date_inscription;
			$data['email'] = $etudiant->email;
			$data['phone'] = $etudiant->phone;
			$data['subject'] = $etudiant->subject;
			$data['gender'] = $etudiant->gender;
			$data['type'] = $etudiant->type;
			$data['password'] = $etudiant->password;
			$data['image'] = $etudiant->image;
			$data['class'] = $etudiant->class;
        }

        $this->form_validation->set_rules('societe', 'societe', 'trim');

        // Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('etudiant_form', $data);
        } else {
            $this->load->helper('text');

				$save = array();
				$save['id'] = $id;
				$save['nom'] = $this->input->post('nom');
				$save['prenom'] = $this->input->post('prenom');
				$save['matricule'] = $this->input->post('matricule');
				$save['date_naissance'] = DateToMysqlFormat($this->input->post('date_naissance'));
				$save['date_inscription'] = DateToMysqlFormat($this->input->post('date_inscription'));
				$save['email'] = $this->input->post('email');
				$save['phone'] = $this->input->post('phone');
				$save['subject'] = $this->input->post('subject');
				$save['gender'] = $this->input->post('gender');
				$save['type'] = $this->input->post('type');
				$save['class'] = $this->input->post('class');
				$save['annee'] = '2020';
				if ($this->input->post('password') != '' || !$id) {
					$save['password'] = sha1($this->input->post('password'));
				}
				if($avatar=$this->upload('image'))
				{
					$save['image'] = $avatar;
				}
				$etudiants_id = $this->Etudiants_model->save($save);
				
				if ($id) {
					$this->Etudiants_model->clear_etud_anne($etudiants_id);
				}
				$save_etud_anne = array();
				$save_etud_anne['etudiant_id'] = $etudiants_id;
				$save_etud_anne['annee'] = '2020';
				$save_etud_anne['class'] = $this->input->post('class');
				
				$Etudiants_id = $this->Etudiants_model->save_etud_anne($save_etud_anne);
				
				
				$this->session->set_flashdata('message', lang('message_saved_categorie'));
				redirect($this->config->item('admin_folder') . '/Etudiants');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $membre = $this->md_commun->get_row('etudiants',array('id'=>$id));

        if (membre) {
			
            $this->Etudiants_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Etudiants');
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
