<?php

/**

 * The base controller which is used by the Front and the Admin controllers

 */
class Base_Controller extends CI_Controller {

    var $languages = array();
    var $current_lang = '';
    var $current_site= '';
    var $sites = '';

    public function __construct() {

        parent::__construct();

        //kill any references to the following methods

        $mthd = $this->router->method;

        if ($mthd == 'view' || $mthd == 'partial' || $mthd == 'set_template') {

            show_404();
        }

        //load base libraries, helpers and models
        $this->load->database();

        //load the default libraries
        $this->load->library(array( 'auth'));

        // load the settings model
        $this->load->model(array('Settings_model', 'language_model', 'site_model'));

        $this->load->helper(array('url', 'file', 'string', 'html', 'language','form_helper', 'formatting_helper'));     //load helpers



        //if SSL is enabled in config force it here.

        if (config_item('ssl_support') && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off')) {

            $CI = & get_instance();

            $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);

            redirect($CI->uri->uri_string());
        }


        $this->languages = $this->language_model->get();
        $this->sites = $this->site_model->get();

        if ($this->session->userdata('current_lang')) {
            $this->current_lang = $this->session->userdata('current_lang');
        } else {
            $default = $this->language_model->get_default();
            $this->current_lang = $default;
            $this->session->set_userdata('current_lang', $default);
        }
        //load common language
        $this->lang->load('common', $this->current_lang->flag);
        
    }

    function setlang($id) {
        $default = $this->language_model->get($id);
        $this->current_lang = $default;
        $this->session->set_userdata('current_lang', $default);

        redirect($_SERVER['HTTP_REFERER']);
    }
    
      function setsite($id) {
        $default = $this->site_model->get($id);
        $this->current_site = $default;
        $this->session->set_userdata('current_site', $default);

        redirect($_SERVER['HTTP_REFERER']);
    }
}

//end Base_Controller

//Robinetterie_Controller
class Front_Controller extends Base_Controller {

    //we collect the categories automatically with each load rather than for each function
    //this just cuts the codebase down a bit
    //load all the pages into this variable so we can call it from all the methods
    var $website_top_menu = '';
    var $website_main_menu = '';
    var $website_footer_menu = '';
    var $notification = '';
    var $user = false;
    var $widgets = array();
    var $widget ='';

    function __construct() {

        parent::__construct();

        //load in config items from the database
        $settings = $this->Settings_model->get_settings('');

        foreach ($settings as $key => $setting) {
            $this->config->set_item($key, $setting);
        }

        //load the theme package
        $this->load->add_package_path(APPPATH . 'themes/' . config_item('theme') . '/');

        //load needed models
        $this->load->model(array('Page_model', 'Settings_model'));

        //load libraries
        $this->load->library('customauth');

        $this->current_site = $this->site_model->get(1);
        $this->counter->addinfo(uri_string(), 1);
        $this->website_top_menu = $this->Page_model->get_pages(0, 2);
        $this->website_main_menu = $this->Page_model->get_pages(0, 1);
        $this->website_footer_menu = $this->Page_model->get_pages(0, 3);

       // $this->notification = array();

        //$connected= $this->customauth->get_connected();
        //$this->user= $this->user_model->get($connected['id']);
    }

    /*

      This works exactly like the regular $this->load->view()

      The difference is it automatically pulls in a header and footer.

     */

    function view($view, $vars = array(), $string = false) {

        if ($string) {
            $this->load->view($view, $vars);
        } else {

            $this->load->view('header', $vars);

            $this->load->view( $view, $vars);

            $this->load->view('footer', $vars);
        }
    }

    /*

      This function simply calls $this->load->view()

     */

    function partial($view, $vars = array(), $string = false) {

        if ($string) {

            return $this->load->view($view, $vars, true);
        } else {

            $this->load->view($view, $vars);
        }
    }

}

class Admin_Controller extends Base_Controller {

    private $template;
    //load all the pages into this variable so we can call it from all the methods
    var $pages = '';
    var $count_contacts=0;

    function __construct() {

        parent::__construct();

        $this->auth->is_logged_in(uri_string());



        //load the base language file

        $this->lang->load('admin_common', $this->current_lang->flag);


        $this->load->model(array('md_commun', 'Page_model'));

       
           /*         * *****  Set Current site   ***** */
        if ($this->session->userdata('current_site')) {
            $this->current_site = $this->session->userdata('current_site');
        } else {
            $default = $this->site_model->get(1);
            $this->current_site = $default;
            $this->session->set_userdata('current_site', $default);
        }

        $this->pages = $this->Page_model->get_pages();
        $this->count_contacts=$this->md_commun->count('inbox',array('status'=>0));
    }
    
    
    function view($view, $vars = array(), $string = false) {

        //if there is a template, use it.

        $this->load->view($this->config->item('admin_folder') . '/' . 'header', $vars);

        $this->load->view($this->config->item('admin_folder') . '/' . $view, $vars);

        $this->load->view($this->config->item('admin_folder') . '/' . 'footer', $vars);
    }

  

}
