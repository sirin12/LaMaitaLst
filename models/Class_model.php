<?php

Class Class_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('class', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('class');
	   		$this->db->where('etat', 1);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	
    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('class', $data);
            return $data['id'];
        } else {
            $this->db->insert('class', $data);
            return $this->db->insert_id();
        }
    }

	function delete($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('class', $data);
    }
	
	function get_users_matiere($matiere_id) {
     
            $this->db->select('*');
            $this->db->from('users_matiere');
			$this->db->where('matiere_id', $matiere_id);
            $result = $this->db->get();
            return $result->result();
    }
	
	
	function get_matiere($class,$id = false) {
        if ($id) {
            $result = $this->db->get_where('coefficient', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('coefficient');
	   		$this->db->where('etat', 1);
			$this->db->where('class_id', $class);
            $result = $this->db->get();
            return $result->result();

        }
    }
	function get_matiere_enseignant($id_user,$id = false) {
        if ($id) {
            $result = $this->db->get_where('coefficient', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('coefficient');
	   		$this->db->where('etat', 1);
			$this->db->where('enseignants_id', $id_user);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	function get_matiere_admin($id = false) {
        if ($id) {
            $result = $this->db->get_where('coefficient', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('coefficient');
	   		$this->db->where('etat', 1);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	
	
	
    function save_matiere($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('coefficient', $data);
            return $data['id'];
        } else {
            $this->db->insert('coefficient', $data);
            return $this->db->insert_id();
        }
    }

	function delete_matiere($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('coefficient', $data);
    }
}
