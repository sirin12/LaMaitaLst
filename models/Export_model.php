<?php

Class Export_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('export', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('export');

            $result = $this->db->get();
            return $result->result();
        }
    }

    function get_sites($ids)
    {
        return $this->db->select('*')->from('sites')->where_in('id',$ids)->get()->result();
    }

    function save($contact) {
        if ($contact['id']) {
            $this->db->where('id', $contact['id']);
            $this->db->update('export', $contact);
            return $contact['id'];
        } else {
			unset($contact['id']);
            $this->db->insert('export', $contact);
            return $this->db->insert_id();
        }
    }
	
  
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('export');
    }

}
