<?php
class Annees extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Annees_model'));
    }

    function index() {
        $data['page_title'] = 'Années';
		
		$data['annees'] = $this->Annees_model->get();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('annees', $data);
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
		
		
        $data['page_title'] = 'Annees';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $annee = $this->Annees_model->get($id);
				
            if (!$annee) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/annees');
            }

            //set values to db values
            $data['id'] = $annee->id;
			$data['annee'] = $annee->annee;
			$data['annes_scolaire'] = $annee->annes_scolaire;
        }

        $this->form_validation->set_rules('annee', 'annee', 'trim|required');
		$this->form_validation->set_rules('annes_scolaire', 'annes_scolaire', 'trim|required');

        // Validate the form
        if ($this->form_validation->run() == true) {
            $this->load->helper('text');

			$save = array();
			$save['id'] = $id;
			$save['annee'] = $this->input->post('annee');
			$save['annes_scolaire'] = $this->input->post('annes_scolaire');
			$annee_id = $this->Annees_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/annees');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $annee = $this->md_commun->get_row('annee
		',array('id'=>$id));

        if ($annee) {
			
            $this->Annees_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/annees');
    }
	
	
	function details($annee) {
        $data['page_title'] = 'Détails annees';
        $data['details'] = $this->Annees_model->get_details($annee);
		$data['annee']=$annee;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('annee_detail', $data);
    }

    /*     * ******************************************************************
      edit form_matiere
     * ****************************************************************** */
	function form_detail($annee,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        //set the default values
        $data['id'] = '';
		$data['annee'] = $annee;
		$data['annee_id'] = '';
		$data['semestre'] = '';
		$data['date_debut'] = '';
		$data['date_fin'] = '';
		
        $data['page_title'] = 'Coefficient';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $coefficient = $this->Annees_model->get_details($annee,$id);
				
            if (!$coefficient) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Annees/details/'.$annee);
            }

            //set values to db values
            $data['id'] = $coefficient->id;
			$data['annee'] = $annee;
			$data['semestre'] = $coefficient->semestre;
			$data['date_debut'] = $coefficient->date_debut;
			$data['date_fin'] = $coefficient->date_fin;
        }

        $this->form_validation->set_rules('annee', 'annee', 'trim');

        // Validate the form
        if ($this->form_validation->run() == true) {
            $this->load->helper('text');

			$save = array();
			$save['id'] = $id;
			$save['annee_id'] = $annee;
			$save['annee'] = $annee;
			$save['date_debut'] = $this->input->post('date_debut');
			$save['date_fin'] = $this->input->post('date_fin');
			$save['semestre'] = $this->input->post('semestre');
			
			$coefficient_id = $this->Annees_model->save_details($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Annees/details/'.$annee);
        }
    }
	

    /*     * ******************************************************************
      delete_matiere
     * ****************************************************************** */

    function delete_detail($annee,$id) {

        $membre = $this->md_commun->get_row('annee_duree',array('id'=>$id));

        if ($membre) {
			
            $this->Annees_model->delete_detail($id);
		
			
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Annees/details/'.$annee);
    }
	
	/*     * ******************************************************************
      delete_matiere
     * ****************************************************************** */

    function affectation_etudiant($annee,$semestre_id) {

        $etudiants = $this->Annees_model->get_etudiants_annee($annee);

        if ($etudiants) {
			
			foreach($etudiants as $etudiant) {
			$save = array();
			$save['etudiant_id'] = $etudiant->etudiant_id;
			$save['annee'] = $annee;
			$save['semestre_id'] = $semestre_id;
			$save['faux_matricule'] = $code_unique=substr(md5(uniqid(rand(1,6))), 0, 8);  ;
			
			$coefficient_id = $this->Annees_model->save_etudiants_annee_semestre($save);
			}
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Annees/details/'.$annee);
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
