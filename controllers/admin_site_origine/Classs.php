<?php
class Classs extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Class_model','Filieres_model','Matieres_model','Coefficient_model','Enseignants_model','Etudiants_model'));
    }

    function index() {
        $data['page_title'] = 'Class';
        $data['classs'] = $this->Class_model->get();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('class', $data);
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
		$data['filiere'] = '';
		
		
        $data['page_title'] = 'Class';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $class = $this->Class_model->get($id);
				
            if (!$class) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/classs');
            }

            //set values to db values
            $data['id'] = $class->id;
			$data['name'] = $class->name;
			$data['filiere'] = $class->filiere;
        }

        $this->form_validation->set_rules('name', 'name', 'trim');

        // Validate the form
        if ($this->form_validation->run() == true) {
            $this->load->helper('text');

			$save = array();
			$save['id'] = $id;
			$save['name'] = $this->input->post('name');
			$save['filiere'] = $this->input->post('filiere');
			$Departments_id = $this->Class_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/classs');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $membre = $this->md_commun->get_row('class',array('id'=>$id));

        if (membre) {
			
            $this->Class_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/classs');
    }
	
	
	function matieres($class) {
        $data['page_title'] = 'Class matiere coiefficient';
        $data['coefficients'] = $this->Class_model->get_matiere($class);
		$data['class']=$class;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('class_matiere', $data);
    }

    /*     * ******************************************************************
      edit form_matiere
     * ****************************************************************** */
	function form_matiere($class,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        //set the default values
        $data['id'] = '';
		$data['class'] = $class;
		$data['coefficient'] = '';
		$data['matiere_id'] = '';
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
                redirect($this->config->item('admin_folder') . '/Classs/matieres/'.$class);
            }

            //set values to db values
            $data['id'] = $coefficient->id;
			$data['class'] = $class;
			$data['coefficient'] = $coefficient->coefficient;
			$data['matiere_id'] = $coefficient->matiere_id;
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
			$save['class_id'] = $class;
			$save['coefficient'] = $this->input->post('coefficient');
			$save['matiere_id'] = $this->input->post('matiere_id');
			$save['td'] = $this->input->post('td');
			$save['tp'] = $this->input->post('tp');
			$save['principal'] = $this->input->post('principal');
			
			$coefficient_id = $this->Coefficient_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Classs/matieres/'.$class);
        }
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
    
	function notes($class,$id) {
        $data['page_title'] = 'Matieres';
		$current_admin = $this->session->userdata('users');
		$id_admin=$current_admin['id'];
		$data['coiefficient_id']=$coiefficient_id=$this->md_commun->get_row('coefficient',array('id'=>$id));
		$data['clasid']=$clasid=$this->Class_model->get($coiefficient_id->class_id);
		$data['id']=$id;
		$data['class']=$class;
		
		$data['etudiants']=$this->Etudiants_model->get_etudiants_class('2020',$coiefficient_id->class_id);
		
		$data['notes']=$this->Etudiants_model->get_note_matiere_suppadmin_etud('2020',$coiefficient_id->matiere_id,$coiefficient_id->class_id);
        //$data['coefficients'] = $this->Class_model->get_matiere_enseignant_notes($id_admin,$id);
        $data['page_icon'] = 'icon-file-alt';

        $this->view('class_notes', $data);
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
