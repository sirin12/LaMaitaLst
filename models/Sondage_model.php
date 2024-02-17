<?php

Class Sondage_model extends CI_Model {

    function get_sondages() {
                $this->db->select('*');
        
        
        //this will alphabetize them if there is no sequence
        $this->db->order_by('id', 'ASC');
        $result = $this->db->get('sondages');
        return $result->result();
   
    }

    function get_sondages_tried($parent = 0) {
        $this->db->where('site_id', $this->current_site->id);
        $this->db->where('parent_id', $parent);
        $this->db->select('*');
        $this->db->order_by('sondages.sequence', 'ASC');
        $categories = $this->db->get('sondages')->result();

        foreach ($categories as $cat) {
            $cat->sub = $this->get_categories_tried($cat->id);
        }
        return $categories;
    }
    
    
    function get_sondages_tiered($admin = false) {
        if (!$admin)
            $this->db->where('enabled', 1);
        $this->db->where('site_id', $this->current_site->id);
        $this->db->order_by('sequence', 'ASC');
        $categories = $this->db->get('sondages')->result();

        $results = array();

        return $results;
    }

    function get_sondage($id) {
        return $this->db->get_where('sondages', array('id' => $id))->row();
    }
	
	function get_reponces($id) {
        return $this->db->get_where('sondage_reponce', array('sondage_id' => $id))->row();
    }
	
	function get_homepage_sondages($limit=false)
	{
		$this->db->select('*');
		$this->db->from('sondages');
		$this->db->where('site_id',$this->current_site->id);
		$this->db->where('cdisplay_in_homepage',1);
		$this->db->limit($limit);
		return $this->db->get()->result();
	}

    function get_sondage_products_admin($id) {
        $this->db->order_by('sequence', 'ASC');
        $result = $this->db->get_where('sondage_reponce', array('category_id' => $id));
        $result = $result->result();

        $contents = array();
        foreach ($result as $product) {
            $result2 = $this->db->get_where('products', array('id' => $product->product_id));
            $result2 = $result2->row();

            $contents[] = $result2;
        }

        return $contents;
    }

    function get_sondage_products($id, $limit, $offset) {
        $this->db->order_by('sequence', 'ASC');
        $result = $this->db->get_where('sondage_reponce', array('category_id' => $id), $limit, $offset);
        $result = $result->result();

        $contents = array();
        $count = 1;
        foreach ($result as $product) {
            $result2 = $this->db->get_where('products', array('id' => $product->product_id));
            $result2 = $result2->row();

            $contents[$count] = $result2;
            $count++;
        }

        return $contents;
    }


    function get_tree($cat, $tree = array()) {

        $category = $this->db->get_where('sondages', array('id' => $cat))->row();
        if ($category) {
            $tree[] = $category;
            $tree = $this->get_tree($category->parent_id, $tree);
        }

        return $tree;
    }

    function save($category) {
        if ($category['id']) {
            $this->db->where('id', $category['id']);
            $this->db->update('sondages', $category);
            return $category['id'];
        } else {
            $this->db->insert('sondages', $category);
            return $this->db->insert_id();
        }
    }
	
	function save_sondage_reponce($reponce_sondage) {
        if ($reponce_sondage['id']) {
            $this->db->where('id', $reponce_sondage['id']);
            $this->db->update('sondage_reponce', $reponce_sondage);
            return $category['id'];
        } else {
            $this->db->insert('sondage_reponce', $reponce_sondage);
            return $this->db->insert_id();
        }
    }
	
	function save_reponce($reponce_sondage) {

		if ($reponce_sondage['id']) {
            $this->db->where('id', $reponce_sondage['id']);
            $this->db->update('sondage_reponce_question', $reponce_sondage);
            return $category['id'];
        } else {
            $this->db->insert('sondage_reponce_question', $reponce_sondage);
            return $this->db->insert_id();
        }
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('sondages');
    }

}
