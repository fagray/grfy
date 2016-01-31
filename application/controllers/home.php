<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
	public function index()
	{
		$this->load->library('session');
		$this->load->model('projects_model');
		$this->load->model('categories_model');
		$data['categories'] = $this->categories_model->all();
		$data['projects'] = $this->projects_model->retrieve(3);
		// return print_r($data['projects']);
		// temporarily set the session data manually
		$sess_data =  array(

						'usr_id' 	=> 9002,
						'fullname'	=> 'Mike',
						'email'		=> 'fuck@gmail.com',
						'alias'		=> 'msmith',
						'logged_in'	=> TRUE
					);

		$this->session->set_userdata($sess_data);
		$data['site_title'] = 'Greenify | ';
		$this->load->view('layouts/site/header',$data);
		$this->load->view('index');
	
	}
}
