<?php

Class Examen_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('examen', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('examen');
	   		$this->db->where('etat', 1);
            $result = $this->db->get();
            return $result->result();

        }
    }

	
    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('examen', $data);
            return $data['id'];
        } else {
            $this->db->insert('examen', $data);
            return $this->db->insert_id();
        }
    }

	function delete($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('examen', $data);
    }
}
