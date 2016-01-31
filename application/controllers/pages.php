<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Pages extends CI_Controller {

		public function about()
		{
			return $this->load_view(null,'layouts/site/about');
		}


	/**
	 * Loading the projects frontend layouts.
	 * @param  array $data   
	 * @param  string $page_path 
	 * @return view
	 */
	public function load_view($data = '',$page_path)
	{
		$this->load->view('/layouts/site/header',$data);
		$this->load->view($page_path,$data);
		
	}



	}

 ?>