<?php
class Clients extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }
	
	function index() {
        $data['page_title'] = 'Clients';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['clients']=$this->md_commun->fetch('clients',array('etat'=>1),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('clients', $data);
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
        $data['clients'] = '';
		$data['travaux_id'] = '';
	
		if($id){
			$clients_id=$this->md_commun->get_row('clients',array('id'=>$id));
			if (!$clients_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/clients');
            }
			$data['id']=$id;
			$data['clients']=$clients_id->clients;
		}
		
		$this->form_validation->set_rules('clients', 'lang:clients', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('clients_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['clients'] = $this->input->post('clients');
			$save['user'] = $id_admin;
			$clients_idd = $this->md_commun->save('clients',$save);
			
			if($id==false){
				$savea['id'] = false;
				$savea['firstname'] = $this->input->post('clients');
				$savea['email'] = '';
				$savea['username'] = '';
				$savea['access'] = 'Admin';
				$savea['client_id'] = $clients_idd;
				$savea['type_admin'] = 2;
				$id_admin=$this->auth->save($savea);
			}
			/**journal**/
			$journalid=$this->md_commun->get_row('clients',array('id'=>$clients_idd));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'clients';
			if($id==false)
				$savejounal['designation'] = 'Ajout clients '.$journalid->clients;
			else 
				$savejounal['designation'] = 'Modification clients '.$journalid->clients;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/clients');
        }
    }
	

	
    /*     * ******************************************************************
      delete_client
     * ****************************************************************** */

    function delete($id) {

        $clients_id=$this->md_commun->get_row('clients',array('id'=>$id));

        if ($clients_id) {
			
			$save = array();
			$save['id'] = $id;
			$save['etat']=0;
			
			$clients_idd = $this->md_commun->save('clients',$save);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/clients');
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
