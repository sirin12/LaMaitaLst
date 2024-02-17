<?php

class Pages extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
        $this->load->model(array('Page_model'));
    }

    function index() {
        $data['page_title'] = lang('pages');
        $data['pages'] = $this->Page_model->get_pages();
        $data['page_icon'] = 'icon-file-alt';

        $this->view('pages', $data);
    }

    /*     * ******************************************************************
      edit page
     * ****************************************************************** */

    function form($id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        //set the default values
        $data['id'] = '';
        $data['title'] = '';
        $data['subtitle'] = '';
        $data['menu_title'] = '';
        $data['slug'] = '';
        $data['sequence'] = 0;
        $data['parent_id'] = 0;
        $data['content'] = '';
        $data['seo_title'] = '';
        $data['meta'] = '';
        $data['image'] = '';
        $data['cover'] = '';
        $data['menu_id'] = '';
        $data['url'] = '';
        $data['target'] = '';
        $data['type'] = '';
        $data['new_window'] = 0;
        $data['template'] = '';
        $data['posts'] = array();
		

        if ($id) {

            $page = $this->Page_model->get_page($id);

            if (!$page) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/pages');
            }
                

            //set values to db values
            $data = (array) $page;
            $data['posts'] = $this->Page_model->get_posts($page->id, 0, 0);
            $data['menu_id'] = $page->menu;
        }

        $data['page_title'] = lang('page_form');
        $data['page_icon'] = 'icon-file-alt';
        $data['pages'] = $this->Page_model->get_pages();
        $data['menus'] = $this->md_commun->get('menu');
        $data['layouts'] = $this->md_commun->get('layouts');

        $this->form_validation->set_rules('title_' . $this->current_lang->flag, 'lang:title', 'trim');
        $this->form_validation->set_rules('subtitle_' . $this->current_lang->flag, 'lang:subtitle', 'trim');
        $this->form_validation->set_rules('menu_title_' . $this->current_lang->flag, 'lang:menu_title', 'trim|required');
        $this->form_validation->set_rules('seo_title_' . $this->current_lang->flag, 'lang:seo_title', 'trim');
        $this->form_validation->set_rules('meta_' . $this->current_lang->flag, 'lang:meta', 'trim');
        $this->form_validation->set_rules('sequence', 'lang:sequence', 'trim|integer');
        $this->form_validation->set_rules('parent_id', 'lang:parent_id', 'trim|integer');
        $this->form_validation->set_rules('content_' . $this->current_lang->flag, 'lang:content', 'trim');

        // Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('page_form', $data);
        } else {
            $this->load->helper('text');
            $this->load->model('Routes_model');

            $seo_title = $meta = $menu_title = $title = $subtitle = $content = array();

            foreach ($this->languages as $lang) {
                $menu_title[$lang->flag] = $this->input->post('menu_title_' . $lang->flag);
                $title[$lang->flag] = $this->input->post('title_' . $lang->flag);
                $subtitle[$lang->flag] = $this->input->post('subtitle_' . $lang->flag);
                $content[$lang->flag] = $this->input->post('content_' . $lang->flag);
                $seo_title[$lang->flag] = $this->input->post('seo_title_' . $lang->flag);
                $meta[$lang->flag] = $this->input->post('meta_' . $lang->flag);
                /*                 * *********************  Slug ****************** */
                $slug = $this->input->post('menu_title_' . $lang->flag)? : $this->input->post('menu_title_' . $this->current_lang->flag);
                $slug = url_title(convert_accented_characters($slug), 'dash', false);

                if ($id) {
                    $slug = $this->Routes_model->validate_page_slug($slug, $id);
                    $slugs[$lang->flag] = $slug;
                    //save the slug
                    $this->Routes_model->save_page_route(array('slug' => $slug, 'route' => $this->current_site->link . '/pages/page/' . $id, 'page_id' => $id, 'language_id' => $lang->id));
                } else {
                    $slug = $this->Routes_model->validate_page_slug($slug);
                    $slugs[$lang->flag] = $slug;
                    //save the slug
                    $slug_ids[] = $this->Routes_model->save(array('slug' => $slug, 'language_id' => $lang->id));
                }
                /*                 * *********************************************** */
            }
            $user = $this->auth->get_connected();

            $save = array();
            $save['id'] = $id;
            $save['site_id'] = $this->current_site->id;
            $save['parent_id'] = $this->input->post('parent_id');
            $save['title'] = json_encode($title);
            $save['subtitle'] = json_encode($subtitle);
            $save['menu_title'] = json_encode($menu_title);
            $save['sequence'] = $this->input->post('sequence');
            $save['content'] = json_encode($content);
            $save['seo_title'] = json_encode($seo_title);
            $save['meta'] = json_encode($meta);
            $save['slug'] = json_encode($slugs);
            
            $save['user'] = $user['id'];
            $save['template'] = $this->input->post('template');
            $save['type'] = $this->input->post('type');
            $save['target'] = $this->input->post('target');
            $save['url'] = $this->input->post('url');

            $cover = $this->upload('cover');
            $image = $this->upload('image');

            if ($cover)
                $save['cover'] = $cover;
            if ($image)
                $save['image'] = $image;

            //set the menu title to the page title if if is empty
            if ($save['menu_title'] == '') {
                $save['menu_title'] = $this->input->post('title');
            }

            //save the page
            $page_id = $this->Page_model->save($save);
             
			/*----journal--
			$admin_admin = $this->auth->get_connected();
			$desc_journal = $this->md_commun->get_row('pages',array('id'=>$page_id));
			if($id){
				$this->journal->add($admin_admin['id'],'Modification Page',  htmlentities (clang($desc_journal->title), ENT_QUOTES));
			}else{
				$this->journal->add($admin_admin['id'],'Insertion Page', htmlentities (clang($desc_journal->title), ENT_QUOTES));
			}
			/*----journal--*/ 
			 
            //save page menu 
            $this->Page_model->clear_menu($page_id);
             foreach($this->input->post('menu_id') as $menu){
                 $this->Page_model->save_menu(array('menu_id'=>$menu,'page_id'=>$page_id));
             }
            /*             * ***** */
            //save the slug
            if (!$id) {
                foreach ($slug_ids as $slug) {
                    $this->Routes_model->save(array('id' => $slug, 'page_id' => $page_id, 'route' => $this->current_site->link . '/pages/page/' . $page_id));
                }
            }
            /*             * **** */
			

            $this->session->set_flashdata('message', lang('message_saved_page'));

            //go back to the page list
            redirect($this->config->item('admin_folder') . '/pages');
        }
    }

    /*     * ******************************************************************
      edit post
     * ****************************************************************** */

    function post_form($page = false, $id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        //set the default values
        $data['id'] = $id;
        $data['page_id'] = $page;
        $data['title'] = '';
        $data['subtitle'] = '';
        $data['slug'] = '';
        $data['sequence'] = 0;
        $data['content'] = '';
        $data['seo_title'] = '';
        $data['meta'] = '';
        $data['image'] = '';
        $data['tags'] = '';
        $data['cover'] = '';
        $data['source'] = '';
		$data['link'] = '';
        $data['type'] = '';
		$data['annee'] = '';
        $data['localisation'] = '';
		$data['architect'] = '';
        $data['client'] = '';
        $data['created_at']=date('Y-m-d');
        $post = false;
        if ($id) {

            $post = $this->Page_model->get_post($id);

            if (!$post) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/pages/form/' . $page);
            }


            //set values to db values
            $data['page_id'] = $post->page_id;
            $data['title'] = $post->title;
            $data['subtitle'] = $post->subtitle;
            $data['content'] = $post->content;
            $data['seo_title'] = $post->seo_title;
            $data['meta'] = $post->meta;
            $data['slug'] = $post->slug;
            $data['sequence'] = $post->sequence;
            $data['cover'] = $post->cover;
            $data['image'] = $post->image;
            $data['source'] = $post->source;
			$data['link'] = $post->link;
            $data['type'] = $post->type;
			$data['annee'] = $post->annee;
			$data['localisation'] = $post->localisation;
			$data['architect'] = $post->architect;
			$data['client'] = $post->client;
            $data['created_at']=$post->created_at;
        }

        $this->form_validation->set_rules('title_' . $this->current_lang->flag, 'lang:title', 'trim|required');
        $this->form_validation->set_rules('slug', 'lang:slug', 'trim');
        $this->form_validation->set_rules('seo_title', 'lang:seo_title', 'trim');
        $this->form_validation->set_rules('meta', 'lang:meta', 'trim');
        $this->form_validation->set_rules('content_' . $this->current_lang->flag, 'lang:content', 'trim');

        // Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('post_form', $data);
        } else {

            $this->load->helper('text');
            $this->load->model('Routes_model');
            $title =$localisation =$architect =$client = $content = $slugs = $slug_ids = array();
            foreach ($this->languages as $lang) {
                $title[$lang->flag] = $this->input->post('title_' . $lang->flag);
                $subtitle[$lang->flag] = $this->input->post('subtitle_' . $lang->flag);
                $content[$lang->flag] = $this->input->post('content_' . $lang->flag);
                $seo_title[$lang->flag] = $this->input->post('seo_title_' . $lang->flag);
                $meta[$lang->flag] = $this->input->post('meta_' . $lang->flag);
				$client[$lang->flag] = $this->input->post('client_' . $lang->flag);
				$architect[$lang->flag] = $this->input->post('architect_' . $lang->flag);
				$localisation[$lang->flag] = $this->input->post('localisation_' . $lang->flag);

                /*                 * *********************  Slug ****************** */

                $slug = $this->input->post('title_' . $lang->flag)? : $this->input->post('title_' . $this->current_lang->flag);
                $slug = url_title(convert_accented_characters($slug), 'dash', false);

                if ($id) {
                    $slug = $this->Routes_model->validate_post_slug($slug, $id);
                    $slugs[$lang->flag] = $slug;
                    //save the slug
                    $this->Routes_model->save_post_route(array('slug' => $slug, 'route' => $this->current_site->link . '/pages/post/' . $id, 'post_id' => $id, 'language_id' => $lang->id));
                } else {
                    $slug = $this->Routes_model->validate_post_slug($slug);
                    $slugs[$lang->flag] = $slug;
                    //save the slug
                    $slug_ids[] = $this->Routes_model->save(array('slug' => $slug, 'language_id' => $lang->id));
                }


                /*                 * *********************************************** */
            }

            $user = $this->auth->get_connected();
            $save = array();
            $save['id'] = $id;
            $save['page_id'] = $page;
            $save['site_id'] = $this->current_site->id;
            $save['title'] = $name_cat=json_encode($title);
            $save['subtitle'] = json_encode($subtitle);
            $save['content'] = json_encode($content);
            $save['seo_title'] = json_encode($seo_title);
            $save['meta'] = json_encode($meta);
            $save['source'] = $this->input->post('source');
			$save['link'] = $this->input->post('link');
            $save['type'] = $this->input->post('type');
            $save['sequence'] = $this->input->post('sequence');
            $save['created_at'] = DateToMysqlFormat($this->input->post('date'));
            $save['slug'] = json_encode($slugs);
            $save['user_id'] = $user['id'];
			$save['annee'] = $this->input->post('annee');
			$save['localisation'] = json_encode($localisation);
            $save['architect'] = json_encode($architect);
            $save['client'] = json_encode($client);
			
            $cover = $this->upload('cover');
            $image = $this->upload('image');

            if ($cover)
                $save['cover'] = $cover;
            if ($image)
                $save['image'] = $image;

            //save the page
            $post_id = $this->Page_model->save_post($save);
			
			
			
            /*             * ***** */
            //save the slug
            if (!$id) {
                foreach ($slug_ids as $slug) {
                    $this->Routes_model->save(array('id' => $slug, 'post_id' => $post_id, 'route' => $this->current_site->link . '/pages/post/' . $post_id));
                }
            }
            /*             * **** */

            $this->session->set_flashdata('message', lang('message_saved_page'));

            //go back to the page list
            redirect($this->config->item('admin_folder') . '/pages/form/' . $page);
        }
    }
	
	
	function post_images($page, $projet_id) {
		$data['page']=$page;
		$data['projet_id']=$projet_id;
		$post = $this->Page_model->get_post($projet_id);
        $data['page_title'] = lang('pages').' / <a href="'.admin_url('pages/post_form/'.$page.'/'.$projet_id).'">'.clang($post->title).'</a>';
        $data['images'] = $this->Page_model->get_images($projet_id);
        $data['page_icon'] = 'icon-file-alt';

        $this->view('post_images', $data);
    }
	
	function post_image($page, $projet_id, $id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        //set the default values
		$data['id'] =$id;
        $data['projet_id'] = $projet_id;
        $data['page'] = $page;
        $data['image'] = '';
		$data['titre']='';
        if ($id) {
            $post = $this->Page_model->get_image($id);
			
            if (!$post) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/pages/post_images/' . $page.'/'.$projet_id);
            }
			
        }

        $this->form_validation->set_rules('titre', 'titre', 'trim|required');

        // Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('post_image', $data);
        } else {

            $save = array();
            $save['id'] = $id;
			$save['projet_id'] = $projet_id;
			$save['titre']=$this->input->post('titre');
			
            $image = $this->upload('image');
            if ($image)
                $save['image'] = $image;

            //save the page
            $post_id = $this->Page_model->save_post_image($save);
			
            $this->session->set_flashdata('message', lang('message_saved_page'));

            //go back to the page list
            redirect($this->config->item('admin_folder') . '/pages/post_images/' . $page.'/'.$projet_id);
        }
    }

    
    /*     * ******************************************************************
      delete page
     * ****************************************************************** */

    function delete($id) {

        $page = $this->Page_model->get_page($id);

        if ($page) {
            $this->load->model('Routes_model');
			
			/*----journal delete--*/
			$admin_admin = $this->auth->get_connected();
			$desc_journal = $this->md_commun->get_row('pages',array('id'=>$id));
			$this->journal->add($admin_admin['id'],'Supression Page', Clang($desc_journal->title));
			/*----end journal--*/
			
            $this->Routes_model->delete_page($id);
            $this->Page_model->delete_page($id);
            $this->session->set_flashdata('message', lang('message_deleted_page'));
        } else {
            $this->session->set_flashdata('error', lang('error_page_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/pages');
    }

    /*     * ******************************************************************
      delete page
     * ****************************************************************** */

    function delete_post($id) {

        $post = $this->Page_model->get_post($id);

        if ($post) {
            $this->load->model('Routes_model');
			/*----journal delete--*/
			$admin_admin = $this->auth->get_connected();
			$desc_journal = $this->md_commun->get_row('articles',array('id'=>$id));
			$this->journal->add($admin_admin['id'],'Supression articles', Clang($desc_journal->title));
			/*----end journal--*/
			
            $this->Routes_model->delete_post($id);
            $this->Page_model->delete_post($id);
            $this->session->set_flashdata('message', lang('message_deleted_page'));
        } else {
            $this->session->set_flashdata('error', lang('error_page_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/pages/form/' . $post->page_id);
    }

    function notfound() {
        $this->view('404');
    }

    function upload($file) {
        $config['upload_path'] = 'uploads/images/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|svg|bmp|BMP';
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
			$config['height'] = 600;
            $config['width'] = 400;
            
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            return $image['file_name'];
        } else
            return false;
    }

}
