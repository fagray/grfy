<?php 
	
	class Greenie_model extends MY_Model {

		public $_table = 'cs_greenies';
		public $primary_key = 'greenie_id';

		/**
		 * Show all resource.
		 * @return Response.
		 */
		public function all()
		{
			return $this->get_all();
		}

		
	
	}


 ?>