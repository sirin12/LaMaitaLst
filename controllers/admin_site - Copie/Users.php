<?php
class Users extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model('Users_model');
    }

    function index() {
        $data['page_title'] = 'users';
        $data['users'] = $this->Users_model->get();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('users', $data);
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
		$data['email'] = '';
		$data['phone'] = '';
		$data['password'] = '';
		$data['role'] = '';
		$data['lecture'] = '';
		$data['ecriture'] = '';
		$data['creation'] = '';
		$data['suppression'] = '';
		$data['ticket'] = '';
		$data['note'] = '';
		$data['note2'] = '';
		$data['affectation'] = '';
		$data['export'] = '';
		
        $data['page_title'] = 'users';
        $data['page_icon'] = 'icon-file-alt';
        if ($id) {

            $user = $this->Users_model->get($id);
				
            if (!$user) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/users');
            }

            //set values to db values
            $data['id'] = $user->id;
			$data['nom'] = $user->nom;
			$data['prenom'] = $user->prenom;
			$data['matricule'] = $user->matricule;
			$data['email'] = $user->email;
			$data['phone'] = $user->phone;
			$data['password'] = $user->password;
			$data['role'] = $user->role;
			$data['lecture'] = $user->lecture;
			$data['ecriture'] = $user->ecriture;
			$data['creation'] = $user->creation;
			$data['suppression'] = $user->suppression;
			$data['ticket'] = $user->ticket;
			$data['note'] = $user->note;
			$data['note2'] = $user->note2;
			$data['affectation'] = $user->affectation;
			$data['export'] = $user->export;
        }

        $this->form_validation->set_rules('name', 'name', 'trim');

        // Validate the form
        if ($this->form_validation->run() == true) {
            $this->load->helper('text');

			$save = array();
			$save['id'] = $id;
			$save['nom'] = $this->input->post('nom');
			$save['prenom'] = $this->input->post('prenom');
			$save['matricule'] = $this->input->post('matricule');
			$save['email'] = $this->input->post('email');
			$save['phone'] = $this->input->post('phone');
			if ($this->input->post('password') != '' || !$id) {
				$save['password'] = sha1($this->input->post('password'));
			}
			$save['role'] = $this->input->post('role');
			$save['lecture'] = $this->input->post('lecture');
			$save['ecriture'] = $this->input->post('ecriture');
			$save['creation'] = $this->input->post('creation');
			$save['suppression'] = $this->input->post('suppression');
			$save['ticket'] = $this->input->post('ticket');
			$save['note'] = $this->input->post('note');
			$save['note2'] = $this->input->post('note2');
			$save['affectation'] = $this->input->post('affectation');
			$save['export'] = $this->input->post('export');
			$users_id = $this->Users_model->save($save);
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/users');
        }
    }
	
    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $membre = $this->md_commun->get_row('users',array('id'=>$id));

        if (membre) {
			
            $this->Users_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/users');
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
