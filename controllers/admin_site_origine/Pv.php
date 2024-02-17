<?php
class Pv extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }
	
	function index() {
        $data['page_title'] = 'Pv renion';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		
		$data['pvs']=$this->md_commun->fetch('pv',array('etat'=>1),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('pv', $data);
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
        $data['projet_id'] = '';
		$data['content'] = '';
	
		if($id){
			$pv_id=$this->md_commun->get_row('pv',array('id'=>$id));
			if (!$pv_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/pv');
            }
			$data['id']=$id;
			$data['projet_id']=$pv_id->projet_id;
			$data['content']=$pv_id->content;
		}
		
		$this->form_validation->set_rules('clients', 'lang:clients', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('pv_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['projet_id'] = $this->input->post('projet_id');
			$save['content'] = $this->input->post('content');
			$save['date'] = date('Y-m-d');
			$save['user_id'] = $id_admin;
			$clients_idd = $this->md_commun->save('pv',$save);
			
			/**journal**/
			$journalid=$this->md_commun->get_row('pv',array('id'=>$clients_idd));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'pv';
			if($id==false)
				$savejounal['designation'] = 'Ajout pv '.$journalid->id;
			else 
				$savejounal['designation'] = 'Modification pv '.$journalid->id;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/pv');
        }
    }
	
	function rapports($pv_id) {
		$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		$data['pv']=$pv=$this->md_commun->get_row('pv',array('id'=>$pv_id,'etat'=>1));
		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$pv->projet_id,'etat'=>1));
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapport_pv', $data);
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
