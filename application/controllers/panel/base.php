<?php 
	
	/**
	* 	Admin Panel Base Controller
	*/
	class Base extends CI_Controller
	{
		protected $panel_path = 'layouts/panel/';
		/**
		 * Show the index for adminin panel.
		 * @return Response.
		 */
		public function index()
		{
			
			$this->load_view(null,'layouts/panel/index');
		}


		/**
		 * Loading views in this concurrent controller.
		 * @param  array $data   
		 * @param  string $page_path 
		 * @return view
		 */
		public function load_view($data = null,$page_path)
		{
			$this->load->view($this->panel_path.'panel-header',$data); // load the header temp
			
			$this->load->view($page_path,$data);
			
		}
	}
 ?>