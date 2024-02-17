<?php

class Pages extends Front_Controller {


 	function __construct() {
        parent::__construct();
        $this->load->model(array('page_model'));
	}
	function index() {
        $data = array();
        $page = $this->page_model->gethomepage();
		$data['sliders'] = $this->md_commun->fetch('sliders',array(),'asc',10,0);
		$data['pages_activites'] = $this->md_commun->fetch_in('pages',array(),'asc',10000,0);
		
		$data['get_presentation']=$this->page_model->get_page(2);
        $data['projets']=$this->page_model->get_page(3);
		$data['projets_posts']=$this->page_model->get_posts(3,20);
        $data['membre']=$this->page_model->get_page(10);
		$data['membres_posts']=$this->page_model->get_posts(10,20);
        $data['all_acts'] = $this->page_model->get_posts(16, 10, 0);
        $data['galleries']=$this->page_model->get_page(9);
        $data['all_references'] = $this->page_model->get_posts(4, 3, 0);
		$data['references_page']=$this->page_model->get_page(5);
		$data['references']=$this->page_model->get_posts(5,20);
		$data['actualite_page']=$this->page_model->get_page(8);
		$data['actualites']=$this->page_model->get_posts(8,20);
		$data['page']=$page;
        $this->view('homepage', $data);
    }
	
	function page($id) {
        $page = $this->page_model->get_page($id);
		$data['references_page']=$this->page_model->get_page(5);
		$data['references']=$this->page_model->get_posts(5,20);
		$data['actualites']=$this->page_model->get_posts(8,2);
		$data['cover']=$page->cover;
		/*---projet_realisation---*/
		$data['prjets3'] = $this->page_model->get_posts(19, 3, 0);
        if ($page) {
            $data['post'] = $page;
            $data['meta'] = clang($page->meta);
            $data['seo_title'] = clang($page->seo_title);
            /*if(preg_match_all('/actualites/i', $page->slug,$result))
            $posts = $this->page_model->get_current_site_posts(array(21), 6, 0);
            else*/
            $posts = $this->page_model->get_posts($id, 100, 0);
			
            $page_data['page'] = $page;
          
                if (sizeof($posts) > 0) {
                    $data['posts'] = $posts;
					if(preg_match_all('/actualites/i', $page->slug,$result))
                    $page_data['content'] = $this->partial('posts_actualites', $data, true);
                    /*elseif(preg_match_all('/References/i', $page->slug,$result))
                    $page_data['content'] = $this->partial('posts_references', $data, true);*/
                    elseif(preg_match_all('/Partenaires/i', $page->slug,$result))
                    $page_data['content'] = $this->partial('posts_partenaires', $data, true);
                    else
                    $page_data['content'] = $this->partial('posts', $data, true);
                } else {
                    $page_data['content'] = $this->partial('page', $data, true);
                }

            // layout data
            $page_data['title'] = $page->title;

            // Load the right template/ layout
            switch ($page->template) {
                case 'Default' : $this->view('layout', $page_data);
                    break;
				case 'Presentation' : $this->about($id);
                    break;
				
                case 'Contact' : $this->contact($id);
                    break;
                default : $this->view('layout', $page_data);
                    break;
            }
        } else
            redirect('');
    }

    function post($id) {
        $this->load->helper('cookie');
        $this->load->model('comment_model');
        $this->page_model->increment('articles', 'view', $id);
		
        $data['post'] = $post = $this->page_model->get_post($id);
        if ($post) {
            $data['page'] = $page = $this->page_model->get_page($data['post']->page_id);
			if(preg_match_all('/actualites/i', $page->slug,$result)){
			     $page_data['content'] = $this->partial('post', $data, true);
		    } else {
                $page_data['content'] = $this->partial('post', $data, true);
            }

            // Load the right template/ layout
            switch ($page->template) {
				case 'FAQ' : $this->faq($id);
                    break;
                default :$page_data['content'] = $this->view('post', $data);
                    break;
				
            }
        }
    }

	
	/*     * ****************** contact ************************* */

    function contact($id) {
        $page = $this->page_model->get_page($id);
		
        if ($page) {

            $this->form_validation->set_rules('name', 'lang:name', 'trim|required');

            // Validate the form
            if ($this->form_validation->run() ) {
                $xss_clean = $this->security->xss_clean($this->input->post());
                $save = array(
                    'id' => false,
                    'name' => $xss_clean['name'],
                    'email' => $xss_clean['email'],
                    'phone' => $xss_clean['phone'],
                    'message' => $this->input->post('message'),
                    'site_id' => $this->current_site->id
                );

                $this->load->model('inbox_model');
                $this->inbox_model->save($save);							
				
				$this->session->set_flashdata('message', lang('message_saved_contact'));
				
				redirect($this->current_site->link . '/Contact');
            }


            $data['page'] = $page;
            $data['meta'] = clang($page->meta);
            $data['seo_title'] = clang($page->seo_title);

			
            $this->view('contact', $data);
        } else
            $this->notfound();
    }

	function about($id) {
		
        $page = $this->page_model->get_page($id);
		
        if ($page) {
            $data['page'] = $page;
            $data['meta'] = clang($page->meta);
            $data['seo_title'] = clang($page->seo_title);
			
			$data['page_parent']=$this->page_model->get_page($page->parent_id);
			
			$data['video_about']=$this->page_model->get_page(6);
			$data['page_about']=$this->page_model->get_page(7);
			$data['page_about_posts']=$this->page_model->get_posts(7,10);
			
            $this->view('about', $data);
        } else
            $this->notfound();
    }
	  
	  /*     * ****************** newsletter ************************* */
	function newsletter(){
	
		$this->form_validation->set_rules('email', 'email', 'required|trim|is_unique[newsletter.email]');
	
		if ($this->form_validation->run()) {
		  $this->load->model('Newsletter_model');
	
		  $save =array(
			'id'=>false,
			'email' => $this->input->post('email'),
	
		  );
		  $this->Newsletter_model->save($save);
		  echo  json_encode(array('result'=>true, 'msg_newsletter'=>'Thank you for your registration'));
		  exit;
		}
		
		echo  json_encode(array('result'=>false, 'msg_newsletter' =>'You Are already registered' ));
		
	
	  }


	  function notfound() {
		$this->partial('404');
	  }
	  function under_const() {
		$this->partial('under');
	  }
	  function notfoundlang() {
        $this->partial('lang');
    }
	  function restricted() {
		$this->partial('restricted');
	  }
	  
	  function setlang($id) {
        $default = $this->language_model->get($id);
        $this->current_lang = $default;
        $this->session->set_userdata('current_lang', $default);

        redirect($_SERVER['HTTP_REFERER']);
    }
  


}
