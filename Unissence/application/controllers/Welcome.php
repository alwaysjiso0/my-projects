<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
        parent:: __construct();
        $this->load->library('session');
    }
	
	public function index()
	{ 
		$this->load->model('post_model');

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$data['category'] = 'general'; 
		$data['home'] = 'home'; 
		$data['bg_l_general'] = '#A4C3B2';
		$data['top_posts'] = $this->post_model->fetch_top_list('general');
		$this->load->view('template/body_left', $data);
		$data['posts'] = $this->post_model->fetch_list('general');
		$this->load->view('template/body_middle', $data);
		$this->load->view('template/body_right', $data);
		$this->load->view('template/footer'); 
	}


}
