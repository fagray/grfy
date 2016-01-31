<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	*  Admin panel projects controller.
	*/
	class Projects extends CI_Controller
	{
		protected $panel_path = 'layouts/panel/'; 

		
		/**
		 * Show the listing of resource
		 * @return null
		 */
		public function index()
		{
			$this->load->model('projects_model');
			$data['projects'] = $this->projects_model->pending_all();

			return $this->load_view($data,'layouts/panel/projects/index');
		}

		public function show_pitch($proj_id)
		{
			$this->load->model('projects_model');
					//grab the backers
			$data['backers'] = $this->projects_model->get_backers($proj_id);
			//grab the rewards
			$data['rewards'] = $this->projects_model->get_rewards($proj_id);
			
			$data['project'] = $this->projects_model->get_by('proj_id', $proj_id);
			return $this->load_view($data,'layouts/panel/projects/pitch');
		}

		/**
		 * Approving submitted projects.
		 */
		public function accept_project()
		{

			$proj_id = $this->input->get('project_id');
			$this->load->model('projects_model');
			$this->projects_model->accept_project($proj_id);
			$value = array('response' => 200,'msg' => 'Project has been accepted!');
			return $this->toJson($value);
			
		}

		/**
		 * Output the specified values into json format.
		 * @param  array $value
		 * @return json object
		 */
		public function toJson($value)
		{
			return $this->output  
					->set_content_type('application/json')
	        		->set_output(json_encode($value));
		}

		/**
		 * Loading views in this concurrent controller.
		 * @param  array $data   
		 * @param  string $page_path 
		 * @return view
		 */
		public function load_view($data = null,$page_path)
		{
			$this->load->view($this->panel_path.'panel-header',$data); // load the header temp
			
			$this->load->view($page_path,$data);
			
		}


	}