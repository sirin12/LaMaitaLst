<?php

Class Page_model extends CI_Model {
    /*     * ******************************************************************
      Page functions
     * ****************************************************************** */

    function get_pages($parent = 0, $menu = false, $current_site=true) {
        $this->db->select('pages.*');
        
        if($current_site)
        $this->db->where('site_id',1);

        $this->db->where('parent_id', $parent);

        if ($menu)
        {
            $this->db->join('page_menu','page_menu.page_id=pages.id');
            $this->db->where('page_menu.menu_id', $menu);
        }
        $this->db->where('active', 1);
        $this->db->order_by('sequence', 'asc');
        $result = $this->db->get('pages')->result();

        $return = array();
        foreach ($result as $page) {
            
            $page->menu =array();
            $menus =$this->db->select('*')->from('page_menu')->join('menu', 'menu.id=page_menu.menu_id', 'left')->where('page_id',$page->id)->get()->result();
            foreach($menus as $m)
            {
                $page->menu[]=$m->name;
            }
            
            $return[$page->id] = $page;
            $return[$page->id]->children = $this->get_pages($page->id);
            
        }

        return $return;
    }
	
	    function get_pageslimit($parent=0, $limit= 1, $offset = 0, $menu = false, $current_site=true) {
    
        $this->db->select('pages.*');
        
        if($current_site)
        $this->db->where('site_id',1);

        $this->db->where('parent_id', $parent);

        if ($menu)
        {
            $this->db->join('page_menu','page_menu.page_id=pages.id');
            $this->db->where('page_menu.menu_id', $menu);
        }
        $this->db->where('active', 1);
		$this->db->limit($limit, $offset);
        $this->db->order_by('sequence', 'asc');
        $result = $this->db->get('pages')->result();

        $return = array();
        foreach ($result as $page) {
            
            $page->menu =array();
            $menus =$this->db->select('*')->from('page_menu')->join('menu', 'menu.id=page_menu.menu_id', 'left')->where('page_id',$page->id)->get()->result();
            foreach($menus as $m)
            {
                $page->menu[]=$m->name;
            }
            
            $return[$page->id] = $page;
            $return[$page->id]->children = $this->get_pages($page->id);
            
        }

        return $return;
    }
	
    function gethomepage() {
        $this->db->where('site_id', $this->current_site->id);
        $this->db->where('homepage', 1);
        $result = $this->db->get('pages')->row();

        return $result;
    }

    function get_pages_childs($parent = 0, $limit = false, $offset = false, $by = false, $sort = false) {
        $this->db->select('*')->from('pages');

        $this->db->where('parent_id', $parent);

        $this->db->where('active', 1);

        if ($by)
            $this->db->order_by($by, $sort);


        if ($limit)
            $result = $this->db->limit($limit)->offset($offset)->get()->result();
        else
            $result = $this->db->get()->result();

        return $result;
    }

    function get_Admin_pages($parent = 0, $menu = false) {
        $this->db->where('site_id', $this->current_site->id);
        $this->db->order_by('sequence', 'ASC');
        $this->db->where('parent_id', $parent);

        if ($menu)
            $this->db->where('menu_id', $menu);

        //$this->db->where('active', 1);

        $this->db->order_by('sequence', 'asc');
        $result = $this->db->get('pages')->result();

        $return = array();
        foreach ($result as $page) {
            $return[$page->id] = $page;
            $return[$page->id]->children = $this->get_pages($page->id);
        }

        return $return;
    }
    
    function get_menu($id = false) {
        if ($id) {
            $this->db->where('id', $id);
            $result = $this->db->get('menu')->row();
            return $result;
        } else {
            $this->db->order_by('id', 'asc');
            $result = $this->db->get('menu')->result();
            return $result;
        }
    }
    function clear_menu($page_id)
    {
         $this->db->delete('page_menu', array('page_id' => $page_id));
    }
    function save_menu($save)
    {
        $this->db->insert('page_menu', $save);
    }

    function get_page($id) {
        $this->db->where('id', $id);
        $page = $this->db->get('pages')->row();
        if($page){
			$page->menu =array();
			$menus =$this->db->select('*')->from('page_menu')->join('menu', 'menu.id=page_menu.menu_id', 'left')->where('page_id',$page->id)->get()->result();
			foreach($menus as $m)
			{
				$page->menu[]=$m->id;
			}
	
			return $page;
		}
    }

    function get_posts($page, $limit = 6, $offset = 0, $cond=false) {
        $this->db->select('*, articles.id as post_id, articles.link as link_article');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->join('sites', 'sites.id= articles.site_id', 'left');
        if(is_array($page))
        $this->db->where_in('page_id', $page);
        else
        $this->db->where('page_id', $page);
        if($cond)
        $this->db->where($cond);
        $this->db->order_by('articles.created_at', 'desc');
        $this->db->order_by('articles.sequence', 'asc');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }
	function get_postsseq($sequence,$page, $limit = 6, $offset = 0, $cond=false) {
        $this->db->select('*, articles.id as post_id, articles.link as link_article');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->join('sites', 'sites.id= articles.site_id', 'left');
        if(is_array($page))
        $this->db->where_in('page_id', $page);
        else
        $this->db->where('page_id', $page);
        if($cond)
        $this->db->where($cond);
        $this->db->order_by('articles.id', $sequence);
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }
	
	function get_pagessseq($sequence,$page, $limit = 6, $offset = 0, $cond=false) {
        $this->db->select('*, pages.id as post_id, pages.url as url_page');
        $this->db->from('pages');
        $this->db->join('admin', 'admin.id= pages.user', 'left');
        $this->db->join('sites', 'sites.id= pages.site_id', 'left');
        if(is_array($page))
        $this->db->where_in('parent_id', $page);
        else
        $this->db->where('parent_id', $page);
        if($cond)
        $this->db->where($cond);
        $this->db->order_by('pages.id', $sequence);
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }
     function get_current_site_posts($page, $limit = false, $offset = 0, $cond=false) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->join('sites', 'sites.id= articles.site_id', 'left');
        if(is_array($page))
        $this->db->where_in('page_id', $page);
        else
        $this->db->where('page_id', $page);
        if($cond)
        $this->db->where($cond);

        $this->db->order_by('articles.created_at', 'desc');
        $this->db->order_by('articles.sequence', 'asc');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }
	 function related_posts($page, $cond=false, $limit = false, $offset = 0 ) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->join('sites', 'sites.id= articles.site_id', 'left');
        if(is_array($page))
        $this->db->where_in('page_id', $page);
        else
        $this->db->where('page_id', $page);
        if($cond)
        $this->db->where_not_in('articles.id', $cond);

        $this->db->order_by('articles.created_at', 'desc');
        $this->db->order_by('articles.sequence', 'asc');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }

    function get_first_post($page) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->where('page_id', $page);
        $this->db->order_by('id', 'asc');
        $this->db->limit(1);
        $result = $this->db->get()->row();
        return $result;
    }

    function search_posts($page, $keyword = false, $limit = 3, $offset = 0) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        if ($keyword) {
            $this->db->like('title', $keyword);
            $this->db->or_like('content', $keyword);
        }
        $this->db->where('page_id', $page);
        $this->db->order_by('articles.sequence', 'asc');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }

    function get_related_posts($page, $post, $limit = 3, $offset = 0) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->where('page_id', $page);
        $this->db->where_not_in('articles.id', $post);
        $this->db->order_by('articles.sequence', 'asc');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }

    function get_recent_posts($page, $limit = 3, $offset = 0) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->where('page_id', $page);
        $this->db->order_by('articles.id', 'desc');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }

    function get_post($id) {
        $this->db->select('articles .*, admin.firstname, admin.lastname');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->where('articles.id', $id);
        return $this->db->get()->row();
    }

    function get_last_post($page) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->where('page_id', $page);
        $this->db->order_by('articles.sequence', 'Desc');
        $this->db->limit(1);
        $result = $this->db->get()->row();
        return $result;
    }

    function count_pages($parent = 0) {
        $this->db->select('*');
        $this->db->from('pages');
        $this->db->where('parent_id', $parent);
        $this->db->where('active', 1);

        return $this->db->count_all_results();
    }

    function get_slug($id) {
        $page = $this->get_page($id);
        if ($page) {
            return $page->slug;
        }
    }

 

    function get_posts_by_tag($page, $tag, $limit = 4, $offset = 0) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->where('page_id', $page);
        $this->db->like('tags', $tag);
        $this->db->order_by('articles.id', 'desc');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }

    function get_posts_by_date($page, $month, $year, $limit = 4, $offset = 0) {
        $this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        $this->db->join('admin', 'admin.id= articles.user_id', 'left');
        $this->db->where('page_id', $page);
        $this->db->where('month(created_at)', $month);
        $this->db->where('year(created_at)', $year);
        $this->db->order_by('articles.id', 'desc');
        $this->db->limit($limit, $offset);
        $result = $this->db->get()->result();
        return $result;
    }

    function get_posts_tags() {
        $this->db->select('*');
        $this->db->from('tags');
        $result = $this->db->get()->result();
        return $result;
    }

    function get_post_archive() {
        $this->db->select('*');
        $this->db->from('articles');
        $this->db->group_by('Month(created_at)');
        $this->db->limit(5);
        $result = $this->db->get()->result();
        return $result;
    }

    function save($data) {

        $id = $data['id'];
        unset($data['id']);
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('pages', $data);
            return $id;
        } else {
            $this->db->insert('pages', $data);
            return $this->db->insert_id();
        }
    }

    function save_post($data) {
        $id = $data['id'];
        unset($data['id']);
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('articles', $data);
            return $id;
        } else {
            $this->db->insert('articles', $data);
            return $this->db->insert_id();
        }
    }
	
	function save_post_image($data) {
        $id = $data['id'];
        unset($data['id']);
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('images', $data);
            return $id;
        } else {
            $this->db->insert('images', $data);
            return $this->db->insert_id();
        }
    }

    function delete_page($id) {
        //delete the page
        $this->db->where('id', $id);
        $this->db->delete('pages');
    }

    function delete_post($id) {
        //delete the post
        $this->db->where('id', $id);
        $this->db->delete('articles');
    }

    function get_page_img($id) {
        $result = $this->db->get_where('articles_img', array('article' => $id))->result();
        if (!$result) {
            return false;
        }

        return $result;
    }

    function get_page_by_slug($slug) {
        $this->db->where('slug', $slug);
        $result = $this->db->get('pages')->row();

        return $result;
    }

    function increment($table, $field, $id) {
        $this->db->set('' . $field . '', '' . $field . ' +1', false);
        $this->db->where('id', (int) $id);
        $this->db->update($table);
    }

    function search($cond,$term, $limit = false, $offset = false, $by = false, $sort = false) {
        $results = array();

		$this->db->select('*, articles.id as post_id');
        $this->db->from('articles');
        //$this->db->join('pages', 'pages.id= articles.page_id', 'left');
        $this->db->where('(articles.content LIKE "%' .$term. '%"OR articles.content LIKE "%'.$term.'%")');
		if(is_array($cond))
        $this->db->where_in('page_id', $cond);
		
        if ($by && $sort) {
            $this->db->order_by($by, $sort);
        }
		$results= $this->db->get()->result();
		$results['pages']=$results;
        return $results;
    }
	
	function search_copie($term, $limit = false, $offset = false, $by = false, $sort = false) {
        $results = array();

        $this->db->select('*');
        $this->db->where('(title LIKE "%' . $term . '%" OR content LIKE "%' . $term . '%")');
		$this->db->where('page_id', '6');
		
        if ($by && $sort) {
            $this->db->order_by($by, $sort);
        }
        

		
		//$this->db->where('site_id', $this->current_site->id);
        $results['articles'] = $this->db->get('articles', $limit, $offset)->result();

        $this->db->select('*');
        $this->db->where('(title LIKE "%' . $term . '%" OR content LIKE "%' . $term . '%"  OR subtitle LIKE "%' . $term . '%")');

        if ($by && $sort) {
            $this->db->order_by($by, $sort);
        }
        $this->db->where('site_id', $this->current_site->id);
        $results['pages'] = $this->db->get('pages', $limit, $offset)->result();

        return $results;
    }
	
	function searchsite($term, $limit = false, $offset = false, $by = false, $sort = false) {
        $results = array();

        $this->db->select('*');
        $this->db->where('(title LIKE "%' . $term . '%" OR content LIKE "%' . $term . '%")');
		$this->db->where('page_id', '6');
		
        if ($by && $sort) {
            $this->db->order_by($by, $sort);
        }
        

		
		//$this->db->where('site_id', $this->current_site->id);
        $results['articles'] = $this->db->get('articles', $limit, $offset)->result();

        $this->db->select('*');
        $this->db->where('(title LIKE "%' . $term . '%" OR content LIKE "%' . $term . '%"  OR subtitle LIKE "%' . $term . '%")');

        if ($by && $sort) {
            $this->db->order_by($by, $sort);
        }
        $this->db->where('site_id', $this->current_site->id);
        $results['pages'] = $this->db->get('pages', $limit, $offset)->result();

        return $results;
    }

    function get_footer_menu() {
        $this->load->model('site_model');
        $sites = $this->site_model->get();

        foreach ($sites as $site) {
            $this->db->select('pages.*');
             $this->db->join('page_menu','page_menu.page_id=pages.id');
            $this->db->where('page_menu.menu_id', 3);
            $this->db->where('pages.active', 1);
            $this->db->where('pages.site_id', $site->id);
            $this->db->order_by('pages.sequence', 'asc');
            $site->links = $this->db->get('pages')->result();
        }
        return $sites;
    }
	
	function rest_widget($product) {
        $this->db->where('page_id', $product);
        $this->db->delete('posts_widget');
    }
	function save_widget($data) {
        $this->db->insert('posts_widget', $data);
    }
	
	function get_image($id) {
		$this->db->select('*');
        $this->db->from('images');
		$this->db->where('id',$id);
        $result = $this->db->get()->result();
        return $result;
    }
	function get_images($projet_id) {
		$this->db->select('*');
        $this->db->from('images');
		$this->db->where('projet_id',$projet_id);
        $result = $this->db->get()->result();
        return $result;
    }

}
