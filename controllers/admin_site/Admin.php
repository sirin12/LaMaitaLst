<?php

class Admin extends Admin_Controller {

    //these are used when editing, adding or deleting an admin
    var $admin_id = false;
    var $current_admin = false;

    function __construct() {
        parent::__construct();
        $this->auth->check_access('Admin', true);

        //load the admin language file in
        $this->lang->load('admin');
		$this->load->model(array('Projets_model'));
        $this->current_admin = $this->session->userdata('admin');
    }

    function index() {
        $data['page_title'] = lang('admins');
        $data['page_icon'] = 'icon-user';
        $data['admins'] = $this->auth->get_admin_list();

        $this->view(  'admins', $data);
    }

    function delete($id) {
        //even though the link isn't displayed for an admin to delete themselves, if they try, this should stop them.
        if ($this->current_admin['id'] == $id) {
            $this->session->set_flashdata('message', lang('error_self_delete'));
            redirect($this->config->item('admin_folder')  . '/admin');
        }
		
		/*----journal delete--*/
			$desc_journal = $this->md_commun->get_row('admin',array('id'=>$id));
			$this->journal->add($this->current_admin['id'],'Supression Administrateur', 'Nom: '.$desc_journal->firstname.' '.$desc_journal->lastname);
			/*----end journal--*/
        //delete the user
			$save['id'] = $id;
            $save['etat'] = 0;

            $id_admin=$this->auth->save($save);	
			
        $this->session->set_flashdata('message', lang('message_user_deleted'));
        redirect($this->config->item('admin_folder')  . '/admin');
    }

    function form($id = false) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['page_title'] = lang('admin_form');
        $data['page_icon'] = 'icon-user';

        //default values are empty if the customer is new
        $data['id'] = '';
        $data['firstname'] = '';
        $data['lastname'] = '';
        $data['email'] = '';
        $data['username'] = '';
        $data['access'] = '';
		$data['image'] = '';
		$data['projet_id'] = array();
		
		
        if ($id) {
            $this->admin_id = $id;
            $admin = $this->auth->get_admin($id);
            //if the administrator does not exist, redirect them to the admin list with an error
            if (!$admin) {
                $this->session->set_flashdata('message', lang('admin_not_found'));
                redirect($this->config->item('admin_folder')  . '/admin');
            }
            //set values to db values
            $data['id'] = $admin->id;
            $data['firstname'] = $admin->firstname;
            $data['lastname'] = $admin->lastname;
            $data['email'] = $admin->email;
            $data['username'] = $admin->username;
            $data['access'] = $admin->access;
			$data['image']= $admin->avatar;
			
			$projets_admin=$this->md_commun->fetch('projets_admin',array('admin_id'=>$id),'asc',10000,0);
			$projet_id=array();
			if($projets_admin){foreach($projets_admin as $proj){
				$projet_id[]=$proj->projet_id;
			}}
			$data['projet_id'] = $projet_id;
			
			/*$projet_id = $this->Projets_model->get_projet_admin($id);
			$data['projet_id'] = $projet_id->projet_id;*/
			
        }
		
		
        $this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|max_length[32]');
        $this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|max_length[32]');
        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[128]');

        //if this is a new account require a password, or if they have entered either a password or a password confirmation
        if ($this->input->post('password') != '' || !$id) {
            $this->form_validation->set_rules('password', 'lang:password', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
			$this->view(  'admin_form', $data);

        } else {
            $save['id'] = $id;
            $save['firstname'] = $this->input->post('firstname');
            $save['lastname'] = $this->input->post('lastname');
            $save['email'] = $this->input->post('email');
            $save['username'] = $this->input->post('email');
            $save['access'] = 'Admin';
			$save['projet_id'] = json_encode($this->input->post('projet_id'));

            if ($this->input->post('password') != '' || !$id) {
                $save['password'] = sha1($this->input->post('password'));
            }
            if($avatar=$this->upload('image'))
            {
                $save['avatar'] = $avatar;
            }

            $id_admin=$this->auth->save($save);
			
			$this->Projets_model->clear_projets_admin($id);
            foreach($this->input->post('projet_id') as $trav){
				$this->Projets_model->save_projets_admin(array('id'=>false,'admin_id'=>$id,'projet_id'=>$trav));
            }
			
			/*----journal--*/
			$admin_admin = $this->auth->get_admin($id);
			$desc_journal = $this->md_commun->get_row('admin',array('id'=>$id_admin));
			if($id){
			$this->journal->add($admin_admin->id,'Modification Administrateur', 'Nom: '.$desc_journal->firstname.' '.$desc_journal->lastname);
			}else{
				$this->journal->add($admin_admin->id,'Insertion Administrateur', 'Nom: '.$desc_journal->firstname.' '.$desc_journal->lastname);
			}
			/*----journal--*/
			
            $this->session->set_flashdata('message', lang('message_user_saved'));

            //go back to the customer list
            redirect($this->config->item('admin_folder')  . '/admin');
        }
    }

    function check_username($str) {
        $email = $this->auth->check_username($str, $this->admin_id);
        if ($email) {
            $this->form_validation->set_message('check_username', lang('error_username_taken'));
            return FALSE;
        } else {
            return TRUE;
        }
    }
	function clients() {
        $clients = $this->md_commun->fetch('clients',array('etat'=>1),'asc',100,0);
        if ($clients) {foreach($clients as $clt){
            $save['id'] = false;
            $save['firstname'] = $clt->clients;
			$save['email'] = $clt->email;
            $save['client_id'] = $clt->id;
			$save['type_admin'] = 2;
            $this->auth->save($save);
        }}
    }
	function entreprises() {
        $clients = $this->md_commun->fetch('societes',array('etat'=>1),'asc',1000,0);
        if ($clients) {foreach($clients as $clt){
            $save['id'] = false;
            $save['firstname'] = $clt->societes;
			$save['email'] = $clt->email;
            $save['client_id'] = $clt->id;
			$save['type_admin'] = 3;
            $this->auth->save($save);
        }}
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


}
