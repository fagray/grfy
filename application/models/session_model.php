<?php 
	
	class Session_model extends MY_Model {

		public function __construct()
		{
			$this->load->library('session');
		}

		/**
		 * Grab the id of an authenticated user.
		 * @return int $id;
		 */
		public function get_logged_in_user_id()
		{
			return $this->session->userdata('usr_id');
		}
	}

 ?>