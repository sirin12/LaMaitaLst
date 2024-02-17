<?php

Class Site_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('sites', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('sites');
            $result = $this->db->get();
            return $result->result();

        }
    }
	
    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('sites', $data);
            return $data['id'];
        } else {
            $this->db->insert('sites', $data);
            return $this->db->insert_id();
        }
    }

    function delete($id = false) {
        $this->db->where('id', $id);
        $this->db->delete('sites');
    }

}
