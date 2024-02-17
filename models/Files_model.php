<?php

Class Files_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('files_page', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('files_page');
			$this->db->where('type',1);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	function get_page($parent,$page = false) {
       
            $this->db->select('*');
            $this->db->from('files_page');
			$this->db->where('type', $parent);
			
            $result = $this->db->get();
            return $result->result();

    }
	
    function save($data) {
        
            $this->db->insert('files_page', $data);
            return $this->db->insert_id();
        
    }
	function save_file($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('files_page', $data);
            return $data['id'];
        } else {
            $this->db->insert('files_page', $data);
            return $this->db->insert_id();
        }
    }
	
    function delete($file = false) {
        $this->db->where('filename', $file);
        $this->db->delete('files_page');
    }

}
