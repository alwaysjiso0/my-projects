<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class write extends CI_Controller {

	public function __construct() {
        parent::__construct();

        $this->load->model('post_model');
        $this->load->helper('form');
		$this->load->helper('url');
    }
	
	public function index()
	{
        $this->load->view('template/header');
        if (!$this->session->userdata('logged_in'))//check if user logged in
		{	
			if (get_cookie('remember')) { // or remember me 
				$username = get_cookie('username');
				$password = get_cookie('password');
				if ( $this->user_model->login($username, $password) )
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data);
                    $this->load->view('template/body_left'); 
                    $this->load->view('write'); 
				}
			}else{
				redirect('login'); // both no then redirect to login
			}
		}else{
			$this->load->view('template/body_left'); 
            $this->load->view('write');
		}
		$this->load->view('template/footer');

	}

    public function new_post() {

        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|mp4|mkv|png';
        $config['max_size'] = 10000;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $this->load->library('upload', $config);

		$this->load->view('template/header');

        $new_title = $this->input->post('title');
		$new_categories = $this->input->post('categories');
        $new_content = $this->input->post('content'); 
        $username = $this->session->userdata('username');

        $dataInfo = array();
        $files = $_FILES;
        $cpt = count($_FILES['userfile']['name']);

        for($i=0; $i<$cpt; $i++)
        {           
            $_FILES['userfile']['name']= $files['userfile']['name'][$i];
            $_FILES['userfile']['type']= $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error']= $files['userfile']['error'][$i];
            $_FILES['userfile']['size']= $files['userfile']['size'][$i];    
            $this->upload->do_upload('userfile');
            $dataInfo[] = $this->upload->data();
        }

        if ( ! $this->upload->do_upload('userfile')) {
            $data = array('error' => $this->upload->display_errors());
            $data = [
                'username' => $username,
                'title' => $new_title,
                'category' => $new_categories,
                'content' => $new_content
            ];
            $this->post_model->new_post($data);
            $this->load->view('template/body_left'); 
            echo '<script type="text/javascript">
                            window.onload = function () { alert("Upload success! Go check your post under the category you selected."); } 
                        </script>'; 
            $this->load->view('write');
            $this->load->view('template/footer');
        } else {
            if (count($dataInfo) > 1) {
                $data = [
                    'username' => $username,
                    'title' => $new_title,
                    'category' => $new_categories,
                    'content' => $new_content,
                    'filename_1' => $dataInfo[0]['file_name'],
                    'filepath_1' => $dataInfo[0]['full_path'],
                    'filename_2' => $dataInfo[1]['file_name'],
                    'filepath_2' => $dataInfo[1]['full_path']
                ];
            } else {
                $data = [
                    'username' => $username,
                    'title' => $new_title,
                    'category' => $new_categories,
                    'content' => $new_content,
                    'filename_1' => $dataInfo[0]['file_name'],
                    'filepath_1' => $dataInfo[0]['full_path']
                ];
            }
            $this->post_model->new_post($data);
            $this->load->view('template/body_left'); 
            $this->load->view('write', array('error' => 'File upload success. <br/>'));
            $this->load->view('template/footer');
        }


    } 

}
