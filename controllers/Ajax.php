<?php
class Ajax extends Front_Controller{

  public function __construct()
  {
    parent::__construct();
      $this->load->model(array('ajax_model'));
  }


  function index() {
    show_404();
  }

  function comboselect($table, $cols, $parent=false) {
	  
	$cols=explode(':',$cols);
	
	if($parent)
	$parent= explode(':',$parent);

    echo json_encode($this->ajax_model->comboselect($table, $cols, $parent));
  }

}
