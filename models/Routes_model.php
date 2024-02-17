<?php

class Routes_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // save or update a route and return the id
    function save($route) {
		$id =false;
		if(isset($route['id']))
		{
			$id =$route['id'];
			unset($route['id']);
		}
		
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('routes', $route);
            return $id;
        } else {
            $route['site_id']= $this->current_site->id;
            $this->db->insert('routes', $route);
            return $this->db->insert_id();
        }
    }

    function check_slug($slug, $id = false) {
        if ($id) {
            $this->db->where('id !=', $id);
        }
        $result =$this->db->where('site_id', $this->current_site->id)->where('slug', $slug)->get('routes')->result();

        return (bool) sizeof($result);
    }

    function validate_slug($slug, $id = false, $count = false) {
        if ($this->check_slug($slug . $count, $id)) {
            if (!$count) {
                $count = 1;
            } else {
                $count++;
            }
            return $this->validate_slug($slug, $id, $count);
        } else {
            return $slug . $count;
        }
    }
   /**************** Product Route ********************/
	function check_product_slug($slug, $product_id=false, $lang_id=false) {
		if($product_id)
		$this->db->where('product_id!=', $product_id);
		/*if($lang_id)
		$this->db->where('language_id', $lang_id);*/
        $result =$this->db->where('slug', $slug)->get('routes')->result();
		
        return (bool) sizeof($result);
    }
	function validate_product_slug($slug, $product_id=false, $lang_id=false, $count = false)
	{
		 if ($this->check_product_slug($slug . $count,$product_id, $lang_id)) {
            if (!$count) {
                $count = 1;
            } else {
                $count++;
            }
            return $this->validate_product_slug($slug, $product_id, $lang_id, $count);
        } else {
            return $slug . $count;
        }
	}
	 //  update a route
    function save_product_route($route) {
		$rt=$this->db->get_where('routes', array('product_id' => $route['product_id'], 'language_id'=> $route['language_id']))->row();
		if($rt)
		{
		$this->db->where('id', $rt->id);
		$this->db->update('routes', $route);
		}else
		$this->save($route);
		
        
    }
	 function delete_product($id) {
        $this->db->where('product_id', $id);
        $this->db->delete('routes');
    }
	
	/**************** Category Route ********************/
	
	
    function check_category_slug($slug, $id = false) {
        if ($id) {
            $this->db->where('category_id !=', $id);
        }
        $result =$this->db->where('slug', $slug)->get('routes')->result();
		
        return (bool) sizeof($result);
    }

    function validate_category_slug($slug, $id = false, $count = false) {
        if ($this->check_category_slug($slug . $count, $id)) {
            if (!$count) {
                $count = 1;
            } else {
                $count++;
            }
            return $this->validate_category_slug($slug, $id, $count);
        } else {
            return $slug . $count;
        }
    }

	 //  update a route
    function save_category_route($route) {
		
		$rt=$this->db->get_where('routes', array('category_id' => $route['category_id'], 'language_id'=> $route['language_id']))->row();
		if($rt)
		{
			$this->db->where('id', $rt->id);
			$this->db->update('routes', $route);
		}else
		$this->save($route);
    }
	 function delete_category($id) {
        $this->db->where('category_id', $id);
        $this->db->delete('routes');
    }
	
	/**************** Page Route ********************/
    function check_page_slug($slug, $id = false) {
        if ($id) {
            $this->db->where('page_id !=', $id);
        }
        $this->db->where('site_id', $this->current_site->id);
        $result =$this->db->where('slug', $slug)->get('routes')->result();
		
        return (bool) sizeof($result);
    }

    function validate_page_slug($slug, $id = false, $count = false) {
        if ($this->check_page_slug($slug . $count, $id)) {
            if (!$count) {
                $count = 1;
            } else {
                $count++;
            }
            return $this->validate_page_slug($slug, $id, $count);
        } else {
            return $slug . $count;
        }
    }

	 //  update a route
    function save_page_route($route) {
		
		$rt=$this->db->get_where('routes', array('page_id' => $route['page_id'], 'language_id'=> $route['language_id']))->row();
		if($rt)
		{
			$this->db->where('id', $rt->id);
			$this->db->update('routes', $route);
		}else
		$this->save($route);
    }
	 function delete_page($id) {
        $this->db->where('page_id', $id);
        $this->db->delete('routes');
    }
	/**************** Post Route ********************/
    function check_post_slug($slug, $id = false) {
        if ($id) {
            $this->db->where('post_id !=', $id);
        }
        $this->db->where('site_id', $this->current_site->id);
        $result =$this->db->where('slug', $slug)->get('routes')->result();
		
        return (bool) sizeof($result);
    }

    function validate_post_slug($slug, $id = false, $count = false) {
        if ($this->check_post_slug($slug . $count, $id)) {
            if (!$count) {
                $count = 1;
            } else {
                $count++;
            }
            return $this->validate_post_slug($slug, $id, $count);
        } else {
            return $slug . $count;
        }
    }

	 //  update a route
    function save_post_route($route) {
		
		$rt=$this->db->get_where('routes', array('post_id' => $route['post_id'], 'language_id'=> $route['language_id']))->row();
		if($rt)
		{
			$this->db->where('id', $rt->id);
			$this->db->update('routes', $route);
		}else
		$this->save($route);
    }
	 function delete_post($id) {
        $this->db->where('post_id', $id);
        $this->db->delete('routes');
    }
	/**********************************************************/
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('routes');
    }
	
	
	
}
