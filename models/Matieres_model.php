<?php

Class Matieres_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('matieres', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('matieres');
	   		$this->db->where('etat', 1);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	function check_societe($str, $id = false) {

        $this->db->select('societe');

        $this->db->from('matieres');

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
            $this->db->update('matieres', $data);
            return $data['id'];
        } else {
            $this->db->insert('matieres', $data);
            return $this->db->insert_id();
        }
    }

	function delete($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('matieres', $data);
    }
}
