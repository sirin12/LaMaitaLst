<?php
class Matiere_enseignants extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Class_model','Filieres_model','Matieres_model','Coefficient_model','Enseignants_model','Etudiants_model'));
    }

	function index() {
        $data['page_title'] = 'Matieres';
		$current_admin = $this->session->userdata('users');
		$id_admin=$current_admin['id'];
        $data['coefficients'] = $this->Class_model->get_matiere_enseignant($id_admin);
        $data['page_icon'] = 'icon-file-alt';

        $this->view('enseignant_matiere', $data);
    }
	
	function notes($id) {
        $data['page_title'] = 'Matieres';
		$current_admin = $this->session->userdata('users');
		$id_admin=$current_admin['id'];
		$data['coiefficient_id']=$coiefficient_id=$this->md_commun->get_row('coefficient',array('id'=>$id));
		$data['clasid']=$clasid=$this->Class_model->get($coiefficient_id->class_id);
		$data['id']=$id;
		
		$data['etudiants']=$this->Etudiants_model->get_etudiants_class('2020',$coiefficient_id->class_id);
		
		$data['notes']=$this->Etudiants_model->get_note_matiere_ens_etud('2020',$coiefficient_id->matiere_id,$coiefficient_id->class_id,$id_admin);
        //$data['coefficients'] = $this->Class_model->get_matiere_enseignant_notes($id_admin,$id);
        $data['page_icon'] = 'icon-file-alt';

        $this->view('enseignant_matiere_notes', $data);
    }

    /*     * ******************************************************************
      edit form_matiere
     * ****************************************************************** */
	function form_note($coief,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('users');
		$id_admin=$current_admin['id'];
		$data['coiefficient_id']=$coiefficient_id=$this->md_commun->get_row('coefficient',array('id'=>$coief));
		$data['clasid']=$clasid=$this->Class_model->get($coiefficient_id->class_id);
		$data['id']=$id;
		
		$etudiants=$this->Etudiants_model->get_etudiants_class('2020',$coiefficient_id->class_id);
		
		$i=0;if($etudiants){foreach($etudiants as $etudiant){$i++;
			$save = array();
			$save['class_id'] = $this->input->post('class_id'.$i);
			$save['matiere_id'] = $this->input->post('matiere_id'.$i);
			$save['etudiants_id'] = $this->input->post('etudiants_id'.$i);
			$save['enseignants_id'] = $id_admin;
			$save['td'] = $this->input->post('td'.$i);
			$save['tp'] = $this->input->post('tp'.$i);
			$save['principal'] = $this->input->post('principal'.$i);
			
			$coefficient_id = $this->Etudiants_model->save_note($save);
		}}
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Matiere_enseignants/notes/'.$coief);
     
    }
	
	
	/*     * ******************************************************************
      edit form_matiere
     * ****************************************************************** */
	function form_note_edit($coief,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('users');
		$id_admin=$current_admin['id'];
		$data['coiefficient_id']=$coiefficient_id=$this->md_commun->get_row('coefficient',array('id'=>$coief));
		$data['clasid']=$clasid=$this->Class_model->get($coiefficient_id->class_id);
		$data['id']=$id;
		
		$etudiants=$this->Etudiants_model->get_etudiants_class('2020',$coiefficient_id->class_id);
		
		$notes=$this->Etudiants_model->get_note_matiere_ens_etud('2020',$coiefficient_id->matiere_id,$coiefficient_id->class_id,$id_admin);
		
		$i=0;if($notes){foreach($notes as $note){$i++;
			$id_note=$this->input->post('id'.$i);
			if($id_note==$note->id){
				$save = array();
				$save['id'] = $id_note;
				$save['class_id'] = $this->input->post('class_id'.$i);
				$save['matiere_id'] = $this->input->post('matiere_id'.$i);
				$save['etudiants_id'] = $this->input->post('etudiants_id'.$i);
				$save['enseignants_id'] = $id_admin;
				$save['td'] = $this->input->post('td'.$i);
				$save['tp'] = $this->input->post('tp'.$i);
				$save['principal'] = $this->input->post('principal'.$i);
				
				$coefficient_id = $this->Etudiants_model->save_note_edit($save);
			}
		}}
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Matiere_enseignants/notes/'.$coief);
     
    }
	
	/*     * ******************************************************************
      edit form_matiere
     * ****************************************************************** */
	function form_enseignant($class,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        //set the default values
        $data['id'] = '';
		$data['enseignants_id'] = '';
		
        $data['page_title'] = 'Coefficient';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $coefficient = $this->Coefficient_model->get($id);
				
            if (!$coefficient) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Classs/matieres/'.$class);
            }

            //set values to db values
            $data['id'] = $coefficient->id;
			$data['enseignants_id'] = $coefficient->enseignants_id;
        }

        $this->form_validation->set_rules('enseignants_id', 'enseignants_id', 'trim');

        // Validate the form
        if ($this->form_validation->run() == true) {
            $this->load->helper('text');

			$save = array();
			$save['id'] = $id;
			$save['enseignants_id'] = $this->input->post('enseignants_id');
			
			$coefficient_id = $this->Coefficient_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Classs/matieres/'.$class);
        }
    }
	
    /*     * ******************************************************************
      delete_matiere
     * ****************************************************************** */

    function delete_matiere($id) {

        $membre = $this->md_commun->get_row('coefficient',array('id'=>$id));

        if (membre) {
			
            $this->Coefficient_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Classs/matieres/'.$class);
    }
    
	
	function valider($id) {

        $coefficient = $this->md_commun->get_row('coefficient',array('id'=>$id));

        if ($coefficient) {
			$save = array();
			$save['id'] = $id;
			$save['valide'] = 1;
			
			$coefficient_id = $this->Coefficient_model->save($save);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Matiere_enseignants');
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
