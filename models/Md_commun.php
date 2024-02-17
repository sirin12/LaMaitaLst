<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Md_commun extends CI_Model {

    function __constract() {
        parent::model();
    }

    function add($table, $data) {
        $this->db->insert($table, $data);
        //echo $this->db->last_query();
        return $this->db->insert_id();
    }

    function update($table, $key, $kv, $data) {
        $this->db->where($key, $kv);
        $this->db->update($table, $data);

        //echo $this->db->last_query();
    }

    function update_cond($table, $cond, $data) {
        $keys = array_keys($cond);
        foreach ($keys as $key) {

            $this->db->where($key, $cond[$key]);
        }
        $this->db->update($table, $data);
    }

    function get($table) {
        $this->db->select('*');
        $this->db->from($table);

        $sql = $this->db->get();
        //echo $this->db->last_query();
        return $sql->result();
    }

    function get_rows($table, $cond, $order = false) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($cond);


        if ($order) {
            $orderkeys = array_keys($order);

            foreach ($orderkeys as $key) {

                $this->db->order_by($key, $order[$key]);
            }
        }
        $sql = $this->db->get();
        //echo $this->db->last_query().' <br> ';
        return $sql->result();
    }

    function search($table, $keywords, $order = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $keys = array_keys($keywords);
        foreach ($keys as $key) {

            $this->db->like($key, $keywords[$key]);
        }

      $this->db->order_by('id', $order);
        $sql = $this->db->get();
        return $sql->result();
    }
	function get_all($table, $keywords, $order = 'asc') {
        $this->db->select('*');
        $this->db->from($table);
        $keys = array_keys($keywords);
        foreach ($keys as $key) {

            $this->db->where($key, $keywords[$key]);
        }

        $sql = $this->db->get();
        return $sql->result();
    }
	
    function get_row($table, $cond) {
        $this->db->select('*');
        $this->db->from($table);
        $keys = array_keys($cond);
        foreach ($keys as $key) {

            $this->db->where($key, $cond[$key]);
        }
        //$this->db->order_by('id', 'desc');
        $sql = $this->db->get();
        //echo $this->db->last_query();
        return $sql->row();
    }

    function get_row_by_id($table, $id) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id', $id);
        $sql = $this->db->get();
        //echo $this->db->last_query();
        return $sql->row();
    }

    function get_last($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'desc');
        $sql = $this->db->get();
        //echo $this->db->last_query();
        return $sql->row()->id;
    }

    function get_last_row($table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id', 'desc');
        $sql = $this->db->get();
        //echo $this->db->last_query();
        return $sql->row();
    }
	
	function get_last_rowcond($table,$cond) {
        $this->db->select('*');
        $this->db->from($table);
		$keys = array_keys($cond);
        foreach ($keys as $key) {

            $this->db->where($key, $cond[$key]);
        }
        $this->db->order_by('id', 'desc');
        $sql = $this->db->get();
        //echo $this->db->last_query();
        return $sql->row();
    }

    public function record_count($table) {
        return $this->db->count_all($table);
    }

    public function join_tables($cols, $table, $join, $cond = false, $order = false, $in = false, $groupby = false, $return = false, $limit = false, $start = false) {

        if ($cols)
            $this->db->select($cols);
        /*         * ****************   Tables  ************** */
        $this->db->from($table);
        if ($join) {
            $Tkeys = array_keys($join);
            foreach ($Tkeys as $k) {
                $this->db->join($k, $join[$k]);
            }
        }

        if ($cond)
            $this->db->where($cond);

        if ($limit)
            $this->db->limit($limit, $start);

        /*         * ****************************** */

        /*         * ****************   In  **************** */
        if ($in) {
            $keys = array_keys($in);
            foreach ($keys as $key) {

                $this->db->where_in($key, $in[$key]);
            }
        }
        /*         * ****************************** */

        if ($groupby) {
            $this->db->group_by($groupby);
        }

        if ($order) {
            $orderkeys = array_keys($order);

            foreach ($orderkeys as $key) {

                $this->db->order_by($key, $order[$key]);
            }
        }

        $query = $this->db->get();
        if ($return)
            return $query->result();
        else {
            if ($query->num_rows() == 1)
                return $query->row();
            else
                return $query->result();
        }
    }

    public function fetch($table, $cond, $order = 'asc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $this->db->order_by('id', $order);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function fetchetat($table, $cond, $order = 'asc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
		$this->db->order_by('etat', 'desc');
		$this->db->order_by('id', $order);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
	public function fetchsos($table, $cond, $order = 'asc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $this->db->order_by('type_id', 'asc');
		$this->db->order_by('sequence', 'asc');
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	
    public function fetch_creat($table, $cond, $order = 'asc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $this->db->order_by('etat_correction', $order);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }	
	public function fetch_in($table, $cond, $order = 'asc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
		$ids = array('7', '8', '9','10','11');
		$this->db->where_in('id', $ids);
        $this->db->order_by('id', $order);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function fetch_seq($table, $cond, $order = 'asc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $this->db->order_by('sequence', $order);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function fetchcde($table, $cond, $order = 'asc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function fetch_tables($cols, $table, $join, $cond, $order = 'asc', $limit, $start) {

        if ($cols)
            $this->db->select($cols);
        /*         * ****************   Tables  ************** */
        $this->db->from($table);
        if ($join) {
            $Tkeys = array_keys($join);
            foreach ($Tkeys as $k) {
                $this->db->join($k, $join[$k]);
            }
        }
        /*         * ****************   Cond  **************** */
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        /*         * ****************************** */

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    function delete($table, $id) {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }
	function delete_genre($table, $id) {
        $this->db->where('film_id', $id);
        $this->db->delete($table);
    }

    function delete_cond($table, $cond) {
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $this->db->delete($table);
    }

    function truncate($table) {
        $this->db->truncate($table);
    }

    function sum($table, $col, $cond = false) {
        $this->db->select_sum($col);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $query = $this->db->get($table);

        return $query->row();
    }
	function sumtable($table, $col, $cond = false) {
        $this->db->select_sum($col);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $query = $this->db->get($table);

        return $query->row();
    }

    function count($table, $cond = false) {
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $this->db->from($table);

        return $this->db->count_all_results();
    }

    function increment($table, $field, $id) {
        $this->db->set(''.$field.'', ''.$field.' +1', false);
        $this->db->where('id', (int)$id);
        $this->db->update($table);
    }
	function incrementcond($table, $field, $cond1,$cond2) {
        $this->db->set(''.$field.'', ''.$field.' +1', false);
        $this->db->where('sondage_id', $cond1);
		$this->db->where('reponce1', $cond2);
        $this->db->update($table);
    }

    function decrement($table, $field, $id) {
        $this->db->set(''.$field.'', ''.$field.' -1', false);
        $this->db->where('id', (int)$id);
        $this->db->update($table);
    }

    function save($table, $data) {
		$id =$data['id'];
		unset($data['id']);
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($table, $data);
            return $id;
        } else {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }
    }
	function save_film($data) {
        $this->db->insert('genre_film', $data);
    }
	
	public function fetch_annee($table, $cond, $order = 'desc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $this->db->order_by('annee', $order);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
	public function fetch_pays($table, $cond, $order = 'asc', $limit, $start) {
        $this->db->limit($limit, $start);
        if ($cond) {
            $keys = array_keys($cond);
            foreach ($keys as $key) {

                $this->db->where($key, $cond[$key]);
            }
        }
        $this->db->order_by('pays', $order);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

// application/models/CorrectionSearchModel.php

public function searchCorrections($search_date, $search_urgence, $search_etat, $search_lot, $search_localisation, $search_correction,$id_projet,$id_appartement,$id_block,$id_etage)
{
    $this->db->from('corrections');

    // Add conditions based on provided search parameters
    if (!empty($search_date)) {
        $this->db->where('date', $search_date);
    }

    if (!empty($search_urgence)) {
        // Compare with integer values
        $this->db->where('etat_urgent', $search_urgence);
    }

    if (!empty($search_etat)) {
        $this->db->where('etat_correction', $search_etat);
    }

    if (!empty($search_lot)) {
        $this->db->where('travaux_id', $search_lot);
    }

    if (!empty($search_localisation)) {
        $this->db->where('localisation', $search_localisation);
    }

    if (!empty($search_correction)) {
        $this->db->where('intitile', $search_correction);
    }

  $this->db->where('projet_id', $id_projet);
  $this->db->where('appartements_id', $id_appartement);
  $this->db->where('bloc_id', $id_block);
  $this->db->where('etage_id', $id_etage);


    // Execute the query
    $query = $this->db->get();

    return $query->result();
}
public function searchCorrectionsAdmin($search_date, $search_urgence, $search_etat, $search_lot, $search_localisation, $search_correction,$id_projet,$id_appartement,$id_block,$id_etage,$admin)
{
    $this->db->from('corrections');

    // Add conditions based on provided search parameters
    if (!empty($search_date)) {
        $this->db->where('DATE(date)', date('Y-m-d', strtotime($search_date)));
    }

    if (!empty($search_urgence)) {
        // Compare with integer values
        $this->db->where('etat_urgent', $search_urgence);
    }

    if (!empty($search_etat)) {
        $this->db->where('etat_correction', $search_etat);
    }

    if (!empty($search_lot)) {
        $this->db->where('travaux_id', $search_lot);
    }

    if (!empty($search_localisation)) {
        $this->db->where('localisation', $search_localisation);
    }

    if (!empty($search_correction)) {
        // Subquery to match the 'projets' table based on 'projet_id'
        $subquery = "(SELECT projets FROM projets WHERE projets LIKE '%$search_correction%' AND projet_id = $id_projet)";
        $this->db->where("projet_id IN $subquery", null, false);
    }
    

  $this->db->where('projet_id', $id_projet);
  $this->db->where('appartements_id', $id_appartement);
  $this->db->where('bloc_id', $id_block);
  $this->db->where('etage_id', $id_etage);
  $this->db->where('user', $admin);


    // Execute the query
    $query = $this->db->get();

    return $query->result();
}

}

?>