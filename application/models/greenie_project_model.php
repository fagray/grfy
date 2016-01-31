<?php 
	
	class Greenie_project_model extends MY_Model {

		public $_table = 'cs_greenie_projects';
		public $primary_key = 'greenie_proj_id';


		public function backed_project($proj_id,$greenie_id,$amount)
		{
			$data = array(
							'project_id'	=> $proj_id,
							'greenie_id'	=> $greenie_id,
							'amount'		=> $amount
						);
	       
			return $this->db->insert($this->_table, $data);
		}

		
		/**
		 * Grab the project backers of a certain project.
		 * @param  int $proj_id
		 * @return array $backers
		 */
		public function get_backers($proj_id)
		{
			$this->db->select('*');
			$this->db->from('cs_greenie_projects as gp');
			$this->db->where('gp.type = "Backer"');
			$this->db->where("gp.project_id = $proj_id");
			$this->db->join('cs_greenies g', 'g.greenie_id = gp.greenie_id','left');
			$this->db->join('cs_projects p', 'p.proj_id = gp.project_id','left');
			$backers = $this->db->get()->result_object();
			return $backers;
		}

		/**
		 * Grab all the projects backed by a user.
		 * @param  int $greenie_id 
		 * @return Response.
		 */
		public function get_projects($greenie_id)
		{
			$this->db->select('*');
			$this->db->from('cs_greenie_projects as gp');
			$this->db->where('gp.type = "Backer"');
			$this->db->where("gp.greenie_id = $greenie_id");
			$this->db->join('cs_projects p', 'p.proj_id = gp.project_id','left');
			$this->db->join('cs_greenies g', 'g.greenie_id = gp.greenie_id','left');
			$projects = $this->db->get()->result_object();
			return $projects;
		}

		/**
		 * Retrieve data by several columns
		 * @param  array $params 
		 * @return Response    
		 */
		public function get_by_columns($params)
		{
			$query = $this->db->get_where($this->_table,$params);
			return $query->result_object();
		}

		/**
		 * Count the project's certain account.
		 * @param  int  $project_id 
		 * @param  boolean $funded     return the funded amount only.
		 * @param  boolean $pledges    return the pledges amount only.
		 * @param  boolean $all        return both funded and pledges amount.
		 * @return Response             
		 */
		public function count_account($project_id, $funded = false, $pledges = false,$all = true)
		{	
			$this->db->select_sum('amount');
			$query = $this->db->get($this->_table);
			$this->db->where('type = "Backer"');
			$this->db->where("gp.project_id = $project_id");
			// $this->db->from('cs_greenie_projects as gp');
			// $this->db->where('gp.type = "Backer"');
			// $this->db->where("gp.project_id = $project_id");
			// return print_r($sum = $this->db->get()->result_array());

		}

		

	}

 ?>