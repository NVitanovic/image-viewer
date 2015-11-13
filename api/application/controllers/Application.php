<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller {
	public function __construct()
    {
        parent::__construct();  
        header('Content-Type: application/json');

    }   
	public function getImagesFromUser($limit = 30)
	{
		$r = $this->image_model->getImagesFromUser($limit);
		
		if(is_numeric($r))
			echo json_encode(response('error',$r));
		else
			echo json_encode(response('ok','',$r));

	}
}