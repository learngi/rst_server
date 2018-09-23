<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "/libraries/REST_Controller.php";


if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	exit(0);
}



class Api extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		$this->load->helper('jwt');
	}

	public function index_get()
	{
		$this->response('NULL');
	}
	
	public function register_post() 
	{
		// convert user submitted password to md5
		$email = $this->input->post('email');
		$name = $this->input->post('name');
		$mobile = $this->input->post('mobile');
		$city = $this->input->post('city');
		$message = $this->input->post('message');
		$to = 'info@rstglobaltech.com';
		$subject = 'Registration';
		// // Configure email library
	
		$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'info@rstglobaltech.com',
            'smtp_pass' => 'Mypapa@1',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
		
		$this->load->library('email');
		$temp = `Mr.${name} has register in RST Global. <br> 
		Mobile number is ${mobile}, <br>
		Email id :${email}, <br>
		City : ${city},<br>
		Message :'${message}`;
		$this->email->from('info@rstglobaltech.com', 'test mail');
		$this->email->to($to);

		$this->email->subject($subject);
		$this->email->message($temp);

		$st = $this->email->send();

		if($st) {
                         
                  $result['data'] = 'true';

		
		} else {
			$result['data'] = 'false';
		}
		$this->response($result);

	}
	

}