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

		
		$data['blocs']=$this->md_commun->fetch('blocs',array(),'asc',100,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('rapports', $data);
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
		$data['etat_correction'] = '';
		$data['etat_urgent'] = '';
		$data['bloc_id'] = '';
		$data['etage_id'] = '';
		$data['appartements_id'] = '';
		$data['localisation'] = '';
		$data['travaux_id'] = '';
		$data['societe_id'] = '';
		$data['intitile'] = '';
		$data['observation'] = '';
		$data['date'] = '';
		$data['leve'] = '';
		$data['date_leve'] = '';
		$data['image'] = '';
	
		if($id){
			$corrections_id=$this->md_commun->get_row('corrections',array('id'=>$id));
			if (!$corrections_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/corrections');
            }
			$data['id']=$id;
			$data['projet_id'] =$corrections_id->projet_id;
			$data['etat_correction'] = $corrections_id->etat_correction;
			$data['etat_urgent'] = $corrections_id->etat_urgent;
			$data['bloc_id'] = $corrections_id->bloc_id;
			$data['etage_id'] = $corrections_id->etage_id;
			$data['appartements_id'] = $corrections_id->appartements_id;
			$data['localisation'] = $corrections_id->localisation;
			$data['travaux_id'] = $corrections_id->travaux_id;
			$data['societe_id'] = $corrections_id->societe_id;
			$data['intitile'] = $corrections_id->intitile;
			$data['observation'] = $corrections_id->observation;
			$data['date'] = $corrections_id->date;
			$data['leve'] = $corrections_id->leve;
			$data['date_leve'] = $corrections_id->date_leve;
			$data['image'] = $corrections_id->image;
		}
		
		$this->form_validation->set_rules('intitle', 'lang:intitle', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('corrections_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['projet_id'] = $this->input->post('projet_id');
			$save['etat_correction'] = $this->input->post('etat_correction');
			$save['etat_urgent'] = $this->input->post('etat_urgent');
			if($this->input->post('bloc_idx')){
				$save['bloc_id'] = $this->input->post('bloc_idx');
			}else{
				$save['bloc_id'] = $this->input->post('bloc_id');
			}
			if($this->input->post('etage_idx')){
				$save['etage_id'] = $this->input->post('etage_idx');
			}else{
				$save['etage_id'] = $this->input->post('etage_id');
			}
			if($this->input->post('appartements_idx')){
				$save['appartements_id'] = $this->input->post('appartements_idx');
			}else{
				$save['appartements_id'] = $this->input->post('appartements_id');
			}
			$save['localisation'] = $this->input->post('localisation');
			$save['travaux_id'] = $this->input->post('travaux_id');
			if($this->input->post('societe_idx')){
				$save['societe_id'] = $this->input->post('societe_idx');
			}else{
				$save['societe_id'] = $this->input->post('societe_id');
			}
			$save['intitile'] = $this->input->post('intitile');
			$save['observation'] = $this->input->post('observation');
			$save['date'] = $this->input->post('date');
			$save['leve'] = $this->input->post('leve');
			$save['date_leve'] = $this->input->post('date_leve');
			$image = $this->upload('image');
            if ($image)
                $save['image'] = $image;
			
			$projets_id = $this->md_commun->save('corrections',$save);
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/corrections');
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
        $data['societe_id'] = '';
	
		if($id){
			$projets_id==$this->md_commun->get_row('contacts',array('id'=>$id));
			if (!$projets_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/societes/contacts/'.$societe_id);
            }
			$data['id']=$id;
			$data['societes']=$projets_id->societes;
			$data['societe_id']=$societe_id;
		}
		
		$this->form_validation->set_rules('societes', 'lang:societes', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('contacts_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['societes'] = $this->input->post('contacts');
			
			$projets_id = $this->md_commun->save('contacts',$save);
		
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
			
            $this->md_commun->delete('societes',$id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/societes');
    }
    	
	
	function fetch_blocs($projet_id=false){
		if($projet_id!=false){
		$html_bloc='<label class="form-label"><b>Bloc</b></label>
                        <div class="form-line">
                            <div class="form-group default-select">';
							$blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id),'asc',10000,0);
							$html_bloc.='<select class="form-control " name="bloc_idx" onClick="fetch_etages('.$projet_id.',this.value)">
											<option value="">Seclectionner bloc</option>';
											if($blocs){foreach($blocs as $bloc){ $selected='';/*if($bloc->id==$bloc_id) $selected='selected';*/
											$html_bloc.='<option value="'.$bloc->id.'" '.$selected.'>'.$bloc->blocs.'</option>';
											}}
											$html_bloc.='</select>
										</div>
                                    </div>';
		echo $html_bloc;		
		}
	}
	function fetch_etages($projet_id,$blocs_id=false){
		if($blocs_id!=false){
		$html_etage='<label class="form-label"><b>Etages</b></label>
                        <div class="form-line">
                            <div class="form-group default-select">';
							$etages=$this->md_commun->fetch('etages',array('projet_id'=>$projet_id,'blocs_id'=>$blocs_id),'asc',10000,0);
							$html_etage.='<select class="form-control " name="etage_idx" onClick="fetch_appartements('.$projet_id.','.$blocs_id.',this.value)">
											<option value="">Seclectionner etage</option>';
											if($etages){foreach($etages as $etage){ $selected='';
											$html_etage.='<option value="'.$etage->id.'" '.$selected.'>'.$etage->etages.'</option>';
											}}
											$html_etage.='</select>
										</div>
                                    </div>';
		echo $html_etage;
		}		
	}
	
	function fetch_appartements($projet_id,$blocs_id,$etages_id=false){
		if($etages_id!=false){
		$html_etage='<label class="form-label"><b>Appartements</b></label>
                        <div class="form-line">
                            <div class="form-group default-select">';
							$appartements=$this->md_commun->fetch('appartements',array('projet_id'=>$projet_id,'blocs_id'=>$blocs_id,'etages_id'=>$etages_id),'asc',10000,0);
							$html_etage.='<select class="form-control " name="appartements_idx" onClick="">
											<option value="">Seclectionner appartements</option>';
											if($appartements){foreach($appartements as $app){ $selected='';
											$html_etage.='<option value="'.$app->id.'" '.$selected.'>'.$app->appartements.'</option>';
											}}
											$html_etage.='</select>
										</div>
                                    </div>';
		echo $html_etage;
		}		
	}
	function fetch_societes($trav_id=false){
		if($trav_id!=false){
		$html_etage='<label class="form-label"><b>Sous-Traitant</b></label>
                        <div class="form-line">
                            <div class="form-group default-select">';
							$societes=$this->md_commun->fetch('societes',array('travaux_id'=>$trav_id),'asc',10000,0);
							$html_etage.='<select class="form-control " name="societes_idx" onClick="">
											<option value="">Seclectionner Sous-Traitant</option>';
											if($societes){foreach($societes as $societe){ $selected='';
											$html_etage.='<option value="'.$societe->id.'" '.$selected.'>'.$societe->societes.'</option>';
											}}
											$html_etage.='</select>
										</div>
                                    </div>';
		echo $html_etage;
		}		
	}
	
	function send_email($id = false) {
		$cor_id=$this->md_commun->get_row('corrections',array('id'=>$id));
		$save = array();
		$save['id'] = $id;
		$save['nb_envoie'] = $cor_id->nb_envoie+1;
		$this->md_commun->save('corrections',$save);
		
		/*********** Send an email to the admin  ***************/
		  $this->load->library('email');

		  $config['mailtype'] = 'html';

		  $this->email->initialize($config);

		  $this->email->from('loumi.amir@gmail.com','La maitrise');
		  $this->email->to('loumi.amir@gmail.com');
		  $this->email->subject($save['subject']);
		  $this->email->message(html_entity_decode('*** Corrections ****<br><br><p></p>'));

		  $this->email->send();
	  
		redirect($this->config->item('admin_folder'). '/Corrections');
		
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
