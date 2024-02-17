<?php

Class User_model extends CI_Model {

    function get($id = false) {
        if ($id) {
         $this->db->select('users.*, CONCAT(tutors.firstname, " ", tutors.lastname) as tutor,status.name as status, grades.name as grade,colors.name as colors, projects.name as project, groups.name as group, university.name as university, registration_estblishment.name as registration_estblishment, diploama_colors.name as diploama_colors, diploma.name as diploama, CONCAT(stutors.firstname, " ", stutors.lastname) as stutor, grades.study, status.study as study1');
		$this->db->from('users');
		$this->db->join('status', 'status.id=users.status','left');
		$this->db->join('grades', 'grades.id=users.grade_id','left');
		$this->db->join('colors', 'colors.id=users.attashment_colors_id','left');
		$this->db->join('colors as registration_estblishment', 'registration_estblishment.id=users.registration_colors_id','left');
		$this->db->join('colors as diploama_colors', 'diploama_colors.id=users.diploama_colors','left');
		$this->db->join('diploma', 'diploma.id=users.diploama','left');
		$this->db->join('projects', 'projects.id=users.project_id','left');
		$this->db->join('groups', 'groups.id=users.group_id','left');
		$this->db->join('university', 'university.id=users.university_id','left');
		$this->db->join('users as tutors', 'tutors.id=users.tutor_id','left');
		$this->db->join('users as stutors', 'stutors.id=users.stutor_id','left');
		$this->db->where('users.id',$id);
		$result = $this->db->get();
		return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('users');
            $result = $this->db->get();
            return $result->result();

        }
    }
	function get_waiting_user()
	{
		$this->db->select('users.*, CONCAT(tutors.firstname, " ", tutors.lastname) as tutor, grades.name as grade,colors.name as colors, projects.name as project, groups.name as group,status.name as status');
		$this->db->from('users');
		$this->db->join('grades', 'grades.id=users.grade_id','left');
		$this->db->join('colors', 'colors.id=users.attashment_colors_id','left');
		$this->db->join('projects', 'projects.id=users.project_id','left');
		$this->db->join('groups', 'groups.id=users.group_id','left');
		$this->db->join('users as tutors', 'tutors.id=users.tutor_id','left');
		$this->db->join('status', 'status.id=users.status','left');
		$this->db->where('users.account_status <=',0);
		$result = $this->db->get();
		return $result->result();

	}
	
	function get_members($archived=false)
	{
		$this->db->select('users.*, grades.name as grade,colors.name as colors, projects.name as project, groups.name as group,status.name as status');
		$this->db->from('users');
		$this->db->join('grades', 'grades.id=users.grade_id','left');
		$this->db->join('colors', 'colors.id=users.attashment_colors_id','left');
		$this->db->join('projects', 'projects.id=users.project_id','left');
		$this->db->join('groups', 'groups.id=users.group_id','left');
		$this->db->join('status', 'status.id=users.status','left');
		$this->db->where('users.account_status',1);
		$this->db->where('users.deleted',0);
		if($archived)
		$this->db->where('users.archived',1);
		else
		$this->db->where('users.archived',0);
		$result = $this->db->get();
		return $result->result();
		
	}
	
	function get_tutors()
	{
		$this->db->select('users.*');
		$this->db->from('users');
		$this->db->join('grades', 'grades.id=users.grade_id');
		$this->db->where('account_status',1);
		$this->db->where('tuteur',1);
		$this->db->where('users.deleted',0);
		$this->db->where('users.archived',0);
		$result = $this->db->get();
		return $result->result();
	}
	
	function get_user_by_role($role)
	{
		 $this->db->select('*');
		$this->db->from('users');
		$this->db->where('role_id',$role);
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->row();

	}
	
	function get_tutorial_list($id=false)
	{
		$this->db->select('users.*,CONCAT(tutors.firstname, " ", tutors.lastname) as tutor, grades.name as grade,colors.name as colors, projects.name as project, groups.name as group');
		$this->db->from('users');
		$this->db->join('grades', 'grades.id=users.grade_id','left');
		$this->db->join('colors', 'colors.id=users.attashment_colors_id','left');
		$this->db->join('projects', 'projects.id=users.project_id','left');
		$this->db->join('groups', 'groups.id=users.group_id','left');
		$this->db->join('users as tutors', 'tutors.id=users.tutor_id','left');
		$this->db->where('users.account_status',1);
		$this->db->where('users.role_id',4);
		if($id)
		$this->db->where('users.tutor_id',$id);
		$this->db->order_by('users.subscription_date', 'asc');
		$result = $this->db->get();
		return $result->result();
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

    public function check_email($email)
    {
      $result = $this->db->get_where('users', array('email' => $email));
      return $result->row();
    }

    function delete($id = false) {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }
	
	function count_active_member()
	{
		$this->db->where('users.deleted',0);
		$this->db->where('users.archived',0);
		$this->db->where('account_status',1);
		$this->db->from('users');
		return $this->db->count_all_results();
	}
	
	function stats_tutorials()
	{
		$this->db->select('users.*');
		$this->db->from('users');
		$this->db->join('grades', 'grades.id=users.grade_id');
		$this->db->where('account_status',1);
		$this->db->where('tuteur',1);
		$this->db->where('users.deleted',0);
		$this->db->where('users.archived',0);
		$result = $this->db->get();
		$tutors= $result->result();
		
		foreach($tutors as $tutor)
		{
			$this->db->where('users.deleted',0);
			$this->db->where('users.archived',0);
			$this->db->where('account_status',1);
			$this->db->where('tutor_id',$tutor->id);
			$this->db->from('users');
			$tutor->count=$this->db->count_all_results();
		}
		return $tutors;
		
	}
	
	function count_waiting_subscription()
	{
		$this->db->select('users.*, CONCAT(tutors.firstname, " ", tutors.lastname) as tutor, grades.name as grade,colors.name as colors, projects.name as project, groups.name as group,status.name as status');
		$this->db->from('users');
		$this->db->join('grades', 'grades.id=users.grade_id','left');
		$this->db->join('colors', 'colors.id=users.attashment_colors_id','left');
		$this->db->join('projects', 'projects.id=users.project_id','left');
		$this->db->join('groups', 'groups.id=users.group_id','left');
		$this->db->join('users as tutors', 'tutors.id=users.tutor_id','left');
		$this->db->join('status', 'status.id=users.status','left');
		$this->db->where('users.account_status <=',0);
		return $this->db->count_all_results();

	}
	function get_user_by_email($email)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$result = $this->db->get();
		return $result->row();
	}
	function reset_password($email) {

    $this->load->library('encrypt');

    $customer = $this->get_user_by_email($email);

    if ($customer) {
      $this->load->helper('string');
      $this->load->library('email');
      $new_password = random_string('alnum', 8);
      $save= array();
      $save['password'] = $new_password;
      $save['id'] = $customer->id;

      $this->save($save);
      
      return $new_password;
    } else {

      return false;
    }
  }
}
