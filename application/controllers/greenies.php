<?php 
	
	/**
	* 	Handles the processes used by the user.
	*/
	class Greenies extends CI_Controller
	{
		protected $dashboard_path = 'layouts/dashboard/';
		/**
		 * Show the user dashboard.
		 * @return Response.
		 */
		public function show_dashboard()
		{
			$this->load->model('projects_model');
			$data['projects'] = $this->projects_model->retrieve(5); //get 5 projects
			$this->load_view($data,'layouts/dashboard/index');
		}


		/**
		 * Contribute/back a certain project.
		 * @param  int $proj_id 
		 * @return Response.
		 */
		public function contribute($proj_id)
		{
			// process for contributing into a project
		}

		/**
		 * Grab all the backed projects of the user.
		 * @return Response.
		 */
		public function get_backed_projects()
		{
			$greenie_id = $this->session->userdata('usr_id');
			$this->load->model('greenie_project_model');
			$data['projects'] =  $this->greenie_project_model->get_projects($greenie_id);
			// return print_r($data['projects']);
			return $this->load_view($data,$this->dashboard_path.'projects/backed');
		}


		/**
		 * Loading views in this concurrent controller.
		 * @param  array $data   
		 * @param  string $page_path 
		 * @return view
		 */
		public function load_view($data = '',$page_path)
		{
			$this->load->view($this->dashboard_path.'dashboard-header',$data); // load the header temp
			$this->load->view($page_path,$data);
			
		}
	}
 ?>