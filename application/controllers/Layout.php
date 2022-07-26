<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout extends CI_Controller {

	public function __construct() {
        parent:: __construct();
        $this->load->library('session');
        $this->load->helper('form');
		$this->load->helper('url');
    } 
	
	public function index()
	{ 
        $this->load->view('template/header');
        $this->load->view('template/body_left'); 

        $tab_name = $this->uri->segment(3);
        if ($tab_name == 'myquestions') {
            $data['bg_m_myquestions'] = '#A4C3B2';
            $this->load->view('template/body_middle_account', $data); 
            $this->load->view('template/body_right_questions'); 
        } else if ($tab_name == 'bookmarks') {
            $data['bg_m_bookmarks'] = '#A4C3B2';
            $this->load->view('template/body_middle_account', $data); 
            $this->load->view('template/body_right_bookmark'); 
        } else if ($tab_name == 'chatrooms') {
            $data['bg_m_chatrooms'] = '#A4C3B2';
            $this->load->view('template/body_middle_account', $data); 
            $this->load->view('template/body_right_chatroom'); 
        } else if ($tab_name == 'account') {
            $data['bg_mid_account'] = '#A4C3B2';
            $this->load->view('template/body_middle_account', $data); 
            $this->load->view('account'); 
        } 

        $this->load->view('template/footer');
	}

    public function list_bookmark() {
        $this->load->view('template/header');
        $username = $this->session->userdata('username');
        $this->load->model('bookmark_model');

        $data['bookmarks'] = $this->bookmark_model->fetch_bmark_list($username);

        $this->load->view('template/body_left', $data); 
        $data['bg_m_bookmarks'] = '#A4C3B2';
        $this->load->view('template/body_middle_account', $data); 
        $this->load->view('template/body_right_bookmark');   
        $this->load->view('template/footer');
    } 

    public function list_myposts() {
        $this->load->view('template/header');
        $username = $this->session->userdata('username');
        $this->load->model('user_model');

        $data['my_posts'] = $this->user_model->get_posts_from_username($username);

        $this->load->view('template/body_left', $data); 
        $data['bg_m_myposts'] = '#A4C3B2';
        $this->load->view('template/body_middle_account', $data); 
        $this->load->view('template/body_right_questions', $data);   
        $this->load->view('template/footer');
    } 

    public function references() {
        $this->load->view('template/header');
        $this->load->view('template/body_left');
        $this->load->view('template/references');
        $this->load->view('template/footer');
    }




}
