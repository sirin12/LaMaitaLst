<?php
Class Ajax_model extends CI_Model
{
	function comboselect($table, $cols, $parent=false)
	{
		$this->db->select($cols[0] .' as id , '.$cols[1] .' as name');
		$this->db->from($table);
		if($parent)
		$this->db->where($parent[0],$parent[1]);


		return $this->db->get()->result();

	}

}
