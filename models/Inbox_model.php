<?php

Class Inbox_model extends CI_Model {

    function get($id = false, $limit=10, $offset=0) {
        if ($id) {
            $result = $this->db->get_where('inbox', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('inbox.*');
            $this->db->from('inbox');
            $this->db->limit($limit);
            $this->db->offset($offset);
            $this->db->order_by('inbox.id', 'desc');
            $result = $this->db->get();
            return $result->result();

        }
    }
    function get_last($limit=10, $offset=0) {
     
            $this->db->select('inbox.*, sites.icon, sites.backgroundcolor, sites.name as site');
            $this->db->from('inbox');
            $this->db->join('sites','sites.id=inbox.site_id');
            $this->db->where('status',0);
            $this->db->limit($limit);
            $this->db->offset($offset);
            $this->db->order_by('inbox.id', 'desc');
            $result = $this->db->get();
            return $result->result();

       
    }
    function get_contact($id) {
        return $this->db->get_where('inbox', array('id' => $id))->row();
    }

    function save($contact) {
        if ($contact['id']) {
            $this->db->where('id', $contact['id']);
			unset($contact['id']);
            $this->db->update('inbox', $contact);
            
        } else {
			unset($contact['id']);
            $this->db->insert('inbox', $contact);
            return $this->db->insert_id();
        }
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('inbox');
    }
	
	/*--table--*/
	var $table = 'inbox';
	var $column_order = array(null,'id','name','email','phone','subject',null); //set column field database for datatable orderable
	var $column_search = array('name','email','phone','subject'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 
	private function _get_datatables_query()
	{
		$this->db->select('inbox.*');
		$this->db->from($this->table);
		
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if(isset($_POST['search']['value'])&&($_POST['search']['value'])) 
			{
				if($i===0) // first loop
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		
		if((isset($_POST['length']))&&(isset($_POST['start']))&&($_POST['length'] != -1))
		$this->db->limit($_POST['length'], $_POST['start']);
      
		
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

}
