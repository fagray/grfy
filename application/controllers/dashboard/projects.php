<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	*  Dashboard project controller.
	*/
	class Projects extends CI_Controller
	{
		protected $project;
		private $dashboard_path = '/layouts/dashboard/';

		
		/**
		 * Show all resource in the projects page.
		 * @return Response
		 */
		public function index()
		{
			
			$this->load->model('projects_model');
			$data['page_title'] = 'Greenie Projects';
			$data['projects'] = $this->projects_model->live_all();
			$data['projects_pending'] = $this->projects_model->pending_all();
			$data['projects_drafts'] = $this->projects_model->draft_all();
			return $this->load_view($data,$this->dashboard_path.'/projects/index');

		}

		/**
		 * Show the form for creating a new project.
		 * @return response
		 */
		public function plant()
		{	
			$data['site_title'] = 'Plant New Campaign';
			// grab categories 
			$this->load->model('categories_model');
			$data['categories'] = $this->categories_model->all();

			//return $this->load_view($data,"$this->dashboard_path/projects/plant_project");
			$this->load->view($this->dashboard_path.'dashboard-header',$data);
			$this->load->view($this->dashboard_path.'projects/plant_project2',$data);
		}

		/**
		 * Show form for project creation continuation.
		 * @param alpha num $proj_key 
		 * @return Response
		 */
		public function plant_continue($proj_key)
		{	
			$this->load->model('projects_model');
			$this->load->model('categories_model');

			$data['categories'] = $this->categories_model->all(true); 
			// return print_r($data['categories']);

			$data['project'] = $this->projects_model->get_by_column('creation_token',$proj_key);
			if ( count($data['project']) > 0 ) {

				$cat_id = $data['project'][0]->cat_id;
				$data['cat_name']	= $this->categories_model->get_by_key($cat_id); // grab cat_name
				// return print_r($data['project']->cat_id);
				// return print_r($data['project']);
				//return $this->load_view($data,$this->dashboard_path.'/projects/plant_project_wizard2');
				$this->load->view($this->dashboard_path.'dashboard-header',$data);
				$this->load->view($this->dashboard_path.'projects/plant_project_wizard2',$data);
				return;
			}

			return show_404('',TRUE); // show the 404 not found error
			
			
		}

		/**
		 * Grab the project backers.
		 * @return array $backers
		 */
		public function get_backers()
		{
			$proj_id = $this->get_data_on_the_uri(4);
			$this->load->model('greenie_project_model');
			$data['backers'] = $this->greenie_project_model->get_backers($proj_id);
			return $this->load_view($data,$this->dashboard_path.'/projects/project_backers');

		}


		/**
		 * Loading the necessary layouts
		 * @param  array $data   
		 * @param  string $page_path 
		 * @return view
		 */
		public function load_view($data = '',$page_path)
		{
			$this->load->view($this->dashboard_path.'dashboard-header',$data); // load the header temp
			$this->load->view($page_path,$data);
			
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

		

		/**
		 * Generate project random creation code
		 */
		public function generate_project_code()
		{
			
			return random_string('alnum', 16);
		}

		/**
		 * Generate random project hash for project editing.
		 */
		public function generate_project_edit_hash()
		{
			
			return random_string('alnum', 26);
		}

		public function summernote()
		{	
			return $this->load_view(null,$this->dashboard_path.'/projects/summernote_upload');

		}

		public function tinymce()
		{	
			return $this->load->view($this->dashboard_path.'/projects/testing/upload');

		}

		//handle the upload
		public function summernote_process_upload()
		{

			//return print $_FILES['image']['name'];
			$config['upload_path'] = './resources/site/assets/img/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	 = '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('image'))
			{
				//$error = array('error' => $this->upload->display_errors());
				return  print $this->upload->file_name;
				//return print "error";
				//$this->load->view('upload_form', $error);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
			//	return print "success uploading file";
				return  print $this->upload->file_name;
				//$this->load->view('upload_success', $data);
			}
		/*	
			 $this->load->helper('file');
			    if ($_FILES['files']['name']) {
			        if (!$_FILES['files']['error']) {
			            $name = md5(rand(100, 200));
			            $ext = explode('.', $_FILES['files']['name']);
			            $filename = $name . '.' . $ext[1];
			            $destination = base_url().'resources/site/assets/img/' . $filename; 
			            $location = $_FILES["files"]["tmp_name"];
			            move_uploaded_file($location, $destination);
			            echo base_url() . $filename; 
			        }
			        else
			        {
			          echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['files']['error'];
			        }

					}*/
		}

		/**
		 * Convert the data into json format 
		 * @param  [type] $value [description]
		 * @return [type]        [description]
		 */
		public function toJson($data)
		{
			
				return $this->output
					->set_content_type('application/json')
        			->set_output(json_encode($data));
		}


		/*
		| -------------------------------------------------------------------------
		| AJAX REQUEST METHODS
		| -------------------------------------------------------------------------
		*/
		
		/**
		 * Async request for creating a new project.
		 * @return Response
		 */
		public function ajx_plant_project()
		{
			
			$token = $this->generate_project_code(); // generate creation token
			$hash = $this->generate_project_edit_hash(); // just a random hash, no big deal


			$data = array (

					'title'			=> 	$this->input->get('proj_title'),
					'cat_id'		=> 	$this->input->get('category'),
					'funding_goal'	=> 	$this->input->get('fund_goal'),
					'creation_token'=>	$token

					);

			$this->load->model('projects_model');
			// $this->load->library('outputter');
			// $this->load->helper('outputter');
			$this->projects_model->pre_insert($data);
			$result = $this->projects_model->get_by_column('creation_token',$token);

			if ( count($result) > 0) {

				$proj_id =  $result[0]->proj_id;
				$response = array('code' => 200,'token' => $token,'hash' => $hash);
				return $this->toJson($response);

			}

			return show_404('',TRUE);
			
			
			
		}

		/**
		 * Auto save changes on project edit.
		 * @param  array $params 
		 * @return Response
		 */
		public function ajx_save_project()
		{

			//rewards
			$params['rewards']['amount'] 	= array_values($this->input->get('pr_reward_amount'));
			$params['rewards']['qty'] 		= array_values($this->input->get('pr_reward_qty'));
			$params['rewards']['desc'] 		= array_values($this->input->get('pr_reward_description'));
			$params['rewards']['dev_month'] = array_values($this->input->get('pr_reward_delivery_month'));
			$params['rewards']['dev_year'] 	= array_values($this->input->get('pr_reward_delivery_year'));

			$this->load->model('rewards_model');
			$this->rewards_model->store($params['rewards']);
			//store rewards 
			

		}





	}
 ?>