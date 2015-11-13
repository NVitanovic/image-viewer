<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_model extends CI_Model {

	public function __construct()
    {
            // Call the CI_Model constructor
            parent::__construct();
    }
    public function getImagesFromUser($limit = 30)
    {
    	if(!is_numeric($limit))
    		$limit = 30;
    	//echo $id . "-" .$limit;
    	if(!isset($_POST['token']) && empty($_POST['token']))
    		return 500; // no token

    	$token = $this->db->escape_str($_POST['token']);
    	$limit = $this->db->escape_str($limit);

    	$userid= $this->db->escape($this->user_model->getIdFromToken($token));
    	if($userid == -1)
    		return 403;

    	$q = $this->db->query("SELECT id,url,title,description,date FROM image WHERE userid = {$userid} LIMIT {$limit}");
    	if(!$q->num_rows())
    		return 404; //nema slike

    	$data = array();
    	foreach ($q->result_array() as $row) 
    	{
    		$row['date'] = strtotime($row['date']);
    		array_push($data, $row);

    	}
    	return $data;
    }

}