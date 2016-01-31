<?php 
	
	class Payments_model extends MY_Model {

		public $_table = 'cs_payments';
		public $primary_key = 'payment_id';
		private $magic_hash = 'jrnallitnasodnumyar';

		public function process_payment_request($proj_id)
		{	
			$this->load->model('session_model'); 
			$data = array( 
							'payment_token'		=> $this->generate_hash(),
							'payment_method'	=> 'bank',
							'proj_id'			=> $proj_id,
							'greenie_id'		=> $this->session_model->get_logged_in_user_id()
						);
			// store payment request
			$this->db->insert($this->_table, $data);

			return true;
		}


		private function generate_hash(){

			return random_string('alnum', 32).sha1($this->magic_hash);
		}
	}

 ?>