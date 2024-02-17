<?php
class Rapports extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }
	
	function index() {
        $data['page_title'] = 'Rapports';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		if($current_admin['super_admin']==1){
			$data['rapports']=$this->md_commun->fetch('rapports_lists',array('etat'=>1),'asc',100,0);
		}else{
			$data['rapports']=$this->md_commun->fetch('rapports_lists',array('user_id'=>$id_admin,'etat'=>1),'asc',100,0);
		}
        $data['page_icon'] = 'icon-file-alt';

        $this->view('all_rapport_lists', $data);
    }
	function send_email($id=false) {
		
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = $id;
		if($id==false){
			$this->form_validation->set_rules('email', 'lang:email', 'trim');
			// Validate the form
			if ($this->form_validation->run() == false) {
				$this->view('send_rapport_form', $data);
			} else {
				$cor_id=$this->md_commun->get_row('rapports_lists',array('id'=>$id));
				$save = array();
				$save['id'] = false;
				$save['date'] = date('Y-m-d');
				$save['date_time'] = date('Y-m-d H:i:s');
				$save['user_id'] = $id_admin;
				$save['email'] =$emails= $this->input->post('email');
				$save['content'] = $contentt=$this->input->post('content');
				$save['sujet'] =$sujet= $this->input->post('sujet');
				$save['nb_envoie'] = 1;
				$file = $this->upload('file');
				if ($file)
					$save['file'] = $file;
				$this->md_commun->save('rapports_lists',$save);
		
				  
				/*                 * **************** Send the email to the administrator ************* */

                $res = $this->db->where('id', 1)->get('canned_messages');
                $row = $res->row_array();
                $message = $row['content'];
				
				$projet_idd=$this->md_commun->get_row('projets',array('id'=>$projet_id));
				
                //Replace {base_url} by it's value
                $message = str_replace('{base_url}', base_url(), $message);
				$name="amir";
                //Replace {title} by it's value
                $message = str_replace('{title}', $sujet, $message);
                $content = "<table width='100%'>";
                $content .= "<tr><td align='left'></dh><td><strong>MISE A JOUR CHECK NOTES</strong><br>".$contentt."</td></tr>";
                $content .= "</table>";

                //Replace {content} by it's value
                $message = str_replace('{content}', $content, $message);

                $this->load->library('email');
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from($current_admin['email'],$current_admin['firstname'].' '.$current_admin['lastname']);
				  $this->email->to($emails);
				  $this->email->cc('mourad.ktari@gmail.com');
				  $this->email->subject($sujet);
                $this->email->message($message);
				$this->email->attach(site_url('uploads/rapports/'.$file));
                $this->email->send();
					
                /*                 * ****************************************************************** */
			  
				redirect($this->config->item('admin_folder'). '/Rapports');
			}
		}else{
			$cor_id=$this->md_commun->get_row('rapports_lists',array('id'=>$id));
			$emails=$cor_id->email;
			$sujet=$cor_id->sujet;
			$contentt=$cor_id->content;
			$file=$cor_id->file;
			$save = array();
			$save['id'] = $id;
			$save['nb_envoie'] = $cor_id->nb_envoie+1;
			$this->md_commun->save('rapports_lists',$save);
		
			  /*                 * **************** Send the email to the administrator ************* */

                $res = $this->db->where('id', 1)->get('canned_messages');
                $row = $res->row_array();
                $message = $row['content'];
				
				$projet_idd=$this->md_commun->get_row('projets',array('id'=>$projet_id));
				
                //Replace {base_url} by it's value
                $message = str_replace('{base_url}', base_url(), $message);
				$name="amir";
                //Replace {title} by it's value
                $message = str_replace('{title}', $sujet, $message);
                $content = "<table width='100%'>";
                $content .= "<tr><td align='left'></dh><td><strong>MISE A JOUR CHECK NOTES</strong><br>".$contentt."</td></tr>";
                $content .= "</table>";

                //Replace {content} by it's value
                $message = str_replace('{content}', $content, $message);

                $this->load->library('email');
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from($current_admin['email'],$current_admin['firstname'].' '.$current_admin['lastname']);
				  $this->email->to($emails);
				  $this->email->cc('mourad.ktari@gmail.com');
				  $this->email->subject($sujet);
                $this->email->message($message);
				$this->email->attach(site_url('uploads/rapports/'.$file));
                $this->email->send();
					
                /*                 * ****************************************************************** */
		  
			redirect($this->config->item('admin_folder'). '/Rapports');
		
			
        }
	}
	
	/*     * ******************************************************************
      delete_peojet
     * ****************************************************************** */

    function delete($id) {

        $projets_id=$this->md_commun->get_row('rapports_lists',array('id'=>$id));

        if ($projets_id) {
			
			$save = array();
			$save['id'] = $id;
			$save['etat']=0;
			$this->md_commun->save('rapports_lists',$save);
			
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Rapports');
    }
	function upload($file) {
        $config['upload_path'] = 'uploads/rapports/';
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
