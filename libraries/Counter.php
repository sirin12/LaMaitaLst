<?php
class Counter {

	private $ci;
	// para CodeIgniter Super Global Referencias o variables globales
	
	private $dbtablehits= 'maitriseapp_hits';
	private $dbtableinfo= 'maitriseapp_info';
	// --------------------------------------------------------------------
	/**
	 * PHP5        Constructor
	 *
	 */
	function __construct() {
		$this -> ci = &get_instance();
		// get a reference to CodeIgniter.
		
		$this -> ci -> load -> model('md_commun');
	}

	// --------------------------------------------------------------------
	/*
			$query = $this -> ci -> db -> query("select dyn_menu.*, menu_lang.title  from dyn_menu join menu_lang where dyn_menu.id= menu_lang.id_menu and lang ='".$lang. "' order by position asc");
			
		foreach ($query->result() as $row) {
	*/
	
	
function addinfo($path, $site)
{  
   $page=explode('/',$path);
   $page = urldecode(end($page));
   $path= urldecode($path);
// gather user data
$ip= $_SERVER["REMOTE_ADDR"]; 
$agent =$_SERVER["HTTP_USER_AGENT"];
$datetime =date("Y-m-d") . ' ' . date('H:i:s') ;

// ########################################################
// ######### check if counter exsist and update ###########
// ########################################################

// ####################################################
// ######### add IP and user-agent and time ###########
// ####################################################





$query=$this -> ci -> db -> query("SELECT * FROM ".$this->dbtableinfo." WHERE site_id= $site and ip_address = '$ip' ");
$result=$query->result();

if(sizeof($result)==0) // check if the IP is in database
{
	// if not , add it.	
	$adddata = $this -> ci -> db -> query("INSERT INTO ".$this->dbtableinfo." (site_id,ip_address, user_agent, datetime, last_visit, count) VALUES($site, '$ip' , '$agent','$datetime','$datetime', 1 ) ") ;
	if (!$adddata) 
	{
	    echo('Could not add IP : '); // remove ?
	}
}else{
	
	
	if($result[0]->last_visit!=date("Y-m-d"))
	{
	$this -> ci -> db -> query("UPDATE ".$this->dbtableinfo."  SET count = count+1 , last_visit='".date("Y-m-d")."' WHERE id=".$query->row()->id) ;
	}
	
}

} 
	function newvisit()
	{ 
		$n= array('count' => 1);
		return $this -> ci ->md_commun->count('info',  $n);
	}
	function review()
	{ 
		$r= array('count >' => 1);
		return $this -> ci ->md_commun->count('info', $r);
	}
	function totalvisit()
	{ 
		return $this -> ci ->md_commun->sum('info', 'count');
	}
	function pageview()
	{ 
		return $this -> ci ->md_commun->sum('hits', 'count');
	}
	
	
	/*** Annonce ***/
	
	function totalannonce()
	{ 
		return $this -> ci ->md_commun->count('annonces');
	}
	
	/*** Count ***/
	
	function count($table, $cond)
	{ 
		return $this -> ci ->md_commun->count($table, $cond);
	}
	
}

// ------------------------------------------------------------------------
// End of Counter Library Class.

// ------------------------------------------------------------------------
/* End of file Counter.php */
/* Location: ../application/libraries/Counter.php */
