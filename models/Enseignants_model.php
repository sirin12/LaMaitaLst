<?php

Class Enseignants_model extends CI_Model {

    function get($id = false) {
        if ($id) {
            $result = $this->db->get_where('users', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('users');
	   		$this->db->where('etat', 1);
			$this->db->where('role', 5);
            $result = $this->db->get();
            return $result->result();

        }
    }
	function get_matiere($id) {
        $this->db->where('id', $id);
        $user = $this->db->get('users')->row();
        if($user){
			$user->matiere =array();
			$matieres =$this->db->select('*')->from('users_matiere')->join('matieres', 'matieres.id=users_matiere.matiere_id', 'left')->where('user_id',$user->id)->get()->result();
			foreach($matieres as $m)
			{
				$user->matiere[]=$m->id;
			}
	
			return $user;
		}
    }
	function clear_matiere($user_id)
    {
         $this->db->delete('users_matiere', array('user_id' => $user_id));
    }
    function save_matiere($save)
    {
        $this->db->insert('users_matiere', $save);
    }

	function check_societe($str, $id = false) {

        $this->db->select('societe');

        $this->db->from('users');

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
            $this->db->update('users', $data);
            return $data['id'];
        } else {
            $this->db->insert('users', $data);
            return $this->db->insert_id();
        }
    }

	function delete($id = false) {
		$data['etat']=0;
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }
}
