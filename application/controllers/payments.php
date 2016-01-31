<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

	/**
	 * Process the payment request from the project pledging.
	 * @param  $proj_id integer
	 * @return Response
	 */
	public function process_payment_request($proj_id)
	{
		// $this->load->model('projects_model');
		// $data['project'] = $this->projects_model->get_by_key($proj_id);
		// $data['site_title'] = 'Pledge Project | '.$data['project']->title;
		// return $this->load_view($data,'layouts/site/projects/pay');
	}
}
