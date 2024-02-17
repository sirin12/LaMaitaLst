<?php
class Pv extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array('Projets_model'));
    }
	
	function index($projet_id) {
        $data['page_title'] = 'Pv renion';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['projet_id']=$projet_id;
		$data['pvs']=$this->md_commun->fetch('pv',array('etat'=>1,'projet_id'=>$projet_id),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('pv', $data);
    }

    /*     * ******************************************************************
      edit form_societes
     * ****************************************************************** */
	function form($projet_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['projet_id']=$projet_id;
		$data['content'] = '';
		$pv_idans=$this->md_commun->get_last_rowcond('pv',array('etat'=>1));
		if($pv_idans){$data['numero'] = $pv_idans->numero+1;}else $data['numero'] =1; 

	
		if($id){
			$pv_id=$this->md_commun->get_row('pv',array('id'=>$id));
			if (!$pv_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/pv/index/'.$projet_id);
            }
			$data['id']=$id;
			$data['projet_id']=$projet_id;
			$data['content']=$pv_id->content;
			$data['numero']=$pv_id->numero;
		}
		
		$this->form_validation->set_rules('clients', 'lang:clients', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('pv_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['projet_id'] = $projet_id;
			$save['content'] = $this->input->post('content');
			$save['numero'] = $this->input->post('numero');
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
			redirect($this->config->item('admin_folder') . '/pv/index/'.$projet_id);
        }
    }
	
	/*     * ******************************************************************
      edit form_affectation
     * ****************************************************************** */
	function affectations($projet_id,$pv_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['pv_id'] = $pv_id;
		$data['projet_id'] = $projet_id;
		$data['societe_id']="";
		
		$data['pv_societes']=$pv_societes =  $this->md_commun->fetch('societes_admin_pv',array('pv_id'=>$pv_id),'asc',10000,0);
		if((!$pv_societes)&&($pv_id)){
			
			$societes_projs=$this->md_commun->fetch('travaux_societe',array('projet_id'=>$projet_id),'asc',10000,0);
			if($societes_projs){foreach($societes_projs as $sosproj){
				if($pv_id){
					$sosid=$this->md_commun->get_row('societes',array('id'=>$sosproj->societe_id));
					$this->Projets_model->save_societes_admin_pv(array('id'=>false,'pv_id'=>$pv_id,'societe_id'=>$sosproj->societe_id,'type_id'=>$sosid->type_id,'sequence'=>$sosid->sequence));
						
					$pv_contacts =  $this->md_commun->fetch('contacts',array('societe_id'=>$sosproj->societe_id,'etat'=>1),'asc',10000,0);
						
						
					if($pv_contacts){foreach($pv_contacts as $pv_contact){
						$this->Projets_model->save_societes_admin_pv_contact(array('id'=>false,'pv_id'=>$pv_id,'societe_id'=>$sosproj->societe_id,'contact_id'=>$pv_contact->id));
					}}
				}
			}}
			redirect($this->config->item('admin_folder') . '/Pv/affectations_list/'.$projet_id.'/'.$pv_id);
		}else{
			redirect($this->config->item('admin_folder') . '/Pv/affectations_list/'.$projet_id.'/'.$pv_id);
		}
		
		
		
		
		
		/*$societe_id = $this->Projets_model->get_societes_admin_pv($pv_id);
		$data['societe_id'] = $societe_id->societe_id;
        if ($this->input->post('societe_id') ) {
       
			$save = array();
			$save['id'] = $pv_id;
			$save['societe_id'] = json_encode($this->input->post('societe_id'));
			
			$projets_societe_id = $this->md_commun->save('pv',$save);
			
			//save page post 
			
            $this->Projets_model->clear_societes_admin_pv($pv_id);
			$this->Projets_model->clear_societes_admin_pv_contact($pv_id);
            foreach($this->input->post('societe_id') as $trav){
				$this->Projets_model->save_societes_admin_pv(array('id'=>false,'pv_id'=>$pv_id,'societe_id'=>$trav));
				
				$pv_contacts =  $this->md_commun->fetch('contacts',array('societe_id'=>$trav),'asc',10000,0);
				
				
				if($pv_contacts){foreach($pv_contacts as $pv_contact){
					$this->Projets_model->save_societes_admin_pv_contact(array('id'=>false,'pv_id'=>$pv_id,'societe_id'=>$trav,'contact_id'=>$pv_contact->id));
				}}
		   }
			
			
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Pv/affectations/'.$projet_id.'/'.$pv_id);
        }*/
		
    }
	
	function affectations_list($projet_id,$pv_id,$id = false) {
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['pv_id'] = $pv_id;
		$pvid=$this->md_commun->get_row('pv',array('id'=>$pv_id));
		$data['numero'] = $pvid->numero;
		$data['projet_id'] = $projet_id;
		$data['societe_id']="";
		
		$data['pv_societes']=$pv_societes =  $this->md_commun->fetch('societes_admin_pv',array('pv_id'=>$pv_id),'asc',10000,0);
		$data['societes'] =  $this->md_commun->fetch('societes',array(),'asc',10000,0);
		$this->view('affectations_pv', $data);
	}
	
	
	/*function affectations($pv_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['pv_id'] = $pv_id;
		$data['societe_id']="";
		$data['pv_societes'] =  $this->md_commun->fetch('societes_admin_pv',array('pv_id'=>$pv_id),'asc',10000,0);
		$data['societes'] =  $this->md_commun->fetch('societes',array(),'asc',10000,0);

		$societe_id = $this->Projets_model->get_societes_admin_pv($pv_id);
		$data['societe_id'] = $societe_id->societe_id;
        if ($this->input->post('societe_id') ) {
       
			$save = array();
			$save['id'] = $pv_id;
			$save['societe_id'] = json_encode($this->input->post('societe_id'));
			
			$projets_societe_id = $this->md_commun->save('pv',$save);
			
			//save page post 
			
            $this->Projets_model->clear_societes_admin_pv($pv_id);
			$this->Projets_model->clear_societes_admin_pv_contact($pv_id);
            foreach($this->input->post('societe_id') as $trav){
				$this->Projets_model->save_societes_admin_pv(array('id'=>false,'pv_id'=>$pv_id,'societe_id'=>$trav));
				
				$pv_contacts =  $this->md_commun->fetch('contacts',array('societe_id'=>$trav),'asc',10000,0);
				
				
				if($pv_contacts){foreach($pv_contacts as $pv_contact){
					$this->Projets_model->save_societes_admin_pv_contact(array('id'=>false,'pv_id'=>$pv_id,'societe_id'=>$trav,'contact_id'=>$pv_contact->id));
				}}
		   }
			
			
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Pv/affectations/'.$pv_id);
        }
		$this->view('affectations_pv', $data);
    }*/
	
	function affectation_contact($projet_id,$pv_id,$societe_id) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['pv_id'] = $pv_id;
		$data['projet_id'] = $projet_id;
		$pvid=$this->md_commun->get_row('pv',array('id'=>$pv_id));
		$data['numero'] = $pvid->numero;
		$data['societe_id']=$societe_id;
		$data['pv_contacts'] = $pv_contacts=  $this->md_commun->fetch('societes_admin_pv_contact',array('pv_id'=>$pv_id,'societe_id'=>$societe_id),'asc',10000,0);
		$data['societes'] =  $this->md_commun->fetch('societes',array(),'asc',10000,0);

		$contact_id = $this->Projets_model->get_societes_admin_pv_contact($pv_id,$societe_id);
		$data['contact_id'] = $contact_id->contact_id;
		
		if($pv_contacts){foreach($pv_contacts as $trav){
				$save0=array();
				$save0['pv_id'] = $pv_id;
				$save0['societe_id'] = $societe_id;
				$save0['contact_id'] = $trav->contact_id;
				$save0['etat'] = 0;
				$this->Projets_model->update_societes_admin_pv_contact($save0);
		}}
        if ($this->input->post('contact_id') ) {
       
			
            foreach($this->input->post('contact_id') as $trav){
				$save=array();
				$save['pv_id'] = $pv_id;
				$save['societe_id'] = $societe_id;
				$save['contact_id'] = $trav;
				$save['etat'] = 1;
				$this->Projets_model->update_societes_admin_pv_contact($save);
		    }
			
			
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/Pv/affectations_list/'.$projet_id.'/'.$pv_id);
        }
		$this->view('affectations_pv_contact', $data);
    }
	
	
	/*     * ******************************************************************
      edit form_societes
     * ****************************************************************** */
	function decisions($projet_id,$pv_id,$societe_id) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['pv_id'] =$pv_id;
		$pvid=$this->md_commun->get_row('pv',array('id'=>$pv_id));
		$data['numero'] = $pvid->numero;
		$data['projet_id'] = $projet_id;
		$data['societe_id'] = $societe_id;
		$data['content'] = '';
	
		
		$pvv_id=$this->md_commun->get_row('pv_decisions',array('pv_id'=>$pv_id,'societe_id'=>$societe_id));
		if($pvv_id){	
			$data['id']=$pvv_id->id;
			$data['pv_id']=$pvv_id->pv_id;
			$data['societe_id']=$pvv_id->societe_id;
			$data['content']=$pvv_id->content;
		}
		
		$this->form_validation->set_rules('content', 'lang:content', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('pv_decisions', $data);
        } else {
			$save = array();
			$pvv_id=$this->md_commun->get_row('pv_decisions',array('pv_id'=>$pv_id,'societe_id'=>$societe_id));
			if ($pvv_id) {
                $save['id'] = $pvv_id->id;
            }else{$save['id'] = false;}
			$save['pv_id'] = $pv_id;
			$save['societe_id'] = $societe_id;
			$save['content'] = $this->input->post('content');
			$save['date'] = date('Y-m-d');
			$save['user_id'] = $id_admin;
			$clients_idd = $this->md_commun->save('pv_decisions',$save);
			
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/pv/affectations_list/'.$projet_id.'/'.$pv_id);
        }
    }
	public function Header() {
			// get the current page break margin
			$bMargin = $this->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $this->AutoPageBreak;
			// disable auto-page-break
			$this->SetAutoPageBreak(false, 0);
			// set bacground image
			$img_file = admin_img('entete.jpg');
			$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$this->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$this->setPageMark();
		}
	function rapports($proj_id,$pv_id) {
		$this->load->library('Pdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		$data['pv']=$pv=$this->md_commun->get_row('pv',array('id'=>$pv_id,'etat'=>1));
		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$proj_id,'etat'=>1));
		$data['pv_id'] = $pv_id;
        $data['page_icon'] = 'icon-file-alt';
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Rapport projet');

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(5);

		// remove default footer
		$pdf->setPrintFooter(true);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// --- example with background set on page ---

		// remove default header
		$pdf->setPrintHeader(false);

		// add a page
		$pdf->AddPage();

		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		

		// set bacground image
		$img_file = admin_img('entete.jpg');
		$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();
		// set font
		$pdf->SetFont('helvetica', '', 12);

		// Print a text
		$content = $this->load->view('admin_site/rapport_pv', $data, true);
        $pdf->writeHTML($content, true, false, true, false, '');
	
		//Close and output PDF document
		$pdf->Output('rapport_pv.pdf', 'I');
    }
	
    /*     * ******************************************************************
      delete_client
     * ****************************************************************** */

    function delete($projet_id,$id) {

        $clients_id=$this->md_commun->get_row('pv',array('id'=>$id));

        if ($clients_id) {
			
			$save = array();
			$save['id'] = $id;
			$save['etat']=0;
			
			$clients_idd = $this->md_commun->save('pv',$save);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/pv/index/'.$projet_id);
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
