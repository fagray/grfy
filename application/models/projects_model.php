<?php 
	
	class Projects_model extends MY_Model {

		public $_table = 'cs_projects';
		public $primary_key = 'proj_id';

		
		/**
		 * Grab all the active projects.
		 * @return Response
		 */
		public function live_all()
		{
			$this->db->select('*');
			$this->db->from('cs_projects as p');
			$this->db->where('p.project_status = "approved"');
			$this->db->join('cs_categories c', 'c.cat_id = p.cat_id','left');
			$this->db->join('cs_greenies  g', 'g.greenie_id = p.user_id','left');
			// $this->db->join('cs_categories  as c', 'c.cat_id = p.cat_id','left');
			$projects = $this->db->get()->result_object();
			return $projects;
		}

		/**
		 * Grab all the pending projects.
		 * @return Response
		 */
		public function pending_all()
		{
			$this->db->select('*');
			$this->db->from('cs_projects as p');
			$this->db->where('p.project_status = "pending"');
			$this->db->join('cs_greenies g', 'g.greenie_id = p.user_id','left');
			$this->db->join('cs_categories c', 'c.cat_id = p.cat_id','left');
			$projects = $this->db->get()->result_object();
			return $projects;
		}

		/**
		 * Grab all the draft projects.
		 * @return Response
		 */
		public function draft_all()
		{
			$this->db->select('*');
			$this->db->from('cs_projects as p');
			$this->db->where('p.project_status = "draft"');
			$this->db->join('cs_greenies g', 'g.greenie_id = p.user_id','left');
			$this->db->join('cs_categories c', 'c.cat_id = p.cat_id','left');
			$projects = $this->db->get()->result_object();
			return $projects;
		}


		/**
		 * Grab projects with a corresponding limit.
		 * @return Response
		 */
		public function retrieve($entries = null)
		{
			$this->db->select('*');
			$this->db->from('cs_projects as p');
			$this->db->where('p.project_status = "approved"');
			$this->db->join('cs_greenie_projects gp', 'gp.project_id = p.proj_id','left');
			$this->db->join('cs_greenies g', 'g.greenie_id = p.user_id','left');
			$this->db->join('cs_categories c', 'c.cat_id = p.cat_id','left');
			$this->db->limit($entries);
			$projects = $this->db->get()->result_object();
			// return print_r($projects);
			return $projects;
		}

		/**
		 * Grab all the values based on primary key.
		 * @param  int $value
		 * @return Response
		 */
		public function get_by_key($value)
		{
			return $this->get_by($this->primary_key,$value);
		}

		/**
		 * Get the project author.
		 * 
		 * @return Response.
		 */
		public function get_author($proj_id)
		{
			$this->db->select('g.fname,g.lname');
			$this->db->from('cs_greenies as g');
			$this->db->where('g.greenie_id = "Backer"');
			$this->db->where("gp.project_id = $proj_id");
			$this->db->join('cs_greenies g', 'g.greenie_id = gp.greenie_id','left');
			$backers = $this->db->get()->result_object();
			return $backers;
		}

		/**
		 * Show the project details.
		 * @param  int $proj_id 
		 * @return Response.
		 */
		public function get_project_details($proj_id)
		{
			$this->db->select('*');
			$this->db->from('cs_projects as p');
			$this->db->where("gp.project_id = $proj_id");
			$this->db->join('cs_greenies g', 'g.greenie_id = p.user_id','left');
			$this->db->join('cs_greenie_projects gp', 'gp.project_id = p.proj_id','left');
			$data =  $this->db->get()->result_object();
			return $data;
		}

		/**
		 * Project pre-insertion.
		 * @param  array $params 
		 * @return int proj_id
		 */
		public function pre_insert($params)
		{
			return $stmt =  $this->db->insert($this->_table,$params);
			
		}

		/**
		 * Get project details by column
		 * @param  string $value 
		 * @param  string $column 
		 * @return object
		 */
		public function get_by_column($column = '',$value)
		{
			$query = $this->db->get_where($this->_table,array($column => $value));
			return $query->result_object();
		}

		/**
		 * Grab the project backers.
		 * @return array $backers
		 */
		public function get_backers($proj_id)
		{
		
			$this->load->model('greenie_project_model');
			return  $this->greenie_project_model->get_backers($proj_id);

		}

		/**
		 * Grab the project rewards.
		 * @return array $rewards
		 */
		public function get_rewards($proj_id)
		{
			$this->load->model('project_rewards_model');
			return  $this->project_rewards_model->get_project_rewards($proj_id);
		}

		/**
		 * Accepting project to be displayed on the site.
		 * @param  int $proj_id 
		 * @return boolean
		 */
		public function accept_project($proj_id)
		{
			$this->db->where('proj_id', $proj_id);
			$this->db->update($this->_table,
					 array('status' => 'approved','date_launched' => date('m-d-y') )); // update cs_projects set status = 'pending' where proj_id = {$proj_id}
			return true;
		}

		/**
		 * Return the project's funded amount.
		 * @param  int $proj_id 
		 * @return Response       
		 */
		public function get_funded_amount($proj_id)
		{
			$this->db->select_sum('amount');
		    $this->db->from('cs_greenie_projects');
		    $this->db->where('project_id',$proj_id);
		    $query = $this->db->get();
		    return $query->row()->amount;
		}

		/**
		 * Determine if the project is authored by the current user.
		 * @param  int  $greenie_id 
		 * @param  int  $proj_id    
		 * @return boolean             
		 */
		public function is_author($greenie_id,$proj_id)
		{
			$this->db->where("user_id", $greenie_id);
			$this->db->where("proj_id", $proj_id);
			$row_count = $this->db->count_all_results($this->_table);
			if ( $row_count > 0){

				return true;
			} 

			return false;
		}

		/**
		 * Grab projects based on selection.
		 * @param  int $limit  number of entries
		 * @param  int $option 0 = normal, 1 = featured, 2 = top pick
		 * @return mixed         
		 */
		public function get_selection($limit, $option)
		{
			$this->db->select('*');
			$this->db->from('cs_projects as p');
			$this->db->where("p.project_status","approved"); // 2 = top picks
			$this->db->where("p.selection", $option); // 2 = top picks
			$this->db->join('cs_greenies g', 'g.greenie_id = p.user_id','left');
			$this->db->join('cs_categories c', 'c.cat_id = p.cat_id','left');
			$this->db->limit($limit);
			$projects = $this->db->get()->result_object();
			return $projects;
			
		}

		public function update_project($proj_id,$params)
		{
			$this->db->where('proj_id', $proj_id);
			return $this->db->update($this->_table,$params);
		}

	
	


		
	}

 ?>