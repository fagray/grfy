<?php 
	
	/**
	*  Helper file
	*/
	class Outputter 
	{
		protected $CI;

		function __construct(argument)
		{
			$this->CI =& get_instance();
			return print_r($this->CI->load->library('output'))
		}

		public function toJson($value='')
		{

		}
	}

 ?>