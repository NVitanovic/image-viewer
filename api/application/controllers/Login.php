<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
    {
        parent::__construct();  
        header('Content-Type: application/json');

    }   

	public function index()
	{
		
	}
	public function loginUsernamePassword()
	{
		
		$token = $this->user_model->checkLogin();
		if(is_numeric($token))
			echo json_encode(response('error',$token));
		else
			echo json_encode(response('ok','',$token));

	}
	public function checkToken()
	{
		$r = $this->user_model->checkToken();
		if($r == 200)
			echo json_encode(response('ok','',"ok"));
		else
			echo json_encode(response('error',$r));
	}
	public function b()
	{
		echo json_encode(response(1,"works!",array(array("info" => 'info123'),array("info" => 'info123'),array("info" => 'info123'))));
	}
	public function test($password)
	{
		echo password_hash($password, PASSWORD_BCRYPT);
	}
	public function proveripass($password,$hash)
	{
		if(password_verify($password,'$2y$10$ikuPGmDLIoN9oCJESlz7Z.apgMcX1J5bBjZEwlf9jMerVhI3vYj4W'))
			echo "ok";
		else
			echo "err";
	}
}
