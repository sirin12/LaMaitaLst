<?php
class Societes extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Projets_model'));
    }
	
	function index() {
        $data['page_title'] = 'Societes';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
	

		if ($current_admin['access'] == 'Admin') {
			$data['societes']=$this->md_commun->fetch('societes', array('etat' => 1), 'asc', 100, 0);
        } else {
            $data['societes']=$this->md_commun->fetch('societes', array('etat' => 1, 'user_id' => $id_admin), 'asc', 100, 0);
        }
    
		
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
		$data['type_id'] = '';
		$data['password'] = '';
		$data['projet_id'] = array();
	
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
			$data['type_id']=$projets_id->type_id;
			$data['password']=$projets_id->password;
			$projets_admin=$this->md_commun->fetch('projets_societe_admin',array('societe_id'=>$id),'asc',10000,0);
			$projet_id=array();
			if($projets_admin){foreach($projets_admin as $proj){
				$projet_id[]=$proj->projet_id;
			}}
			$data['projet_id'] = $projet_id;
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
			$save['type_id'] = $this->input->post('type_id');
			if ($this->input->post('password') != '' || !$id) {
                $save['password'] = sha1($this->input->post('password'));
            }
			$save['projet_id'] = json_encode($this->input->post('projet_id'));
			$save['user'] = $id_admin;
			$societe_id = $this->md_commun->save('societes',$save);
			
			$admind=$this->md_commun->get_row('admin',array('client_id'=>$id));
			$this->Projets_model->clear_projets_admin_societe($admind->id);
            foreach($this->input->post('projet_id') as $trav){
				$this->Projets_model->save_projets_admin_societe(array('id'=>false,'admin_id'=>$admind->id,'projet_id'=>$trav,'societe_id'=>$societe_id));
            }
			
			if($id==false){
				$savea['id'] = false;
				$savea['firstname'] = $this->input->post('societes');
				$savea['email'] = $this->input->post('email');
				$savea['username'] = $this->input->post('email');
				$savea['access'] = 'Admin';
				$savea['client_id'] = $societe_id;
				$savea['type_admin'] = 3;
				if ($this->input->post('password') != '' || !$id) {
					$savea['password'] = sha1($this->input->post('password'));
				}
				$id_admin=$this->auth->save($savea);
				}else{
					$admin_id=$this->md_commun->get_row('admin',array('client_id'=>$id));
					$saveu['id'] = $admin_id->id;
					$saveu['firstname'] = $this->input->post('societes');
					$saveu['email'] = $this->input->post('email');
					$saveu['username'] = $this->input->post('email');
					
					if ($this->input->post('password') != '' || !$id) {
						$saveu['password'] = sha1($this->input->post('password'));
					}
					$id_admin=$this->auth->save($saveu);
				}
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
			$save['societe_id']=$societe_id;
			
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
		
				$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['corre_id'] = $corre_id;
	
		$this->form_validation->set_rules('email', 'lang:email', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('rapport_societe_form', $data);
        } else {
			$cor_id=$this->md_commun->get_row('corrections',array('id'=>$corre_id));
			$save = array();
			$save['id'] = false;
			$save['date'] = date('Y-m-d');
			$save['date_time'] = date('Y-m-d H:i:s');
			$save['user_id'] = $id_admin;
			$save['content'] = $this->input->post('content');
			$save['projet_id'] = $this->input->post('projet_id');
			$save['societe_id'] = $societe_id;
			$save['nb_envoie'] = 0;
			$this->md_commun->save('rapport_societe',$save);
			redirect($this->config->item('admin_folder'). '/Societes/all_rapports/'.$societe_id);
        }
    }	
	
	function all_rapports($societe_id) {
        $data['page_title'] = 'Societes Rapports';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['societe_id'] = $societe_id;
		$data['rapports']=$this->md_commun->fetch('rapport_societe',array('societe_id'=>$societe_id),'asc',10000,0);
		
        $data['page_icon'] = 'icon-file-alt';
	
        $this->view('all_rapport_societe', $data);
    }
	
	function rapports_pdf($societe_id,$corre_id) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['societe_id']=$societe_id;
		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$projet_id,'etat'=>1));
		$data['rapport_societe']=$this->md_commun->get_row('rapport_societe',array('id'=>$corre_id,'etat'=>1));
		$data['societes_projet']=$this->md_commun->fetch('travaux_societe',array('societe_id'=>$societe_id),'asc',100,0);
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapport_societe', $data);
    }	
	
	function send_email($societe_id,$corre_id=false) {
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['corre_id'] = $corre_id;
		$data['societe_id'] = $societe_id;
		
		$this->form_validation->set_rules('email', 'lang:email', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('send_email_societe_form', $data);
        } else {
			$cor_id=$this->md_commun->get_row('rapport_societe',array('id'=>$corre_id));
			$save = array();
			$save['id'] = $corre_id;
			$save['nb_envoie'] = $cor_id->nb_envoie+1;
			$file = $this->upload('file');
            if ($file)
                $save['file'] = $file;
			$this->md_commun->save('rapport_societe',$save);
			
			/*********** Send an email to the admin  ***************/
			 $this->load->library('email');

			  $config['mailtype'] = 'html';

			  $societess=$this->md_commun->get_row('societes',array('id'=>$corrections_id->societe_id));
			  $this->email->initialize($config);

			  $this->email->from('loumi.amir@gmail.com','La maitrise');
			  $this->email->to($this->input->post('societe_id'));
			  $this->email->cc($this->input->post('email'));
			  $this->email->subject('MAJ checklist');
			  $this->email->message(html_entity_decode("*** Remarques ****<br>".$cor_id->content));
			  $this->email->attach(site_url('uploads/rapports/'.$file));
			 
			  $this->email->send();
		  
		  
			redirect($this->config->item('admin_folder'). '/Societes/all_rapports/'.$societe_id);
        }
	}
	
	function upload($file)
    {
      $config['upload_path'] = 'uploads/rapports/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|PDF';
      $config['encrypt_name'] = true;
      $config['required'] = false;

      $this->load->library('upload', $config);
      $uploaded = $this->upload->do_upload($file);

      if ($uploaded) {
			$image = $this->upload->data();
                $this->load->library('image_lib');
                //this is the larger image
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/images/full/' . $image['file_name'];
                $config['new_image'] = 'uploads/images/medium/' . $image['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 500;
                $config['height'] = 500;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //small image
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/images/medium/' . $image['file_name'];
                $config['new_image'] = 'uploads/images/small/' . $image['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 200;
                $config['height'] = 200;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();
            return $image['file_name'];

        }else
      return false;
    }
    function notfound() {
        $this->view('404');
    }


}
