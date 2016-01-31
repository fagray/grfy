<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

	/**
	 * Show the project index page
	 * @return void
	 */
	public function index()
	{
		$this->load->model('projects_model');
		$this->load->model('categories_model');
		$data['site_title'] = 'Discover Greenie Projects';
		$data['projects'] = $this->projects_model->live_all();
		// return print_r($data['projects']);
		$data['categories'] = $this->categories_model->all();
		// return print_r($data['projects']);
		$this->load_view($data,'layouts/site/projects/index');
	}
	/**
	 * Show the project details
	 *
	 * @return void
	 */
	public function view()
	{
		
		//grab the 2nd uri segment and view the project details
		$proj_id = $this->get_data_on_the_uri(2);
		//grab the backers
		$data['backers'] = $this->get_backers();
		//grab the rewards
		$data['rewards'] = $this->get_rewards();
		$this->load->model('greenie_model');
		$this->load->model('session_model');

		//determine if the project is created by the authenticated user
		$greenie_id = $this->session_model->get_logged_in_user_id();
		$data['is_author'] = $this->projects_model->is_author($greenie_id,$proj_id);
		
		// $data['project'] = $this->projects_model->get_by('proj_id', $proj_id);
		$data['project'] = $this->projects_model->get_project_details($proj_id);
		$data['site_title'] = $data['project'][0]->title.'| Greenify';
		return $this->load_view($data,'layouts/site/projects/view2');
		
		
	}

	/**
	 * Show the form for pledging new project.
	 * @param  int $proj_id
	 * @return Response
	 */
	public function pledge($proj_id)
	{
		$this->load->model('projects_model');
		$data['project'] = $this->projects_model->get_by_key($proj_id);
		$data['site_title'] = 'Pledge Project | '.$data['project']->title;
		$data['rewards'] = $this->get_rewards(); 
		return $this->load_view($data,'layouts/site/projects/pledge');
	}

	public function post_pledge($proj_id)
	{
		// save the pledge amount
	}

	/**
	 * Show the form for collecting the pledged amount.
	 * @param  int $proj_id 
	 * @return Response
	 */
	public function payment($proj_id)
	{
		$amount = $_REQUEST['pledge_amount']; // dunno why $this->input->get('pledge_amount') wont work :(
		// return print $amount;
		
		$this->load->model('projects_model');
		$this->load->model('greenie_project_model');

		//process payment request
		$this->load->model('payments_model');
		$this->payments_model->process_payment_request($proj_id); // process the payment

		$this->load->model('session_model');
		$greenie_id = $this->session_model->get_logged_in_user_id();
		// return print $greenie_id;

		$this->greenie_project_model->backed_project($proj_id,$greenie_id,$amount);

		$data['project'] = $this->projects_model->get_by_key($proj_id);
		$data['site_title'] = 'Pledge Project | '.$data['project']->title;
		return $this->load_view($data,'layouts/site/projects/pay');
	}

	
	/**
	 * Loading the  frontend layouts.
	 * @param  array $data   
	 * @param  string $page_path 
	 * @return view
	 */
	public function load_view($data = '',$page_path)
	{
		$this->load->view('/layouts/site/header',$data);
		return $this->load->view($page_path,$data);
		
	}

	/**
	 * Get the project author.
	 * @param  int $proj_id
	 * @return void
	 */
	public function get_author()
	{
		$proj_id = $this->get_data_on_the_uri(2);
		$this->load->model('projects_model');
		return $this->projects_model->get_author($proj_id);

	}

	/**
	 * Grab the project backers.
	 * @return array $backers
	 */
	public function get_backers()
	{
		$proj_id = $this->get_data_on_the_uri(2);
		$this->load->model('greenie_project_model');
		return  $this->greenie_project_model->get_backers($proj_id);

	}

	/**
	 * Grab the project rewards.
	 * @return array $rewards
	 */
	public function get_rewards()
	{
		$proj_id = $this->get_data_on_the_uri(2);
		$this->load->model('project_rewards_model');
		return  $this->project_rewards_model->get_project_rewards($proj_id);
	}

	/**
	 * Grab data on the uri based on the segment section.
	 * @param  itn $segment 
	 * @return data
	 */
	public function get_data_on_the_uri($segment)
	{
		return $this->uri->segment($segment,0);
	}

	public function count_project_account($project_id)
	{
		$params = $this->greenie_project_model
							->count_account($project_id,false,false,true);
		return print_r($params);
	}

	
}
