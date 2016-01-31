<?php 
	
	class Categories_model extends MY_Model {

		public $_table = 'cs_categories';
		public $primary_key = 'cat_id';

		/**
		 * Show all categories.
		 * @return Response
		 */
		public function all()
		{
			return $this->get_all();
		}

		/**
		 * Retrieve category name by primary key.
		 * @param  int $cat_id 
		 * @return object
		 */
		public function get_by_key($cat_id)
		{
			$query = $this->db->get_where($this->_table,array($this->primary_key => $cat_id));
			return $query->result_object();
		}
	}

 ?>