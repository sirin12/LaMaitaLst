<?php
class Facture_steg extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }

	function index() {
        $data['page_title'] = 'Matieres';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		$data['annee']=$annee=$this->md_commun->get_row('annees',array('active'=>1));
		$data['annees']=$this->md_commun->fetch('annees',array(),'asc',1000,0);
		$data['periodes']=$this->md_commun->fetch('periode',array(),'asc',1000,0);
		$data['semestres']=$this->md_commun->fetch('semestre',array(),'asc',1000,0);
		$data['gares']=$this->md_commun->fetch('gares',array(),'asc',100,0);
		$data['facture_stegs']=$this->md_commun->fetch('facture_steg',array(),'asc',1000,0);
        $data['page_icon'] = 'icon-file-alt';

        $this->view('facture_stegs', $data);
    }
	
	function gares() {
        $data['page_title'] = 'Gare';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['gares']=$this->md_commun->fetch('gares',array(),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('gares', $data);
    }
	
	function recap() {
        $data['page_title'] = 'متابعة السنوية لإستهلاك الكهرباء ';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['gares']=$this->md_commun->fetch('gares',array(),'asc',100,0);
		$data['facture_steg']=$this->md_commun->fetch('facture_steg',array(),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('recap_steg', $data);
    }
    /*     * ******************************************************************
      edit form_matiere
     * ****************************************************************** */
	function form_gare($id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['gare'] = '';
		$data['numero']= '';
	
		if($id){
			$gare_id=$coiefficient_id=$this->md_commun->get_row('gares',array('id'=>$id));
			if (!$gare_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/gares');
            }
			$data['id']=$id;
			$data['gare']=$gare_id->gare;
			$data['numero']=$gare_id->numero;
		}
		
		$this->form_validation->set_rules('gare', 'lang:gare', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('gare_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['gare'] = $this->input->post('gare');
			$save['numero'] = $this->input->post('numero');
			
			$gare_id = $this->md_commun->save('gares',$save);
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Facture_steg/gares');
        }
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
        $data['gare'] = '';
		$data['annee']= '';
		$data['periode']= '';
		$data['semestre']= '';
		$data['index_ancien']= '';
		$data['index_nouveau']= '';
		$data['difference']= '';
		$data['montant']= '';
		
		$data['annees']=$this->md_commun->fetch('annees',array(),'asc',1000,0);
		$data['periodes']=$this->md_commun->fetch('periode',array(),'asc',1000,0);
		$data['semestres']=$this->md_commun->fetch('semestre',array(),'asc',1000,0);
		$data['gares']=$this->md_commun->fetch('gares',array(),'asc',100,0);
		if($id){
			$facture_id=$coiefficient_id=$this->md_commun->get_row('facture_steg',array('id'=>$id));
			if (!$facture_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Facture_steg');
            }
			$data['id']=$id;
			$data['gare']=$facture_id->gare;
			$data['annee']= $facture_id->annee;
			$data['semestre']= $facture_id->semestre;
			$data['periode']= $facture_id->periode;
			$data['index_ancien']= $facture_id->index_ancien;
			$data['index_nouveau']= $facture_id->index_nouveau;
			$data['difference']= $facture_id->difference;
			$data['montant']= $facture_id->montant;
		}
		
		$this->form_validation->set_rules('gare', 'lang:gare', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('facture_stegs_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['gare'] = $this->input->post('gare');
			$save['annee']= $this->input->post('annee');
			$save['semestre']= $this->input->post('semestre');
			$save['periode']= $this->input->post('periode');
			$save['index_ancien']= $this->input->post('index_ancien');
			$save['index_nouveau']= $this->input->post('index_nouveau');
			$save['difference']= $this->input->post('index_nouveau') - $this->input->post('index_ancien');
			$save['montant']= $this->input->post('montant');
			
			$gare_id = $this->md_commun->save('facture_steg',$save);
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Facture_steg');
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
