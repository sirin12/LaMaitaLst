<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inbox extends Admin_Controller {

    var $admin_id = false;
    var $current_admin = false;

    function __construct() {
        parent::__construct();
        $this->auth->check_access('Admin', true);

        //load the admin language file in
        $this->lang->load('admin');
		$this->load->model('inbox_model');
        $this->current_admin = $this->session->userdata('admin');
    }

    public function index() {
        $data['page_title'] = 'Messagerie';
        $data['page_icon'] = 'icon-comments-alt';
        $data['emails'] = $this->inbox_model->get();
        $this->view('inbox', $data);
    }

    public function message($id = false) {
        if ($id) {
            $data['page_title'] = 'Messagerie';
            $data['page_icon'] = 'icon-comments-alt';
			$data['emails'] = $this->md_commun->get('inbox');
            $data['message'] = $this->md_commun->get_row_by_id('inbox', $id);
			$this->inbox_model->save(array('status'=>1, 'id'=>$id));
            $this->view('inbox_message', $data);
        } else
            redirect($this->config->item('admin_folder') .'/inbox');
    }

    function delete($id) {
        $this->md_commun->delete('inbox', $id);

        $this->session->set_flashdata('message', 'Message supprimer avec succés');
        redirect($this->config->item('admin_folder').'/inbox');
    }
	
	/*--table_order_delete--*/
	var $table = 'inbox';

	public function ajax_list()
	{
		$list = $this->inbox_model->get_datatables();
		$data = array();
		$no = 0;
		foreach ($list as $inbox) {
			
			$no++;
			$row = array();
			$row[] = '<input name="checkbox[]" class="checkbox1 ui-check" type="checkbox" id="checkbox[]" value="'.$inbox->id.'"> ';
			
			$row[] = $inbox->name; ;
			$row[] = $inbox->email;
			$row[] = $inbox->phone;
			$row[] = $inbox->subject;
			//add html for action
			
			
			$row[] = '<div class="btn-group pull-right">
                      <a class="btn btn-sm primary"  href="'.admin_url("/inbox/message/".$inbox->id).'"><i class="fa fa-eye"></i></a>
                      <a class="btn btn-sm danger" href="javascript:void(0)" title="delete" onclick="delete_person('."'".$inbox->id."'".')"><i class="fa fa-trash"></i></a>
								</div>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => 0,
						"recordsTotal" => $this->inbox_model->count_all(),
						"recordsFiltered" => $this->inbox_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function ajax_delete($id)
	{
		$this->inbox_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_delete_check()
	{
		$ids= $this->input->post('ids');
		$id_cheks = explode(',' ,$ids);
		foreach($id_cheks as $id_chek){ 
		$this->inbox_model->delete_by_id($id_chek);
		}
		echo json_encode(array("status" => TRUE));
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */