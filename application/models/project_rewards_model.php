<?php 
	
	class Project_rewards_model extends MY_Model {

		public $_table = 'cs_project_rewards';
		public $primary_key = 'proj_reward_id';


		/**
		 * Store the project rewards
		 * @param  mixed $params 
		 * @return Response
		 */
		public function store($reward_codes,$proj_id)
		{
			// return print_r($params['desc']);	
			for($i = 0; $i < count($reward_codes); $i++){

				$data[] = 
						array( 

								'proj_id'				=> $proj_id,
								'reward_code'			=> $reward_codes[$i]
							);
			}
			
			return $this->db->insert_batch($this->_table, $data,TRUE);
		}

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
			$this->db->join('cs_rewards r', 'r.reward_code = pr.reward_code','left');
			$rewards = $this->db->get()->result_object();
			return $rewards;
		}
	}

 ?>