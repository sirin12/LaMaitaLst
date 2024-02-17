<?php
class Corrections extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }
	
	function index() {
        $data['page_title'] = 'Corrections';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		if($current_admin['super_admin']==1){
			$data['corrections']=$this->md_commun->fetch('corrections',array('archive'=>0,'date_archive'=>null),'asc',10000,0);
		}else{
			$data['corrections']=$this->md_commun->fetch('corrections',array('user'=>$id_admin,'archive'=>0,'date_archive'=>null),'asc',10000,0);
		}
        $data['page_icon'] = 'icon-file-alt';

        $this->view('corrections', $data);
    }
	function index_archive() {
        $data['page_title'] = 'Corrections';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		if($current_admin['super_admin']==1){
			$data['corrections']=$this->md_commun->fetch('corrections',array('archive'=>1),'asc',10000,0);
		}else{
			$data['corrections']=$this->md_commun->fetch('corrections',array('user'=>$id_admin,'archive'=>1),'asc',10000,0);
		}
        $data['page_icon'] = 'icon-file-alt';

        $this->view('corrections_archives', $data);
    }
	
	function historiques($cor_id) {
        $data['page_title'] = 'Corrections';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];

		$data['cor_id'] = $cor_id;
		$data['corrections']=$this->md_commun->fetch('corrections_historiques',array('correction_id'=>$cor_id),'asc',10000,0);
		
        $data['page_icon'] = 'icon-file-alt';

        $this->view('corrections_historiques', $data);
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
		$data['etat_correction'] = 1;
		$data['etat_urgent'] = 1;
		$data['afficher'] = 1;
		$data['bloc_id'] = '';
		$data['etage_id'] = '';
		$data['appartements_id'] = '';
		$data['localisation'] = '';
		$data['travaux_id'] = '';
		$data['societe_id'] = '';
		$data['intitile'] = '';
		$data['observation'] = '';
		$data['date'] =$data['date_time'] = date('Y-m-d H:i:s');
		$data['leve'] = '';
		$data['observation_leve'] = '';
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
			if($corrections_id->etat_correction==1){
				$data['etat_correction'] = 4;
			}else{
				$data['etat_correction'] = $corrections_id->etat_correction;
			}
			$data['etat_urgent'] = $corrections_id->etat_urgent;
			$data['afficher'] = $corrections_id->afficher;
			$data['bloc_id'] = $corrections_id->bloc_id;
			$data['etage_id'] = $corrections_id->etage_id;
			$data['appartements_id'] = $corrections_id->appartements_id;
			$data['localisation'] = $corrections_id->localisation;
			$data['travaux_id'] = $corrections_id->travaux_id;
			$data['societe_id'] = $corrections_id->societe_id;
			$data['intitile'] = $corrections_id->intitile;
			$data['observation'] = $corrections_id->observation;
			$data['date'] = $corrections_id->date;
			$data['date_time'] = $corrections_id->date_time;
			$data['leve'] = $corrections_id->leve;
			$data['observation_leve'] = $corrections_id->observation_leve;
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
			$save['afficher'] = $this->input->post('afficher');
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
			$save['date'] =$save['date_time'] = date('Y-m-d H:i:s');
			/*$save['leve'] = $this->input->post('leve');
			$save['observation_leve'] = $this->input->post('observation_leve');
			$save['date_leve'] = $this->input->post('date_leve');*/
			$save['user'] = $id_admin;
			$image = $this->upload('image');
            if ($image)
                $save['image'] = $image;
			
			$corr_id = $this->md_commun->save('corrections',$save);
			
			/*--historiques--*/
			if($id=false){
				$journalid=$this->md_commun->get_row('corrections',array('id'=>$corr_id));
				$saveh = array();
				$saveh['id'] = false;
				$saveh['correction_id'] = $corr_id;
				$saveh['observation_leve'] = $this->input->post('observation_leve');
				$saveh['date_leve'] = $this->input->post('date_leve');
				$saveh['user'] = $id_admin;
				$saveh['image'] = $journalid->image;
				$this->md_commun->save('corrections_historiques',$saveh);
			}
			/*--historiques--*/
			
			/**journal**/
			$journalid=$this->md_commun->get_row('corrections',array('id'=>$corr_id));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'corrections';
			if($id==false)
				$savejounal['designation'] = 'Ajout corrections '.$journalid->intitile;
			else 
				$savejounal['designation'] = 'Modification corrections '.$journalid->intitile;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/corrections');
        }
    }
	
	
	/*     * ******************************************************************
      edit form_societes
     * ****************************************************************** */
	function historiques_form($cor_id,$id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = '';
        $data['cor_id'] = $cor_id;
		$data['observation_leve'] = '';
		$data['date_leve'] = '';
		$data['image'] = '';
	
		if($id){
			$corrections_id=$this->md_commun->get_row('corrections',array('id'=>$id));
			if (!$corrections_id) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/corrections/historiques/'.$cor_id);
            }
			$data['id']=$id;
			$data['cor_id'] =$cor_id;
			$data['observation_leve'] = $corrections_id->observation_leve;
			$data['date_leve'] = $corrections_id->date_leve;
			$data['image'] = $corrections_id->image;
		}
		
		$this->form_validation->set_rules('observation_leve', 'lang:observation_leve', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('corrections_historiques_form', $data);
        } else {
			$save = array();
			$save['id'] = $id;
			$save['correction_id'] = $cor_id;
			$save['observation_leve'] = $this->input->post('observation_leve');
			$save['date_leve'] = $this->input->post('date_leve');
			$save['user'] = $id_admin;
			$image = $this->upload('image');
            if ($image)
                $save['image'] = $image;
			
			$corr_id = $this->md_commun->save('corrections_historiques',$save);
			
			/**journal**/
			$journalid=$this->md_commun->get_row('corrections_historiques',array('id'=>$corr_id));
			$savejounal = array();
			$savejounal['id'] = false;
			$savejounal['module'] = 'corrections';
			if($id==false)
				$savejounal['designation'] = 'Ajout corrections observation '.$journalid->observation_leve;
			else 
				$savejounal['designation'] = 'Modification corrections observation'.$journalid->observation_leve;
			$savejounal['datetime'] = date('Y-m-d H:i:s');
			$savejounal['customer_id'] = $id_admin;
			$this->md_commun->save('journal',$savejounal);
			/**journal**/
		
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/corrections/historiques/'.$cor_id);
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

	 
	 
	 function delete_all() {

        $corr = $this->md_commun->fetch('corrections',array('archive'=>1),'asc',10000,0);

        if ($corr) {
			foreach($corr as $cor){
			
				$this->md_commun->delete('corrections',$cor->id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } }else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/corrections/index_archive');
    }

	function supprimer($id) {

		$correction = $this->md_commun->get_row('corrections', array('id' => $id));

		if ($correction) {
			$this->md_commun->delete('corrections',$correction->id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
		} else {
			$this->session->set_flashdata('error', lang('error_categorie_not_found'));
		}
	
        redirect($this->config->item('admin_folder') . '/corrections');
    }

    function delete($id) {

		$correction = $this->md_commun->get_row('corrections', array('id' => $id));

		if ($correction) {
			// Set 'archive' field to 1 and 'date_archive' to the current system date
			$data = array(
				'archive' => 1,
				'date_archive' => date('Y-m-d H:i:s')  // Assuming date_archive is a datetime field
			);
	
			$this->md_commun->update('corrections','id',$id, $data);
	
			$this->session->set_flashdata('message', lang('message_archived_categorie'));
		} else {
			$this->session->set_flashdata('error', lang('error_categorie_not_found'));
		}
	
        redirect($this->config->item('admin_folder') . '/corrections');
    }

	function repaire($id) {

		$correction = $this->md_commun->get_row('corrections', array('id' => $id));

		if ($correction) {
			// Set 'archive' field to 1 and 'date_archive' to the current system date
			$data = array(
				'archive' => 0,
				'date_archive' => null  // Assuming date_archive is a datetime field
			);
	
			$this->md_commun->update('corrections','id',$id, $data);
	
			$this->session->set_flashdata('message', lang('message_archived_categorie'));
		} else {
			$this->session->set_flashdata('error', lang('error_categorie_not_found'));
		}
	
        redirect($this->config->item('admin_folder') . '/corrections/index_archive');
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
							$html_etage.='<select class="form-control " name="etage_idx" id="etag_bloc" onchange="fetch_appartements('.$projet_id.','.$blocs_id.',this.value)">
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
	
	function fetch_appartements($projet_id, $blocs_id, $etages_id = false)
	{
		if ($etages_id != false) {
			$html_etage = '<label class="form-label"><b>Locaux</b></label>
							<div class="form-line">
								<div class="form-group default-select">';
			$appartements = $this->md_commun->fetch('appartements', array('projet_id' => $projet_id, 'blocs_id' => $blocs_id, 'etages_id' => $etages_id), 'asc', 10000, 0);
			//print_r( $appartements);
			$html_etage .= '<select class="form-control" name="appartements_idx" onchange="addappetage(),getList()" id="app_etage">
												<option value="">Sélectionner locaux</option>';
			if ($appartements) {
				foreach ($appartements as $app) {
					$html_etage .= '<option value="' . $app->id . '">' . $app->appartements .''.$app->id . '</option>';
				}
			}
			$html_etage .= '</select>
											</div>
										</div>';
			echo $html_etage;
		}
	}

	function getList($list) {


		echo "testttttttttttttttttttttttttttttttttttt";

		//var_dump($list);exit;
	
	}
	
	  
	
	function fetch_societes($proj_id=false,$trav_id=false){
		if($proj_id!=false){
			if($trav_id!=false){
				$html_etage='<label class="form-label"><b>Entreprise</b></label>
								<div class="form-line">
									<div class="form-group default-select">';
									$societes=$this->md_commun->fetch('travaux_societe',array('travaux_id'=>$trav_id,'projet_id'=>$proj_id),'asc',10000,0);
									$html_etage.='<select class="form-control " name="societe_idx" onClick="">
													<option value="">Seclectionner Entreprise</option>';
													if($societes){foreach($societes as $societe){ $selected='';
													$societesrow=$this->md_commun->get_row('societes',array('id'=>$societe->societe_id));
													$html_etage.='<option value="'.$societesrow->id.'" '.$selected.'>'.$societesrow->societes.'</option>';
													}}
													$html_etage.='</select>
												</div>
											</div>';
				echo $html_etage;
			}		
		}
	}


// In Corrections controller (Corrections.php)
function getEtage($etage_id) {
    if ($etage_id) {
        $etage = $this->md_commun->get_row('etages', array('id' => $etage_id), 'asc', 10000, 0);

        if ($etage) {
            // Return JSON response
            echo json_encode(array('result' => $etage->etages));
        } else {
            // Return JSON response
            echo json_encode(array('error' => 'Etage not found'));
        }
    } else {
        // Return JSON response
        echo json_encode(array('error' => 'Etage ID not provided'));
    }
}

function getApp($ap_id) {
    if ($ap_id) {
        $app = $this->md_commun->get_row('appartements', array('id' => $ap_id), 'asc', 10000, 0);

        if ($app) {
            // Return JSON response
            echo json_encode(array('result' => $app->appartements));
        } else {
            // Return JSON response
            echo json_encode(array('error' => 'Appartement not found'));
        }
    } else {
        // Return JSON response
        echo json_encode(array('error' => 'Appartement ID not provided'));
    }
}

	
	function send_email($corre_id) {
		
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['corre_id'] = $corre_id;
	
		$this->form_validation->set_rules('email', 'lang:email', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('send_email_form', $data);
        } else {
			$cor_id=$this->md_commun->get_row('corrections',array('id'=>$corre_id));
			$save = array();
			$save['id'] = $corre_id;
			$save['nb_envoie'] = $cor_id->nb_envoie+1;
			$this->md_commun->save('corrections',$save);
			
			/*********** Send an email to the admin  ***************/
			  $this->load->library('email');

			  $config['mailtype'] = 'html';

			  $societess=$this->md_commun->get_row('societes',array('id'=>$corrections_id->societe_id));
			  $this->email->initialize($config);

			  $this->email->from('loumi.amir@gmail.com','La maitrise');
			  $this->email->to($societess->email);
			  $this->email->cc($this->input->post('email'));
			  $this->email->subject('MAJ check list');
			  $this->email->message(html_entity_decode('*** Corrections ****<br><b>'.$cor_id->intitile.'</b><br><p>'.$cor_id->observation.'</p>'));

			  $this->email->send();
		  
			redirect($this->config->item('admin_folder'). '/Corrections');
        }
	}
	
	function modif_date(){
		$corrections=$this->md_commun->fetch('corrections',array(),'asc',1000,0);
		if($corrections){foreach($corrections as $cor){
			$save = array();
			$save['id'] = $cor->id;
			$save['date_time'] = date('Y-m-d H:i:s');
			$this->md_commun->save('corrections',$save);
		}}
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

        } else
            return false;
    }
    function notfound() {
        $this->view('404');
    }


}
