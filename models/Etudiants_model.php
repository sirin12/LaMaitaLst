<?php

Class Etudiants_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('etudiants', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('etudiants');
	   		$this->db->where('etat', 1);
            $result = $this->db->get();
            return $result->result();

        }
    }
	
	function check_societe($str, $id = false) {

        $this->db->select('societe');

        $this->db->from('etudiants');

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
            $this->db->update('etudiants', $data);
            return $data['id'];
        } else {
            $this->db->insert('etudiants', $data);
            return $this->db->insert_id();
        }
    }
	function save_note($data) {
       
            $this->db->insert('note_matieres', $data);
            return $this->db->insert_id();
       
    }
	function save_note_edit($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('note_matieres', $data);
            return $data['id'];
        } else {
            $this->db->insert('note_matieres', $data);
            return $this->db->insert_id();
        }
    }
	
	function save_note_admin($data) {
       
            $this->db->insert('note_matieres_admin', $data);
            return $this->db->insert_id();
       
    }
	function save_note_admin_edit($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('note_matieres_admin', $data);
            return $data['id'];
        } else {
            $this->db->insert('note_matieres_admin', $data);
            return $this->db->insert_id();
        }
    }
	function clear_etud_anne($etudiant_id)
    {
         $this->db->delete('etudiants_annee', array('etudiant_id' => $etudiant_id));
    }
	function save_etud_anne($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('etudiants_annee', $data);
            return $data['id'];
        } else {
            $this->db->insert('etudiants_annee', $data);
            return $this->db->insert_id();
        }
    }

	function delete($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('etudiants', $data);
    }
	
	function get_etudiants_class($annee,$class) {
            $this->db->select('*');
            $this->db->from('etudiants_annee');
	   		$this->db->where('etat', 1);
			$this->db->where('class', $class);
			$this->db->where('annee', $annee);
            $result = $this->db->get();
            return $result->result();

    }
	
	function get_note_matiere_ens_etud($annee,$matiere,$class,$enseign) {
            $this->db->select('*');
            $this->db->from('note_matieres');
	   		$this->db->where('etat', 1);
			$this->db->where('class_id', $class);
			$this->db->where('matiere_id', $matiere);
			$this->db->where('enseignants_id', $enseign);
			$this->db->where('annee', $annee);
            $result = $this->db->get();
            return $result->result();

    }
	function get_note_matiere_admin_etud($annee,$matiere,$class) {
            $this->db->select('*');
            $this->db->from('note_matieres_admin');
	   		$this->db->where('etat', 1);
			$this->db->where('class_id', $class);
			$this->db->where('matiere_id', $matiere);
			$this->db->where('annee', $annee);
            $result = $this->db->get();
            return $result->result();

    }
	
	function get_note_matiere_suppadmin_etud($annee,$matiere,$class) {
            $this->db->select('*');
            $this->db->from('note_matieres');
	   		$this->db->where('etat', 1);
			$this->db->where('class_id', $class);
			$this->db->where('matiere_id', $matiere);
			$this->db->where('annee', $annee);
            $result = $this->db->get();
            return $result->result();

    }
	function get_note_matiere_admin_etud_id($annee,$matiere,$class,$etudiant) {
            $this->db->select('*');
            $this->db->from('note_matieres_admin');
	   		$this->db->where('etat', 1);
			$this->db->where('class_id', $class);
			$this->db->where('etudiants_id', $etudiant);
			$this->db->where('matiere_id', $matiere);
			$this->db->where('annee', $annee);
            $result = $this->db->get();
            return $result->row();
    }
}
