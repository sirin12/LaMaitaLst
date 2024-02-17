<?php

Class Comment_model extends CI_Model {

    function get($id = false, $limit=10, $offset=0) {
        if ($id) {
            $result = $this->db->get_where('comments', array('id' => $id));
            return $result->row();
        } else {
            $this->db->select('*');
            $this->db->from('comments');
            $this->db->where('site_id', $this->current_site->id);
            $this->db->limit($limit);
            $this->db->offset($offset);
            $this->db->order_by('id', 'desc');
            $result = $this->db->get();
            return $result->result();

        }
    }
    function get_post_comments($post)
    {   
            $this->db->select('*');
            $this->db->from('comments');
            $this->db->where('site_id', $this->current_site->id);
            $this->db->where('post_id', $post);
            $this->db->where ('status', 1);
            $result = $this->db->get()->result();
            /** check if there an active user ****/
             $user=get_cookie('user_guid');
            
            if($user)
            {
                // get user comment
                $this->db->select('*');
                $this->db->from('comments');
                $this->db->where('site_id', $this->current_site->id);
                $this->db->where('post_id', $post);
                $this->db->where ('status', 0);
                $this->db->where ('guid', $user);
                $comments = $this->db->get()->result();
                //echo $this->db->last_query();
                $result= array_merge($result,  $comments); 
            }
             return $result;
    }
    function get_last($limit=10, $offset=0) {
     
            $this->db->select('comments.*, sites.icon, sites.backgroundcolor, sites.name as site');
            $this->db->from('comments');
            $this->db->join('sites','sites.id=comments.site_id');
            $this->db->limit($limit);
            $this->db->offset($offset);
            $this->db->order_by('comments.id', 'desc');
            $result = $this->db->get();
            return $result->result();

       
    }
    function save($data) {
        if ($data['id']) {
            $this->db->where('id', $data['id']);
            $this->db->update('comments', $data);
            return $data['id'];
        } else {
            $this->db->insert('comments', $data);
            return $this->db->insert_id();
        }
    }

    function delete($id = false) {
        $this->db->where('id', $id);
        $this->db->delete('comments');
    }

}
