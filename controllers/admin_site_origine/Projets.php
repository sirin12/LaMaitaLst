<?php
class Projets extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Projets_model'));
		
    }
	
	function index() {
        $data['page_title'] = 'Projets';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['projets']=$this->md_commun->fetch('projets',array('etat'=>1),'asc',100,0);
		
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('projets', $data);
    }
	
	function blocs($projet_id) {
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('blocs', $data);
    }
	
	function etages($projet_id,$blocs_id) {
        $data['page_title'] = 'Etages';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['etages']=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$blocs_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
		$data['blocs_id'] = $blocs_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('etages', $data);
    }
	
	function appartements($projet_id,$blocs_id,$etages_id) {
        $data['page_title'] = 'Appartements';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['appartements']=$this->md_commun->fetch('appartements',array('projet_id'=>$projet_id,'blocs_id'=>$blocs_id,'etages_id'=>$etages_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
		$data['blocs_id'] = $blocs_id;
		$data['etages_id'] = $etages_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('appartements', $data);
    }
	
	function rapports_tt($projet_id,$bloc_id=false,$etage_id=false,$loc_id=false) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$projet_id,'etat'=>1));
		
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';
		if(($bloc_id)&&($etage_id)&&($loc_id)){
			$data['bloc_id']=$bloc_id;
			$data['etage_id']=$etage_id;
			$data['loc_id']=$loc_id;
			$this->view('rapport_projet_loc', $data);
		}elseif(($bloc_id)&&($etage_id)){
			$data['bloc_id']=$bloc_id;
			$data['etage_id']=$etage_id;
			$this->view('rapport_projet_etage', $data);
		}elseif(($bloc_id)){
			$data['bloc_id']=$bloc_id;
			$this->view('rapport_projet_bloc', $data);
		}
    }
	
	function rapports($projet_id) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$projet_id,'etat'=>1));
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapport_projet', $data);
    }
	
	function rapports_creer($projet_id) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$projet_id,'etat'=>1));
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapport_projet_creer', $data);
    }
	
	function rapports_en_cours($projet_id) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$projet_id,'etat'=>1));
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapport_projet_en_cours', $data);
    }
	function rapports_corriger($projet_id) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$projet_id,'etat'=>1));
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapport_projet_corriger', $data);
    }
	function rapports_valider($projet_id) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$projet_id,'etat'=>1));
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapport_projet_valider', $data);
    }

    /*     * ******************************************************************
      edit form_projet
     * ****************************************************************** */
	function form($id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		
		$data['id'] = '';
        $data['projets'] = '';
		$data['clients_id'] = '';
		$data['adresse'] = '';
		$data['date_debut'] = '';
		$data['aire'] = '';
		$data['cout'] = '';
		$data['image'] = '';
	
		if($id){
			$projets_id=$this->md_commun->get_row('projets',array('id'=>$id));
			if (!$projets_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Projets');
            }
			$data['id']=$id;
			$data['projets']=$projets_id->projets;
			$data['clients_id']=$projets_id->clients_id;
			$data['adresse']=$projets_id->adresse;
			$data['date_debut']=$projets_id->date_debut;
			$data['aire']=$projets_id->aire;
			$data['cout']=$projets_id->cout;
			$data['image']=$projets_id->image;
		}
		
		$this->form_validation->set_rules('projets', 'lang:projets', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('projets_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['projets'] = $this->input->post('projets');
			$save['clients_id'] = $this->input->post('clients_id');
			$save['adresse'] = $this->input->post('adresse');
			$save['date_debut'] = $this->input->post('date_debut');
			$save['aire'] = $this->input->post('aire');
			$save['cout'] = $this->input->post('cout');
			$save['user'] = $id_admin;
			
			$image = $this->upload('image');
            if ($image)
                $save['image'] = $image;
			
			$projets_id = $this->md_commun->save('projets',$save);
			
			
			/**journal**/
			$journalid=$this->md_commun->get_row('projets',array('id'=>$projets_id));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'Projets';
			if($id==false)
				$savejounal['designation'] = 'Ajout projet '.$journalid->projets;
			else 
				$savejounal['designation'] = 'Modification projet '.$journalid->projets;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/projets');
        }
    }
	

	
    /*     * ******************************************************************
      delete_peojet
     * ****************************************************************** */

    function delete($id) {

        $projets_id=$this->md_commun->get_row('projets',array('id'=>$id));

        if ($projets_id) {
			
            $this->md_commun->delete('projets',$id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/projets');
    }
	
	
    /*     * ******************************************************************
      edit form_blocs
     * ****************************************************************** */
	function form_blocs($projet_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
		$data['projet_id'] = $projet_id;
        $data['blocs'] = '';
		$data['image'] = '';
	
		if($id){
			$blocs_id=$this->md_commun->get_row('blocs',array('projet_id'=>$projet_id,'id'=>$id));
			if (!$blocs_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Projets/blocs/'.$projet_id);
            }
			$data['id']=$id;
			$data['blocs']=$blocs_id->blocs;
			$data['projet_id']=$projet_id;
			$data['image']=$blocs_id->image;
		}
		
		$this->form_validation->set_rules('blocs', 'lang:blocs', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('blocs_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['projet_id']=$projet_id;
			$save['blocs'] = $this->input->post('blocs');
			$save['user'] = $id_admin;
			$image = $this->upload('image');
            if ($image)
                $save['image'] = $image;
			
			$blocs_id = $this->md_commun->save('blocs',$save);
			/**journal**/
			$journalid=$this->md_commun->get_row('blocs',array('id'=>$blocs_id));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'Blocs';
			if($id==false)
				$savejounal['designation'] = 'Ajout blocs '.$journalid->blocs;
			else 
				$savejounal['designation'] = 'Modification blocs '.$journalid->blocs;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Projets/blocs/'.$projet_id);
        }
    }
	

	
    /*     * ******************************************************************
      delete_blocs
     * ****************************************************************** */

    function delete_blocs($projet_id,$id) {

        $blocs_id=$this->md_commun->get_row('blocs',array('projet_id'=>$projet_id,'id'=>$id));

        if ($blocs_id) {
			
            $this->md_commun->delete('blocs',$id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') .'/Projets/blocs/'.$projet_id);
    }
	
	
    /*     * ******************************************************************
      edit form_etages
     * ****************************************************************** */
	function form_etages($projet_id,$blocs_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
		$data['projet_id'] = $projet_id;
		$data['blocs_id'] = $blocs_id;
        $data['etages'] = '';
		$data['image'] = '';
	
		if($id){
			$etages_id=$this->md_commun->get_row('etages',array('projet_id'=>$projet_id,'blocs_id'=>$blocs_id,'id'=>$id));
			if (!$etages_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Projets/etages/'.$projet_id.'/'.$blocs_id);
            }
			$data['id']=$id;
			$data['etages']=$etages_id->etages;
			$data['projet_id']=$projet_id;
			$data['blocs_id']=$blocs_id;
			$data['image']=$etages_id->image;
		}
		
		$this->form_validation->set_rules('etages', 'lang:etages', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('etages_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['projet_id']=$projet_id;
			$save['blocs_id']=$blocs_id;
			$save['etages'] = $this->input->post('etages');
			$save['user'] = $id_admin;
			$image = $this->upload('image');
            if ($image)
                $save['image'] = $image;
			$etages_id = $this->md_commun->save('etages',$save);
			/**journal**/
			$journalid=$this->md_commun->get_row('etages',array('id'=>$etages_id));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'etages';
			if($id==false)
				$savejounal['designation'] = 'Ajout etages '.$journalid->etages;
			else 
				$savejounal['designation'] = 'Modification etages '.$journalid->etages;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder'). '/Projets/etages/'.$projet_id.'/'.$blocs_id);
        }
    }
	

	
    /*     * ******************************************************************
      delete_etages
     * ****************************************************************** */

    function delete_etages($projet_id,$id) {

        $blocs_id=$this->md_commun->get_row('blocs',array('projet_id'=>$projet_id,'id'=>$id));

        if ($blocs_id) {
			
            $this->md_commun->delete('blocs',$id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') .'/Projets/blocs/'.$projet_id);
    }
	
	 /*     * ******************************************************************
      edit form_appartements
     * ****************************************************************** */
	function form_appartements($projet_id,$blocs_id,$etages_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
		$data['projet_id'] = $projet_id;
		$data['blocs_id'] = $blocs_id;
		$data['etages_id'] = $etages_id;
        $data['appartements'] = '';
		$data['image'] = '';
	
		if($id){
			$appartements_id=$this->md_commun->get_row('appartements',array('projet_id'=>$projet_id,'blocs_id'=>$blocs_id,'etages_id'=>$etages_id,'id'=>$id));
			if (!$appartements_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/Projets/appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id);
            }
			$data['id']=$id;
			$data['appartements']=$appartements_id->appartements;
			$data['projet_id']=$projet_id;
			$data['blocs_id']=$blocs_id;
			$data['etages_id']=$etages_id;
			$data['image']=$appartements_id->image;
		}
		
		$this->form_validation->set_rules('appartements', 'lang:appartements', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('appartements_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['projet_id']=$projet_id;
			$save['blocs_id']=$blocs_id;
			$save['etages_id']=$etages_id;
			$save['appartements'] = $this->input->post('appartements');
			$save['user'] = $id_admin;
			$image = $this->upload('image');
            if ($image)
                $save['image'] = $image;
			
			$app_id=$this->md_commun->save('appartements',$save);
			
			/**journal**/
			$journalid=$this->md_commun->get_row('appartements',array('id'=>$app_id));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'appartements';
			if($id==false)
				$savejounal['designation'] = 'Ajout appartements '.$journalid->appartements;
			else 
				$savejounal['designation'] = 'Modification appartements '.$journalid->appartements;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder'). '/Projets/appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id);
        }
    }
	

	
    /*     * ******************************************************************
      delete_etages
     * ****************************************************************** */

    function delete_appartements($projet_id,$blocs_id,$etages_id,$id) {

        $app_id=$this->md_commun->get_row('appartements',array('id'=>$id));

        if ($app_id) {
			
            $save = array();
			$save['id'] = $id;
			$save['etat']=0;
			$this->md_commun->save('appartements',$save);
			
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') .'/Projets/appartements/'.$projet_id.'/'.$blocs_id.'/'.$etages_id);
    }
    		
	    /*     * ******************************************************************
      edit form_projet
     * ****************************************************************** */
	function affectations($projet_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['projet_id'] = $projet_id;
		$data['travaux_id']="";
		$data['traveaux_societes'] =  $this->md_commun->fetch('projets_societe',array('projet_id'=>$projet_id),'asc',10000,0);
		if ($current_admin['access'] == 'Admin') {
            $data['traveaus'] = $this->md_commun->fetch('travaux', array('etat' => 1), 'asc', 100, 0);
        } else {
            $data['traveaus'] = $this->md_commun->fetch('travaux', array('etat' => 1, 'user_id' => $id_admin), 'asc', 100, 0);
        }
    

		$travaux_id = $this->Projets_model->get_projet_travaux($projet_id);
		$data['travaux_id'] = $travaux_id->travaux_id;
        if ($this->input->post('travaux_id') ) {
       
			$save = array();
			$save['id'] = $projet_id;
			$save['travaux_id'] = json_encode($this->input->post('travaux_id'));
			
			$projets_societe_id = $this->md_commun->save('projets',$save);
			
			//save page post 
			
            $this->Projets_model->clear_travaux_projets($projet_id);
            foreach($this->input->post('travaux_id') as $trav){
				$this->Projets_model->save_travaux_projets(array('id'=>false,'projet_id'=>$projet_id,'travaux_id'=>$trav));
            }
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/projets/affectations/'.$projet_id);
        }
		$this->view('affectations', $data);
    }
	
	
	/****affectation_societe***/
	function affectation_societe($projet_id,$travaux_id) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['projet_id'] = $projet_id;
		$data['travaux_id']=$travaux_id;
		$data['societes'] =  $this->md_commun->fetch('societes',array('travaux_id'=>$travaux_id),'asc',10000,0);
		
		$travaux_societes=$this->md_commun->fetch('travaux_societe',array('travaux_id'=>$travaux_id,'projet_id'=>$projet_id),'asc',10000,0);
		$societe_id=array();
		if($travaux_societes){foreach($travaux_societes as $trav_sos){
			$societe_id[]=$trav_sos->societe_id;
		}}
		//$societe_id = $this->Projets_model->get_projet_travaux_societe($projet_id,$travaux_id);
		$data['societe_id'] = $societe_id;
        if ($this->input->post('societe_id') ) {
			$sos_id=$this->md_commun->get_row('projets_societe',array('projet_id'=>$projet_id,'travaux_id'=>$travaux_id));
			$save = array();
			$save['id'] = $sos_id->id;
			$save['projet_id'] = $projet_id;
			$save['travaux_id'] = $travaux_id;
			$save['societe_id'] = json_encode($this->input->post('societe_id'));
			
			$projets_societe_id = $this->md_commun->save('projets_societe',$save);
			
			//save page post 
			
            $this->Projets_model->clear_travaux_projets_societes($projet_id,$travaux_id);
            foreach($this->input->post('societe_id') as $soc){
				$this->Projets_model->save_travaux_projets_societe(array('id'=>false,'projet_id'=>$projet_id,'travaux_id'=>$travaux_id,'societe_id'=>$soc));
            }
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/projets/affectations/'.$projet_id);
        }
		$this->view('affectations_societe', $data);
    }
	
	function upload($file) {
        $config['upload_path'] = 'uploads/images/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|svg|pdf|PDF|docx|doc|GIF|JPG|PNG';
        $config['encrypt_name'] = true;
        $config['required'] = false;

        $this->load->library('upload', $config);
        $uploaded = $this->upload->do_upload($file);

        if ($uploaded) {
            $image = $this->upload->data();
            return $image['file_name'];
        } else
            return false;
    }
	
    function notfound() {
        $this->view('404');
    }


}
