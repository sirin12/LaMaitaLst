<?php
class Enseignants extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Enseignants_model','Matieres_model'));
    }

    function index() {
        $data['page_title'] = 'Enseignants';
        $data['enseignants'] = $this->Enseignants_model->get();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('enseignants', $data);
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
		$data['role']='';
		$data['matieres'] = $this->Matieres_model->get();
        $data['page_title'] = 'Enseignants';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $enseignant = $this->Enseignants_model->get_matiere($id);
				
            if (!$enseignant) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Enseignants');
            }

            //set values to db values
            $data['id'] = $enseignant->id;
			$data['nom'] = $enseignant->nom;
			$data['prenom'] = $enseignant->prenom;
			$data['matricule'] = $enseignant->matricule;
			$data['date_naissance'] = $enseignant->date_naissance;
			$data['date_inscription'] = $enseignant->date_inscription;
			$data['email'] = $enseignant->email;
			$data['phone'] = $enseignant->phone;
			$data['subject'] = $enseignant->subject;
			$data['gender'] = $enseignant->gender;
			$data['type'] = $enseignant->type;
			$data['password'] = $enseignant->password;
			$data['image'] = $enseignant->image;
			$data['role'] = $enseignant->role;
			$data['matiere_id'] = $enseignant->matiere;
        }

        $this->form_validation->set_rules('nom', 'nom', 'trim');

        // Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('enseignant_form', $data);
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
				$save['role'] = 5;
				if ($this->input->post('password') != '' || !$id) {
					$save['password'] = sha1($this->input->post('password'));
				}
				if($avatar=$this->upload('image'))
				{
					$save['image'] = $avatar;
				}
				
				
				$enseignants_id = $this->Enseignants_model->save($save);
				//save user matiere 
				$this->Enseignants_model->clear_matiere($enseignants_id);
				 foreach($this->input->post('matiere_id') as $matiere){
					 $this->Enseignants_model->save_matiere(array('matiere_id'=>$matiere,'user_id'=>$enseignants_id));
				 }
			 
				$this->session->set_flashdata('message', lang('message_saved_categorie'));
				redirect($this->config->item('admin_folder') . '/Enseignants');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $membre = $this->md_commun->get_row('enseignants',array('id'=>$id));

        if (membre) {
			
            $this->Enseignants_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Enseignants');
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
