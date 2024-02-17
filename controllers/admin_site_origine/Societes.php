<?php
class Societes extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }
	
	function index() {
        $data['page_title'] = 'Societes';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['societes']=$this->md_commun->fetch('societes',array('etat'=>1),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('societes', $data);
    }
	function contacts($societe_id) {
        $data['page_title'] = 'Contacts';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['contacts']=$this->md_commun->fetch('contacts',array('societe_id'=>$societe_id,'etat'=>1),'asc',100,0);
		$data['societe_id']=$societe_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('contacts', $data);
    }

    /*     * ******************************************************************
      edit form_societes
     * ****************************************************************** */
	function form($id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['societes'] = '';
		$data['email'] = '';
		$data['travaux_id'] = '';
	
		if($id){
			$projets_id=$this->md_commun->get_row('societes',array('id'=>$id));
			if (!$projets_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/societes');
            }
			$data['id']=$id;
			$data['societes']=$projets_id->societes;
			$data['email']=$projets_id->email;
			$data['travaux_id']=$projets_id->travaux_id;
		}
		
		$this->form_validation->set_rules('societes', 'lang:societes', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('societes_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['societes'] = $this->input->post('societes');
			$save['email'] = $this->input->post('email');
			$save['travaux_id'] = $this->input->post('travaux_id');
			$save['user'] = $id_admin;
			$societe_id = $this->md_commun->save('societes',$save);
			
			/**journal**/
			$journalid=$this->md_commun->get_row('societes',array('id'=>$societe_id));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'societes';
			if($id==false)
				$savejounal['designation'] = 'Ajout societes '.$journalid->societes;
			else 
				$savejounal['designation'] = 'Modification societes '.$journalid->societes;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/societes');
        }
    }
	
	/*     * ******************************************************************
      edit form_contact
     * ****************************************************************** */
	function form_contacts($societe_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['societe_id'] = $societe_id;
		$data['nom']='';
		$data['phone']='';
		$data['email']='';
	
		if($id){
			$projets_id=$this->md_commun->get_row('contacts',array('id'=>$id));
			if (!$projets_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/societes/contacts/'.$societe_id);
            }
			$data['id']=$id;
			$data['nom']=$projets_id->nom;
			$data['phone']=$projets_id->phone;
			$data['email']=$projets_id->email;
			$data['societe_id']=$societe_id;
		}
		
		$this->form_validation->set_rules('societes', 'lang:societes', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('contacts_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['nom'] = $this->input->post('nom');
			$save['phone'] = $this->input->post('phone');
			$save['email'] = $this->input->post('email');
			$save['user'] = $id_admin;
			
			$contacts_id = $this->md_commun->save('contacts',$save);
			
			/**journal**/
			$journalid=$this->md_commun->get_row('contacts',array('id'=>$contacts_id));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'contacts';
			if($id==false)
				$savejounal['designation'] = 'Ajout contacts '.$journalid->nom;
			else 
				$savejounal['designation'] = 'Modification contacts '.$journalid->nom;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder'). '/societes/contacts/'.$societe_id);
        }
    }
	
    /*     * ******************************************************************
      delete_matiere
     * ****************************************************************** */

    function delete($id) {

        $projets_id=$this->md_commun->get_row('societes',array('id'=>$id));

        if ($projets_id) {
			
			$save = array();
			$save['id'] = $id;
			$save['etat'] = 0;
			
			$projets_id = $this->md_commun->save('societes',$save);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/societes');
    }
    	
	function delete_contact($societe_id,$id) {

        $projets_id=$this->md_commun->get_row('contacts',array('id'=>$id));

        if ($projets_id) {
			
			$save = array();
			$save['id'] = $id;
			$save['etat'] = 0;
			
			$projets_id = $this->md_commun->save('contacts',$save);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/societes/contacts/'.$societe_id);
    }
    
	function rapports($societe_id) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['societe_id']=$societe_id;
		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$projet_id,'etat'=>1));
		$data['societes_projet']=$this->md_commun->fetch('travaux_societe',array('societe_id'=>$societe_id),'asc',100,0);
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapport_societe', $data);
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
