<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('post_model');
        $this->load->library('session');
        $this->load->helper('form');
		$this->load->helper('url');
    } 

    public function list_post() {
        $data['test'] = 'hello testing';
        $this->load->view('template/header');
        $tab_name = $this->uri->segment(3);

        if ($tab_name == 'general') {
            $data['bg_l_general'] = '#A4C3B2';
        } else if ($tab_name == 'academics') {
            $data['bg_l_academics'] = '#A4C3B2';
        } else if ($tab_name == 'employability') {
            $data['bg_l_employability'] = '#A4C3B2';
        } else if ($tab_name == 'fvisa') {
            $data['bg_l_financial'] = '#A4C3B2';
        } else {
            $data['bg_l_social'] = '#A4C3B2';
        }

        $data['category'] = $tab_name;
        $data['top_posts'] = $this->post_model->fetch_top_list($tab_name);
        $data['posts'] = $this->post_model->fetch_list($tab_name);

        $this->load->view('template/body_left', $data); 
        $this->load->view('template/body_middle', $data); 
        $this->load->view('template/body_right', $data);    
        $this->load->view('template/footer');
    }  

    public function open_post() {
        $tab_name = $this->uri->segment(3);
        $username = $this->session->userdata('username');
        $post_id = $this->uri->segment(4);
        $this->load->model('likes_model');
        $liked_status = $this->likes_model->like_status($username, $post_id);
        $this->load->model('bookmark_model');

        if ($tab_name == 'general') {
            $data['bg_l_general'] = '#A4C3B2';
        } else if ($tab_name == 'academics') {
            $data['bg_l_academics'] = '#A4C3B2';
        } else if ($tab_name == 'employability') {
            $data['bg_l_employability'] = '#A4C3B2';
        } else if ($tab_name == 'fvisa') {
            $data['bg_l_financial'] = '#A4C3B2';
        } else {
            $data['bg_l_social'] = '#A4C3B2';
        }

        $data['category'] = $tab_name;
        $data['top_posts'] = $this->post_model->fetch_top_list($tab_name);
        $data['posts'] = $this->post_model->fetch_list($tab_name);
        $data['comments'] = $this->post_model->fetch_comment_list($post_id);
        $data['current_post'] = $this->post_model->get_post_from_id($post_id);
        $data['username'] = $username;
        $this->post_model->increase_view($post_id);

        
        if ($this->likes_model->like_status($username, $post_id) == 1) {
            $data['like_status'] = 'active';
        } else {
            $data['like_status'] = '';
        }

        if ($this->bookmark_model->bookmark_status($username, $post_id) == 1) {
            $data['bmark_status'] = 'active';
        } else {
            $data['bmark_status'] = '';
        }

        $this->load->view('template/header');
        $this->load->view('template/body_left', $data); 
        $this->load->view('template/body_middle', $data); 
        $this->load->view('template/body_post', $data);    
        $this->load->view('template/footer');
    }

    public function like_post() {

        if ($this->session->userdata('logged_in'))
		{	
			$username = $this->session->userdata('username');
            $post_id = $this->uri->segment(4);
            $tab_name = $this->uri->segment(3);
            $this->load->model('likes_model');
            $liked_status = $this->likes_model->like_status($username, $post_id);

            if ($this->likes_model->like_status($username, $post_id) == 1) {
                $this->likes_model->decrease_like($username, $post_id);
                $data['like_status'] = 'active';
            } else {
                $this->likes_model->increase_like($username, $post_id);
                $data['like_status'] = '';
            }
            
            redirect('Post/open_post/'.$tab_name.'/'.$post_id);

		}else{
			redirect('login');
		}
     
    }

    public function bookmark_post() {

        if ($this->session->userdata('logged_in'))
		{	
			$username = $this->session->userdata('username');
            $post_id = $this->uri->segment(4);
            $tab_name = $this->uri->segment(3);
            $this->load->model('bookmark_model');
            $bmark_status = $this->bookmark_model->bookmark_status($username, $post_id);
            $link = current_url();

            if ($this->bookmark_model->bookmark_status($username, $post_id) == 1) {
                $this->bookmark_model->delete_bookmark($username, $post_id);
                $data['bmark_status'] = 'active';
            } else {
                $this->bookmark_model->add_bookmark($username, $post_id, $link);
                $data['bmark_status'] = '';
            }
            
            redirect('Post/open_post/'.$tab_name.'/'.$post_id);

		}else{
			redirect('login');
		}

    }

    public function edit_post() {

        $tab_name = $this->uri->segment(3);
        $post_id = $this->uri->segment(4);
        if ($tab_name == 'general') {
            $data['bg_l_general'] = '#A4C3B2';
        } else if ($tab_name == 'academics') {
            $data['bg_l_academics'] = '#A4C3B2';
        } else if ($tab_name == 'employability') {
            $data['bg_l_employability'] = '#A4C3B2';
        } else if ($tab_name == 'fvisa') {
            $data['bg_l_financial'] = '#A4C3B2';
        } else {
            $data['bg_l_social'] = '#A4C3B2';
        }

        $data['current_post'] = $this->post_model->get_post_from_id($post_id);
        $data['edit'] = 'edit';
        $data['tab_name'] = $tab_name;

        $this->load->view('template/header');
        $this->load->view('template/body_left', $data); 
        $this->load->view('write', $data); 
        $this->load->view('template/footer');

    }

    public function edit_success() {

        $tab_name = $this->uri->segment(3);
        $post_id = $this->uri->segment(4);
        $new_title = $this->input->post('title');
		$new_categories = $this->input->post('categories');
        $new_content = $this->input->post('content'); 
        $username = $this->session->userdata('username');

        $this->post_model->edit_post($post_id, $new_title, $new_content, $new_categories);
        
        redirect('Post/open_post/'.$tab_name.'/'.$post_id);

    }

    public function delete_post() {
        $tab_name = $this->uri->segment(3);
        $post_id = $this->uri->segment(4);
        $this->post_model->delete_post($post_id);
        redirect('Welcome');
    }

    public function write_comment() {
        if ($this->session->userdata('logged_in'))
		{	
			$tab_name = $this->uri->segment(3);
            $post_id = $this->uri->segment(4);
            $username = $this->session->userdata('username');
            $comment = $this->input->post('comment');

            $data = [
                'post_id' => $post_id,
                'username' => $username,
                'comment' => $comment
            ];

            $this->post_model->add_comment($data);

            redirect('Post/open_post/'.$tab_name.'/'.$post_id);

		}else{
			redirect('login');
		}

    }

}?>