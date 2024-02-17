<?php

Class Clients_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('clients', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('clients');

            $result = $this->db->get();
            return $result->result();
        }
    }
	function get_typeclient($espace,$type=false,$id = false) {
       
            $this->db->select('*');
            $this->db->from('clients');
			$this->db->where('espace_pro', $espace);
			if($type)
			$this->db->where('type', $type);
			$this->db->where('supp_client',1);
            $result = $this->db->get();
            return $result->result();
    }
	
	function get_traces($client=false) {
        
            $this->db->select('*');
            $this->db->from('journal_client');
			if($client)
			$this->db->where('customer_id', $client);
            $result = $this->db->get();
            return $result->result();
       
    }
	
	function get_message($client) {
        
            $this->db->select('*');
            $this->db->from('messages');
			$this->db->where('email', $client);
            $result = $this->db->get();
            return $result->result();
       
    }
	function get_commandestt() {
        
            $this->db->select('*');
            $this->db->from('commande');
            $result = $this->db->get();
            return $result->result();
       
    }
	function get_commandesetat() {
        
            $this->db->select('*');
            $this->db->from('commande');
            $result = $this->db->get();
            return $result->result();
       
    }
	function get_commandes($client) {
        
            $this->db->select('*');
            $this->db->from('commande');
			$this->db->where('email', $client);
            $result = $this->db->get();
            return $result->result();
       
    }
	function get_commande($id) {
        
            $this->db->select('*');
            $this->db->from('commande');
			$this->db->where('id', $id);
            $result = $this->db->get();
            return $result->result();
    }
	function get_demandes($client) {
        
            $this->db->select('*');
            $this->db->from('demande_devis');
			$this->db->where('client', $client);
			$this->db->order_by('id', 'asc');
            $result = $this->db->get();
            return $result->result();
       
    }
	function get_demande($client, $id) {
        
            $this->db->select('*');
            $this->db->from('demande_devis');
			$this->db->where('client', $client);
			$this->db->where('id', $id);
            $result = $this->db->get();
            return $result->result();
    }
    function get_sites($ids)
    {
        return $this->db->select('*')->from('sites')->where_in('id',$ids)->get()->result();
    }

    function save($contact) {
        if ($contact['id']) {
            $this->db->where('id', $contact['id']);
            $this->db->update('clients', $contact);
            return $contact['id'];
        } else {
			unset($contact['id']);
            $this->db->insert('clients', $contact);
            return $this->db->insert_id();
        }
    }
	
	function save_commande($contact) {
        if ($contact['id']) {
            $this->db->where('id', $contact['id']);
            $this->db->update('commande', $contact);
            return $contact['id'];
        } else {
			unset($contact['id']);
            $this->db->insert('commande', $contact);
            return $this->db->insert_id();
        }
    }
	
	function save_categorie_client($contact) {
            $this->db->insert('category_clients', $contact);
            return $this->db->insert_id();
       
    }
	
	function change_status()
	  {
		$data['id'] = $this->input->post('id');
		$status=  $this->input->post('status');
		if($status=="true")
		$data['status'] =1;
		else
		$data['status'] =0;
		$this->Clients_model->save($data);
		echo $this->db->last_query();
	  }
  
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('clients');
    }

}
