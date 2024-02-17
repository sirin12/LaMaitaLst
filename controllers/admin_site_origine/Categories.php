<?php

class Categories extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->auth->check_access('Admin', true);
        $this->load->model('Category_model');
    }

    function index() {
        $data['page_title'] = 'Category';
        $data['categories'] = $this->Category_model->get_categories_tiered(true);
        $data['page_icon'] = 'icon-file-alt';

        $this->view('categories', $data);
    }

    /*     * ******************************************************************
      edit categorie
     * ****************************************************************** */

    function form($id = false) {

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

        //set the default values
        $data['id'] = '';
        $data['name'] = '';
		$data['description'] = '';
		$data['description1'] = '';
        $data['slug'] = '';
        $data['sequence'] = 0;
        $data['parent_id'] = 0;
        $data['seo_title'] = '';
        $data['meta'] = '';
        $data['images'] = '';
        $data['cover'] = '';
        $data['color'] = '';
        $data['type'] = '';
        $data['template'] = '';
        $data['cdisplay_in_homepage'] = 0;
		$data['cdisplay_in_category'] = 0;
        $data['page_title'] = lang('categorie_form');
        $data['page_icon'] = 'icon-file-alt';
        $data['categories'] = $this->Category_model->get_categories();
        if ($id) {

            $categorie = $this->md_commun->get_row('categories', array('id' => $id));

            if (!$categorie) {
                //page does not exist
                $this->session->set_flashdata('error', lang('error_page_not_found'));
                redirect($this->config->item('admin_folder') . '/categories');
            }


            //set values to db values
            $data['id'] = $categorie->id;
            $data['parent_id'] = $categorie->parent_id;
            $data['sequence'] = $categorie->sequence;
            $data['seo_title'] = $categorie->seo_title;
            $data['meta'] = $categorie->meta;
            $data['slug'] = $categorie->slug;
            $data['images'] = $categorie->images;
            $data['name'] = $categorie->name;
			$data['description'] = $categorie->description;
            
            $data['type'] = $categorie->type;
            $data['color'] = $categorie->color;
            $data['cdisplay_in_homepage'] = $categorie->cdisplay_in_homepage;
			$data['cdisplay_in_category'] = $categorie->cdisplay_in_category;
        }

        $this->form_validation->set_rules('slug', 'lang:slug', 'trim');
        $this->form_validation->set_rules('seo_title', 'lang:seo_title', 'trim');
        $this->form_validation->set_rules('meta', 'lang:meta', 'trim');
        $this->form_validation->set_rules('sequence', 'lang:sequence', 'trim|integer');
        $this->form_validation->set_rules('parent_id', 'lang:parent_id', 'trim|integer');

        // Validate the form
        if ($this->form_validation->run() == false) {
            $this->view('category_form', $data);
        } else {
            $this->load->helper('text');


            $user = $this->auth->get_connected();

            $name  = $description  = $seo_title = $meta = $slugs = $slug_ids =array();
            $type = $this->input->post('type');
            foreach ($this->languages as $lang) {
                $name[$lang->flag] = $this->input->post('name_' . $lang->flag);
				$description[$lang->flag] = $this->input->post('description_' . $lang->flag);
				$description1[$lang->flag] = $this->input->post('description1_' . $lang->flag);
                $seo_title[$lang->flag] = $this->input->post('seo_title_' . $lang->flag);
                $meta[$lang->flag] = $this->input->post('meta_' . $lang->flag);
                /*                 * ************************** Slug ************** */

                $slug = $this->input->post('name_' . $lang->flag)? : $this->input->post('name_' . $this->current_lang->flag);

                $slug = url_title(convert_accented_characters($slug), 'dash', TRUE);

                //validate the slug
                $this->load->model('Routes_model');
                if ($id) {
                    $slug = $this->Routes_model->validate_category_slug($slug, $id);
                    $slugs[$lang->flag] = $slug;
                    //save the slug
                    $this->Routes_model->save_category_route(array('slug' => $slug, 'route' => $this->current_site->link . '/products/' . $type . '/' . $id, 'category_id' => $id, 'language_id' => $lang->id));
                } else {
                    $slug = $this->Routes_model->validate_category_slug($slug);
                    $slugs[$lang->flag] = $slug;
                    //save the slug
                    $slug_ids[] = $this->Routes_model->save(array('slug' => $slug, 'language_id' => $lang->id));
                }
                /*                 * ********************************************************* */
            }

            $save = array();
            $save['id'] = $id;
            $save['parent_id'] = $this->input->post('parent_id');
            $save['site_id'] = $this->current_site->id;
            $save['name'] = json_encode($name);
            $save['sequence'] = $this->input->post('sequence');
            $save['description'] = json_encode($description);
            $save['description1'] = json_encode($description1);
            $save['seo_title'] = json_encode($seo_title);
            $save['meta'] = json_encode($meta);
            $save['slug'] = json_encode($slugs);
            $save['user'] = $user['id'];
            $save['type'] = $type;
            $save['color'] = $this->input->post('color');
            $save['cdisplay_in_homepage'] = $this->input->post('display_in_homepage')? : 0;
			$save['cdisplay_in_category'] = $this->input->post('cdisplay_in_category')? : 0;
			
			$imagecat = $this->upload('image');
            if ($imagecat)
                $save['images'] = $imagecat;
            //save the categorie
            $categorie_id = $this->Category_model->save($save);

			

            /*             * ***** */
            //save the slug
            if (!$id) {
                foreach ($slug_ids as $slug) {
                    $this->Routes_model->save(array('id' => $slug, 'category_id' => $categorie_id, 'route' => $this->current_site->link . '/products/' . $type . '/' . $categorie_id));
                }
            }
            /*             * **** */


            $this->session->set_flashdata('message', lang('message_saved_categorie'));

            //go back to the categorie list
            redirect($this->config->item('admin_folder') . '/categories');
        }
    }

    function uploadPicture() {
        $option = array(
            'upload_dir' => 'uploads/categories/',
            'upload_url' => base_url('uploads/categories/'),
            'deleteUrl' => admin_url('categories/remove_picture/'));

        if ($this->input->post())
            $this->load->library('UploadHandler', $option);
    }

    function remove_picture($file, $id = false) {
        echo '{"' . $file . '":true}';
        if (file_exists('uploads/categories/' . $file)) {
            unlink('uploads/categories/' . $file);
            unlink('uploads/categories/thumbnail/' . $file);
        }

        if ($id) {
            $category = $this->Category_model->get_category($id);
            $files = json_decode($category->images);
            if (($key = array_search($file, $files)) !== false) {
                unset($files[$key]);
            }
            $this->Category_model->save(array('id' => $id, 'images' => json_encode($files)));
        }
    }

    /*     * ******************************************************************
      delete categorie
     * ****************************************************************** */

    function delete($id) {

        $categorie = $this->Category_model->get_category($id);

        if ($categorie) {
            $this->load->model('Routes_model');
			
			/*----journal delete--*/
			$admin_admin = $this->auth->get_connected();
			$desc_journal = $this->md_commun->get_row('categories',array('id'=>$id));
			$this->journal->add($admin_admin['id'],'Supression Categorie', Clang($desc_journal->name));
			/*----end journal--*/
			
            $this->Routes_model->delete_category($id);
            $this->Category_model->delete($id);
            $this->session->set_flashdata('message', lang('message_deleted_categorie'));
        } else {
            $this->session->set_flashdata('error', lang('error_categorie_not_found'));
        }

        redirect($this->config->item('admin_folder') . '/categories');
    }

    function notfound() {
        $this->view('404');
    }

    function upload($file) {
        $config['upload_path'] = 'uploads/images/full/';
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
            $config['width'] = 720;
            $config['height'] = 500;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            //small image
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/medium/' . $image['file_name'];
            $config['new_image'] = 'uploads/images/small/' . $image['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 235;
            $config['height'] = 235;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            //cropped thumbnail
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/small/' . $image['file_name'];
            $config['new_image'] = 'uploads/images/thumbnails/' . $image['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 150;
            $config['height'] = 150;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            return $image['file_name'];
        } else
            return false;
    }

}
