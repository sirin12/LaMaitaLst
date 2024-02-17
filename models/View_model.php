<?php
Class View_model extends CI_Model {

    function most_viewed()
    {
        $this->db->select("hits.route, hits.count,products.*");
        $this->db->from('routes');
        $this->db->join('hits',"page=routes.slug");
        $this->db->join('products', 'routes.product_id=products.id');
        $this->db->distinct('routes.id');
        $this->db->order_by('count','desc');
        $this->db->limit(10);
        $result=$this->db->get()->result();   
        
        return $result ;
    }
}