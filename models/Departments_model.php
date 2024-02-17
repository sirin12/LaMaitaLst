<?php

Class Departments_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('departments', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('departments');
	   		$this->db->where('etat', 1);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	function check_societe($str, $id = false) {

        $this->db->select('societe');

        $this->db->from('departments');

        $this->db->where('societe', $str);
		$this->db->where('etat', 1);

        if ($id) {

            $this->db->where('id !=', $id);
        }

        $count = $this->db->count_all_results();

        if ($count > 0) {

            return true;
        } else {

            return false;
        }
    }
	
    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('departments', $data);
            return $data['id'];
        } else {
            $this->db->insert('departments', $data);
            return $this->db->insert_id();
        }
    }

	function delete($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('departments', $data);
    }
}
