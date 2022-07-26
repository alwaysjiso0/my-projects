<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	public function index()
	{
		$this->load->library('session');
        $this->load->helper('url');
		$this->load->helper('captcha');
   
        // Captcha configuration
        $vals = array(
            'img_path'      => '/var/www/htdocs/jisoo_project/assets/img/',
            'img_url'       => base_url().'/assets/img/',
            'font_path'     => '/var/www/htdocs/jisoo_project/system/fonts/texb.ttf',
            'img_width'     => '150',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 8,
            'font_size'     => 16,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            'colors'        => array(
                    'background' => array(255, 255, 255),
                    'border' => array(255, 255, 255),
                    'text' => array(0, 0, 0),
                    'grid' => array(255, 40, 40)
            )
        );
    
        $captcha = create_captcha($vals);
        $this->session->unset_userdata('valuecaptchaCode');
        $this->session->set_userdata('valuecaptchaCode', $captcha['word']);

		$data = array(
			'captcha_time'  => $captcha['time'],
			'ip_address'    => $this->input->ip_address(),
			'word'          => $captcha['word']
		);
		
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);

		$this->load->helper('form'); 
		$this->load->view('template/header');
		$this->load->model('user_model');		
		if (!$this->session->userdata('logged_in')) 
		{	
			if (get_cookie('remember')) { // user activated 'remember me' before
				$username = get_cookie('username'); // get user info. from cookie and set session
				$password = get_cookie('password');
				if ( $this->user_model->login($username, $password) )
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data);
					$this->load->view('template/body_left');
					$this->load->view('template/body_middle');
					$this->load->view('template/body_right'); 
				}
			} else { // Not logged in & user has NOT activated 'remember me' before
				$data['captchaImg'] = $captcha['image'];
				$this->load->view('login', $data); // redirect to login
			}
		} else { // Logged in
			$this->load->view('template/body_left');
			$this->load->view('template/body_middle');
			$this->load->view('template/body_right');
		}
		$this->load->view('template/footer');
	}

	public function check_login()
	{
		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$remember = $this->input->post('remember');
		$user_captcha = $this->input->post('captcha');

		$this->load->model('captcha_model');

		if(!$this->session->userdata('logged_in')){	// Not logged in
			if ( $this->user_model->login($username, $password) )
			{ // Correct username & password
				if ($this->captcha_model->check_captcha($user_captcha)) {
					$user_data = array(
						'username' => $username,
						'logged_in' => true 
					);
					if($remember) { // Remember me activated -> set cookie
						set_cookie("username", $username, '3600'); //set cookie, expires in 1 hour
						set_cookie("password", $password, '3600');
						set_cookie("remember", $remember, '3600'); 
					}	
					$this->session->set_userdata($user_data); // Session login
					redirect('welcome'); // Login page -> already logged in -> go to homepage
				} else { // Wrong captcha
					echo '<script type="text/javascript">
                            window.onload = function () { alert("You must submit the word that appears in the image."); } 
                        </script>'; 
					echo "<script>setTimeout(\"location.href = 'https://infs3202-50c98acc.uqcloud.net/jisoo_project/login';\",1500);</script>";
				}
			} else { // Wrong username & password
				echo '<script type="text/javascript">
                            window.onload = function () { alert("Wrong username or password."); } 
                        </script>'; 
				echo "<script>setTimeout(\"location.href = 'https://infs3202-50c98acc.uqcloud.net/jisoo_project/login';\",1500);</script>";
			}
		} else { 
			redirect('welcome');
		}
		$this->load->view('template/footer');
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in'); // delete login session
		$this->session->unset_userdata('username');
		redirect('welcome');
	}


}
?>