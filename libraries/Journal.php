<?php

class Journal {

    private $ci;
    private $dbtable = 'maitriseapp_journal';

    // --------------------------------------------------------------------
    /**
     * PHP5        Constructor
     *
     */
    function __construct() {
        $this->ci = &get_instance();
        // get a reference to CodeIgniter.

        $this->ci->load->model('md_commun');
    }

    // --------------------------------------------------------------------	

    function add($customer_id, $module, $description) {
        $ip = $_SERVER["REMOTE_ADDR"];
        $datetime = date("Y-m-d") . ' ' . date('H:i:s');


        // This page did not exsist in the counter database. A new counter must be created for this page.

        $insert = $this->ci->db->query("INSERT INTO " . $this->dbtable . " (customer_id, ip, datetime, module, designation)VALUES ('$customer_id', '$ip','$datetime', '$module', '$description')");

        if (!$insert) {
            echo ("Can\'t insert into " . $this->dbtable . " : "); // remove ?
        }
    }

}

// ------------------------------------------------------------------------
// End of Counter Library Class.

// ------------------------------------------------------------------------
/* End of file Counter.php */
/* Location: ../application/libraries/Counter.php */
