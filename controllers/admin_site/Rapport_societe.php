<?php
class Rapport_societe extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
		$this->load->model(array());
    }

	function index() {
        $data['page_title'] = 'Km Exp';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
        $data['page_icon'] = 'icon-file-alt';
		if($current_admin['super_admin']==1){
			$data['rapports']=$this->md_commun->fetch('rapport_projet_societe',array('etat'=>1),'asc',10000,0);
		}else{
			$data['rapports']=$this->md_commun->fetch('rapport_projet_societe',array('user_id'=>$id_admin,'etat'=>1),'asc',10000,0);
		}
        $this->view('all_rapport_societes', $data);
    }

	
	    /*     * ******************************************************************
      edit form_societes
     * ****************************************************************** */
	function form($projet_id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id']='';
		$data['projet_id']=$projet_id;
		$this->form_validation->set_rules('intitle', 'lang:intitle', 'trim');
		// Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('correction_rapport_form', $data);
        } else {
			$listJson = $this->input->post('list');
			// Assuming $yourArray is the array you posted
$jsonString = $listJson[0];
$decodedArray = json_decode($jsonString, true);

if (is_array($decodedArray)) {
    foreach ($decodedArray as $item) {
		$appartement_id = $item['app'];
        $etage_id = $item['etage'];

		$save = array();
			$save['id'] = false;
			$save['projet_id'] = $this->input->post('projet_id');
			if($this->input->post('bloc_idx')){
				$save['bloc_id'] = $this->input->post('bloc_idx');
			}else{
				$save['bloc_id'] = 0;
			}



			if($this->input->post('etage_idx')){
				$save['etage_id'] = $etage_id;
			}else{
				$save['etage_id'] = 0;
			}
			if($this->input->post('appartements_idx')){
				$save['appartements_id'] = $appartement_id;
			}else{
				$save['appartements_id'] = 0;
			}
	
			if($this->input->post('societe_idx')){
				$save['societe_id'] = json_encode($this->input->post('societe_idx'));
			}else{
				$save['societe_id'] = 0;
			}
			$save['sujet'] = $this->input->post('sujet');
			$save['content'] = $this->input->post('content');
			$save['date'] =$save['date_time'] = date('Y-m-d H:i:s');
			
			$save['user_id'] = $id_admin;
			
			$corr_id = $this->md_commun->save('rapport_projet_societe',$save);
			if($this->input->post('societe_idx')){foreach($this->input->post('societe_idx') as $trav){
				$saves = array();
				$saves['id'] = false;
				$saves['rapport_id'] = $corr_id;
				$saves['societe_id'] = $trav;
				$this->md_commun->save('rapport_projet_societes',$saves);
			}}	


       // print_r($corr_id);
       
    }
} 


			
			$this->session->set_flashdata('message', lang('message_saved_categorie'));
			redirect($this->config->item('admin_folder') . '/rapport_societe');


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
			$html_etage .= '<select class="form-control select2" multiple="" data-placeholder="Select" name="appartements_idx">
												<option value="">Sélectionner locaux</option>';
			if ($appartements) {
				foreach ($appartements as $app) {
					$html_etage .= '<option value="' . $app->id . '">' . $app->appartements .'-'.$app->id . '</option>';
				}
			}
			$html_etage .= '</select>
											</div>
										</div>';
			echo $html_etage;
		}
	}
	
	
	function fetch_blocs($projet_id=false){
		redirect(admin_urk('Rapport_societe/form/'.$projet_id));
	}
	/*function fetch_blocs($projet_id=false){
		if($projet_id!=false){
		$html_bloc='<label class="form-label"><b>Entreprise</b></label>
							<div class="form-line">
							<div class="form-group default-select select2Style">
                                <select class="form-control select2" multiple="" data-placeholder="Select" name="societe_idx[]">';
								$soscs=$this->md_commun->fetch('travaux_societe',array('projet_id'=>$projet_id),'asc',10000,0);
									if($soscs){foreach($soscs as $sox){
										$sos_id=$this->md_commun->get_row('societes',array('id'=>$sox->societe_id),'asc',10000,0);
										if($sos_id){
										$selected='';
										$html_bloc.='<option value="'.$sox->societe_id.'" '.$selected.'>'.$sos_id->societes.'</option>';
										}
									}}
								$html_bloc.='</select>
                            </div></div>
                        ';
		$html_bloc.='<label class="form-label"><b>Bloc</b></label>
                        <div class="form-line">
                            <div class="form-group default-select">';
							$blocs=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id),'asc',10000,0);
							$html_bloc.='<select class="form-control " name="bloc_idx" onClick="fetch_etages('.$projet_id.',this.value)">
											<option value="">Seclectionner bloc</option>';
											if($blocs){foreach($blocs as $bloc){ $selected='';
											$html_bloc.='<option value="'.$bloc->id.'" '.$selected.'>'.$bloc->blocs.'</option>';
											}}
											$html_bloc.='</select>
										</div>
                                    </div>';

		echo $html_bloc;		
		}
	}*/
	
	
	/**/
	function send_email($id=false) {
		
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
		
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id'] = $id;
		$cor_id=$this->md_commun->get_row('rapport_projet_societe',array('id'=>$id));
		if($cor_id->nb_envoie==0){
			$this->form_validation->set_rules('email', 'lang:email', 'trim');
			// Validate the form
			if ($this->form_validation->run() == false) {
				$this->view('send_rapportsosiete_form', $data);
			} else {
				$cor_id=$this->md_commun->get_row('rapport_projet_societe',array('id'=>$id));
				$sujet=$cor_id->sujet;
				$projet_id=$cor_id->projet_id;
				$contentt=$cor_id->content;
				$save = array();
				$save['id'] = $cor_id->id;
				$save['date'] = date('Y-m-d');
				$save['date_time'] = date('Y-m-d H:i:s');
				$save['user_id'] = $id_admin;
				$save['email'] =$emails= $this->input->post('email');
				$save['nb_envoie'] = 1;
				$file = $this->upload('file');
				if ($file)
					$save['file'] = $file;
				$this->md_commun->save('rapport_projet_societe',$save);

				  
				/*                 * **************** Send the email to the administrator ************* */

                $res = $this->db->where('id', 1)->get('canned_messages');
                $row = $res->row_array();
                $message = $row['content'];
				
				$projet_idd=$this->md_commun->get_row('projets',array('id'=>$projet_id));
				
                //Replace {base_url} by it's value
                $message = str_replace('{base_url}', base_url(), $message);
				$name="amir";
                //Replace {title} by it's value
                $message = str_replace('{title}', $projet_idd->projets, $message);
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
			  
				redirect($this->config->item('admin_folder'). '/Rapport_societe');
			}
		}else{
			$cor_id=$this->md_commun->get_row('rapport_projet_societe',array('id'=>$id));
			$emails=$cor_id->email;
			$sujet=$cor_id->sujet;
			$projet_id=$cor_id->projet_id;
			$contentt=$cor_id->content;
			$file=$cor_id->file;
			$save = array();
			$save['id'] = $id;
			$save['nb_envoie'] = $cor_id->nb_envoie+1;
			$this->md_commun->save('rapport_projet_societe',$save);

			  
			  /*                 * **************** Send the email to the administrator ************* */

                $res = $this->db->where('id', 1)->get('canned_messages');
                $row = $res->row_array();
                $message = $row['content'];
				
				$projet_idd=$this->md_commun->get_row('projets',array('id'=>$projet_id));
                //Replace {base_url} by it's value
                $message = str_replace('{base_url}', base_url(), $message);
				$name="amir";
                //Replace {title} by it's value
                $message = str_replace('{title}', $projet_idd->projets, $message);
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

			
			redirect($this->config->item('admin_folder'). '/Rapport_societe');
		
			
        }
	}
	function rapports_pdf($id) {
		//$this->load->library('mpdf/Mpdf');
        $data['page_title'] = 'Blocs';
		$current_admin = $this->session->userdata('admin');
		$id_admin=$current_admin['id'];
		
		$data['id']=$id;
		
		$data['rapport_societe']=$rapport_societe=$this->md_commun->get_row('rapport_projet_societe',array('id'=>$id,'etat'=>1));
		$data['projet']=$this->md_commun->get_row('projets',array('id'=>$rapport_societe->projet_id,'etat'=>1));
		//$data['sujet']=$this->md_commun->get_row('rapport_projet_societe',array('id'=>$rapport_societe->projet_id,'etat'=>1));
		$projet_id=$rapport_societe->projet_id;
		$data['societes_projet']=$this->md_commun->fetch('rapport_projet_societes',array('rapport_id'=>$id),'asc',100,0);
		$data['blocs']=$this->md_commun->fetch('blocs',array('projet_id'=>$projet_id,'etat'=>1),'asc',100,0);
		$data['projet_id'] = $projet_id;
        $data['page_icon'] = 'icon-file-alt';
		//var_dump($data['societes_projet']);exit;
	
		$this->view('rapports_societes_pdf', $data, true);
       
		//$pdf->Output('rapports_societes_pdf.pdf', 'I');
    }
	
	/*     * ******************************************************************
      delete_peojet
     * ****************************************************************** */

    function delete($id) {

        $projets_id=$this->md_commun->get_row('rapport_projet_societe',array('id'=>$id));

        if ($projets_id) {
			
			$save = array();
			$save['id'] = $id;
			$save['etat']=0;
			$this->md_commun->save('rapport_projet_societe',$save);
			
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/Rapport_societe');
    }
	function upload($file)
    {
      $config['upload_path'] = 'uploads/rapports/';
      $config['allowed_types'] = 'gif|jpg|jpeg|png|svg|pdf|PDF|docx|doc|GIF|JPG|PNG';
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
