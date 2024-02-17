<?php

Class Download_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('download', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('download.*, products.name as product, products.files, products.sku');
            $this->db->from('download');
            $this->db->join('products','products.id=download.product_id', 'left');
            $result = $this->db->get();
            return $result->result();

        }
    }
	
    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('download', $data);
            return $data['id'];
        } else {
            $this->db->insert('download', $data);
            return $this->db->insert_id();
        }
    }

    function delete($id = false) {
        $this->db->where('id', $id);
        $this->db->delete('download');
    }

}
