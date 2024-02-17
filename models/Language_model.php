<?php

Class Language_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('languages', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('languages');
			$this->db->where('active',1);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	function get_all() {
       
            $this->db->select('*');
            $this->db->from('languages');
            $result = $this->db->get();
            return $result->result();
    } 
	
	function get_default()
	{
		 $result = $this->db->get_where('languages', array('active'=>1,'default' =>1));
         return $result->row();
	}
    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('languages', $data);
            return $data['id'];
        } else {
            $this->db->insert('languages', $data);
            return $this->db->insert_id();
        }
    }

    function delete($id = false) {
        $this->db->where('id', $id);
        $this->db->delete('languages');
    }

}
