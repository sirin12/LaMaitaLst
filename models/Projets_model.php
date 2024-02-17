<?php

Class Projets_model extends CI_Model {

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
	
	
	function clear_travaux_projets($projet_id)
    {
         $this->db->delete('projets_societe', array('projet_id' => $projet_id));
    }
    function save_travaux_projets($save)
    {
        $this->db->insert('projets_societe', $save);
    }
	
	function get_projet_travaux($id) {
        $this->db->where('id', $id);
        $projet = $this->db->get('projets')->row();
        if($projet){
			$projet->travaux_id =array();
			$menus =$this->db->select('*')->from('projets_societe')->join('travaux', 'travaux.id=projets_societe.travaux_id', 'left')->where('projet_id',$projet->id)->get()->result();
			foreach($menus as $m)
			{
				$projet->travaux_id[]=$m->id;
			}
			return $projet;
		}
    }
	function clear_travaux_projets_societes($projet_id,$travaux_id){
         $this->db->delete('travaux_societe', array('projet_id' => $projet_id,'travaux_id' => $travaux_id));
    }
    function save_travaux_projets_societe($save){
        $this->db->insert('travaux_societe', $save);
    }
	
	
	function get_projet_admin($id) {
        /*$this->db->where('id', $id);
        $projet = $this->db->get('projets')->row();
        if($projet){
			$projet->projet_id =array();
			$menus =$this->db->select('*')->from('projets_admin')->join('admin', 'admin.id=projets_admin.admin_id', 'left')->where('projet_id',$projet->id)->get()->result();
			foreach($menus as $m)
			{
				$projet->projet_id[]=$m->id;
			}
			return $projet;
		}*/
		$projet = $this->db->get('projets')->row();
		if($projet){
			$projet->projet_id =array();
			$menus =$this->db->select('*')->from('projets_admin')->where('admin_id',$id)->get()->result();
				foreach($menus as $m)
				{
					$projet->projet_id[]=$m->id;
				}
		
				return $projet;
		}
    }
	function clear_projets_admin($admin_id){
         $this->db->delete('projets_admin', array('admin_id' => $admin_id));
    }
    function save_projets_admin($save){
        $this->db->insert('projets_admin', $save);
    }
	
	function get_projet_admin_societe($id) {
		$projet = $this->db->get('projets')->row();
		if($projet){
			$projet->projet_id =array();
			$menus =$this->db->select('*')->from('projets_societe_admin')->where('societe_id',$id)->get()->result();
				foreach($menus as $m)
				{
					$projet->projet_id[]=$m->id;
				}
		
				return $projet;
		}
    }
	function clear_projets_admin_societe($societe_id){
         $this->db->delete('projets_societe_admin', array('societe_id' => $societe_id));
    }
    function save_projets_admin_societe($save){
        $this->db->insert('projets_societe_admin', $save);
    }
	
	
	function get_societes_admin_pv($id) {
		$societe = $this->db->get('societes')->row();
		if($societe){
			$societe->societe_id =array();
			$menus =$this->db->select('*')->from('societes_admin_pv')->where('pv_id',$id)->get()->result();
				foreach($menus as $m)
				{
					$societe->societe_id[]=$m->societe_id;
				}
		
				return $societe;
		}
    }
	function clear_societes_admin_pv($pv_id){
         $this->db->delete('societes_admin_pv', array('pv_id' => $pv_id));
    }
    function save_societes_admin_pv($save){
        $this->db->insert('societes_admin_pv', $save);
    }
	
	function get_societes_admin_pv_contact($pv_id,$societe_id) {
		$societe = $this->db->get('societes')->row();
		if($societe){
			$societe->contact_id =array();
			$menus =$this->db->select('*')->from('societes_admin_pv_contact')->where('pv_id',$pv_id)->where('societe_id',$societe_id)->where('etat',1)->get()->result();
				foreach($menus as $m)
				{
					$societe->contact_id[]=$m->contact_id;
				}
		
				return $societe;
		}
    }
	
	function clear_societes_admin_pv_contact($pv_id){
         $this->db->delete('societes_admin_pv_contact', array('pv_id' => $pv_id));
    }
    function save_societes_admin_pv_contact($save){
        $this->db->insert('societes_admin_pv_contact', $save);
    }
	
	function update_societes_admin_pv_contact($data){
		$this->db->where('pv_id', $data['pv_id']);
		$this->db->where('societe_id', $data['societe_id']);
		$this->db->where('contact_id', $data['contact_id']);
        $this->db->update('societes_admin_pv_contact', $data);
    }
	
	
	function get_projet_travaux_societe($projet_id,$travaux_id) {
      
			$projet->societe_id =array();
			$menus =$this->db->select('*')->from('travaux_societe')->where('travaux_id',$travaux_id)->get()->result();
			foreach($menus as $m)
			{
				$projet->societe_id[]=$m->id;
			}
	
			return $projet;
		
    }
}
