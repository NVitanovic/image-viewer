<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct()
    {
            // Call the CI_Model constructor
            parent::__construct();
    }
    public function checkLogin()
    {
    	if(!isset($_POST['username']) && empty($_POST['username']) && !isset($_POST['password']) && empty($_POST['password']))
    		return 500; //error not complete
    	$username = $this->db->escape($_POST['username']);
    	$password = $this->db->escape_str($_POST['password']);

    	$q = $this->db->query("SELECT id,password FROM users WHERE username = {$username} LIMIT 1");
    	if(!$q->num_rows())
    		return 404; //not found

    	$row = $q->row_array();
        $userid = $row['id'];
        $DBpassword = $row['password'];

        if(!password_verify($password,$DBpassword))
            return 401; //not auth

    	$datenow = time();
    	$token = sha1($row['id'] . $datenow);
        $ip = $this->db->escape($_SERVER['REMOTE_ADDR']);

        $this->db->query("UPDATE acl SET expired = '1' WHERE userid = '{$userid}'"); //suspenduj sve ostale tokene
        $this->db->query("INSERT INTO acl (id,userid,token,expired,ip) VALUES(NULL,'{$userid}','{$token}','0',{$ip})"); //dodaj token
    	return $token;
    }
    public function checkToken()
    {
            if(!isset($_POST['token']) && empty($_POST['token']))
                return 500; //error not complete
            else
                $token = $_POST['token'];
 
    	$token = $this->db->escape_str($token);
    	$ip		= $this->db->escape_str($_SERVER['REMOTE_ADDR']);
    	$q = $this->db->query("SELECT ip,userid FROM acl WHERE token = '{$token}' && expired = '0' LIMIT 1");
    	if(!$q->num_rows())
    		return 404; //not found
    	//$row = $q->row_array();
        return 200; //ok status kod
    }
    public function getIdFromToken($token)
    {
        $token = $this->db->escape($token);
        $q = $this->db->query("SELECT userid FROM acl WHERE expired = '0' && token = {$token} LIMIT 1");
        if(!$q->num_rows())
            return -1; //greska

        $row = $q->row_array();

        return $row['userid'];
    }


}
