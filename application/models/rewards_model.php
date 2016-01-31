<?php 
	
	class Rewards_model extends MY_Model {

		public $_table = 'cs_rewards';
		public $primary_key = 'reward_id';

		public function store($params)
		{

			// return print_r($params['desc']);	
			for($i = 0; $i < count($params['amount']); $i++){

				$data[] = 
						array( 

								'amount'					=> $params['amount'][$i],
								'description'				=> $params['desc'][$i],
								'delivery_date_month'		=> $params['dev_month'][$i],
								'delivery_date_year'		=> $params['dev_year'][$i],
								'qty'						=> $params['qty'][$i]
							);
			}
			
			return $this->db->insert_batch($this->_table, $data,TRUE);

			// return true;
		}


		private function generate_hash(){

			return random_string('alnum', 32).sha1($this->magic_hash);
		}
	}

 ?>