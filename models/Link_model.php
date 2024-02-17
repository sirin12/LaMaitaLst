<?php

Class Link_model extends CI_Model {

    function get($id=false, $position=false) {
		if($id)
		{
			$this->db->select('*');
			$this->db->where('id', $id);
			$this->db->order_by('sequence', 'Asc');
			$result = $this->db->get('links');
			
			return $result->row();
		}else{
			
			$this->db->select('*');
			$this->db->order_by('sequence', 'Asc');
			$result = $this->db->get('links');
			return $result->result();
		}
		
    }
	function get_links($parent = 0, $menu = false) {
        $this->db->where('parent_id', $parent);

        if ($menu)
            $this->db->where('menu_id', $menu);

        $this->db->order_by('sequence', 'asc');
        $result = $this->db->get('links')->result();

        $return = array();
        foreach ($result as $link) {
            $return[$link->id] = $link;
            $return[$link->id]->children = $this->get_links($link->id);
        }

        return $return;
    }

    function get_links_childs($parent = 0, $limit = false, $offset = false, $by = false, $sort = false) {
        $this->db->select('*')->from('links');

        $this->db->where('parent_id', $parent);

        if ($by)
            $this->db->order_by($by, $sort);


        if ($limit)
            $result = $this->db->limit($limit)->offset($offset)->get()->result();
        else
            $result = $this->db->get()->result();

        return $result;
    }

    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('links', $data);
            return $data['id'];
        } else {
			unset($data['id']);
            $this->db->insert('links', $data);
            return $this->db->insert_id();
        }
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('links');
    }

}
