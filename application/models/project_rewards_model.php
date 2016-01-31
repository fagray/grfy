<?php 
	
	class Project_rewards_model extends MY_Model {

		public $_table = 'cs_project_rewards';
		public $primary_key = 'proj_reward_id';

		/**
		 * Grab the project backers from the resource.
		 * @param  int $proj_id
		 * @return array $backers
		 */
		public function get_project_rewards($proj_id)
		{
			$this->db->select('*');
			$this->db->from('cs_project_rewards as pr');
			$this->db->where("pr.proj_id = $proj_id");
			$this->db->join('cs_rewards r', 'r.reward_id = pr.reward_id','left');
			$rewards = $this->db->get()->result_object();
			return $rewards;
		}
	}

 ?>