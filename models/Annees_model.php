<?php

Class Annees_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('annee', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('annee');
	   		$this->db->where('etat', 1);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	
    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('annee', $data);
            return $data['id'];
        } else {
            $this->db->insert('annee', $data);
            return $this->db->insert_id();
        }
    }

	function delete($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('annee', $data);
    }

	
	function get_details($annee,$id = false) {
        if ($id) {
            $result = $this->db->get_where('annee_duree', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('annee_duree');
	   		$this->db->where('etat', 1);
			$this->db->where('annee_id', $annee);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
    function save_details($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('annee_duree', $data);
            return $data['id'];
        } else {
            $this->db->insert('annee_duree', $data);
            return $this->db->insert_id();
        }
    }
	
	
	function get_etudiants_annee($annee,$id = false) {
        if ($id) {
            $result = $this->db->get_where('etudiants_annee', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('etudiants_annee');
	   		$this->db->where('etat', 1);
			$this->db->where('annee', $annee);
            $result = $this->db->get();
            return $result->result();

        }
    }
	function save_etudiants_annee_semestre($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('etudiants_annee_semestre', $data);
            return $data['id'];
        } else {
            $this->db->insert('etudiants_annee_semestre', $data);
            return $this->db->insert_id();
        }
    }

	function delete_details($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('annee_duree', $data);
    }
}
