<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Outputter  {

		protected $CI;

		// We'll use a constructor, as you can't directly call a function
        // from a property definition.
        public function __construct()
        {
                // Assign the CodeIgniter super-object
                $this->CI =& get_instance();


        }

		/**
		 * Convert the data into json format 
		 * @param  [type] $value [description]
		 * @return [type]        [description]
		 */
		public function toJson($data)
		{
			 return print_r($this->CI->load->library('output'));
			return $this->output
					->set_content_type('application/json')
        			->set_output(json_encode($data));
		}

		
	}
 ?>