<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
		$this->load->helper('form');
		$this->load->helper('url'); 
    }
	
	public function index()
	{
        $this->load->view('template/header');
        if (!$this->session->userdata('logged_in'))
		{	
			if (get_cookie('remember')) { 
				$username = get_cookie('username');
				$password = get_cookie('password');
				if ( $this->user_model->login($username, $password) )
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); 

                    $username = $this->session->userdata('username');
                    $data['user'] = $this->user_model->get_user($username);
                    $data['bg_mid_account'] = '#A4C3B2';

                    $this->load->view('template/body_left'); 
                    $this->load->view('template/body_middle_account', $data); 
                    $this->load->view('template/body_right_account', $data); 
				}
			}else{
				redirect('login');
			}
		}else{
            $username = $this->session->userdata('username');
            $data['user'] = $this->user_model->get_user($username);
            $data['bg_mid_account'] = '#A4C3B2';
			$this->load->view('template/body_left'); 
            $this->load->view('template/body_middle_account', $data); 
            $this->load->view('template/body_right_account', $data); 
		}
		$this->load->view('template/footer');
	}

    public function change_password() { 

        $this->load->model('user_model');
        $new_password = $this->input->post('new_password');
        $username = $this->session->userdata('username');
        $this->load->view('template/header');

        if (isset($new_password)) {
            if (strlen($new_password) > 5) {
                $this->user_model->change_pwd($username, $new_password);
                $data['user'] = $this->user_model->get_user($username);
                $data['bg_mid_account'] = '#A4C3B2';
                
                echo '<script type="text/javascript">
                    window.onload = function () { alert("Your password has successfully been changed."); } 
                    </script>'; 
                $this->load->view('template/body_left'); 
                $this->load->view('template/body_middle_account', $data); 
                $this->load->view('template/body_right_account', $data); 
                $this->load->view('template/footer');
            } else {
                echo '<script type="text/javascript">
                    window.onload = function () { alert("Your password should be at least 6 characters."); } 
                    </script>'; 
                echo "<script>setTimeout(\"location.href = 'https://infs3202-50c98acc.uqcloud.net/jisoo_project/Account';\",1500);</script>";
            }
        }

    } 

    public function change_phone() { 

        $this->load->model('user_model');
        $new_phone = $this->input->post('new_phone');
        $username = $this->session->userdata('username');
        $this->load->view('template/header');

        if(isset($new_phone)) {
            $this->user_model->change_phone($username, $new_phone);
            
            echo '<script type="text/javascript">
                window.onload = function () { alert("Your phone number has successfully been changed."); } 
                </script>'; 
            $data['user'] = $this->user_model->get_user($username);
            $this->load->view('template/body_left'); 
            $this->load->view('template/body_middle_account', $data); 
            $this->load->view('template/body_right_account', $data); 
            $this->load->view('template/footer');
        }
    } 

    public function delete_user() {
        $this->load->model('user_model');
        $username = $this->session->userdata('username');

        $this->user_model->delete_user($username);

        $this->session->unset_userdata('logged_in'); 
		$this->session->unset_userdata('username');
		redirect('login'); 

    }

    public function verify_user() {
        $this->load->model('verify_model');
        $this->load->model('user_model');
        $this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$vcode = $this->input->post('vcode');
        $username = $this->session->userdata('username');

        if ($this->verify_model->code_match($vcode)) {
            $this->user_model->verify_user($username);
            echo '<script type="text/javascript">
                        window.onload = function () { alert("You are successfully verified! :)"); } 
                    </script>'; 
            echo "<script>setTimeout(\"location.href = 'https://infs3202-50c98acc.uqcloud.net/jisoo_project/Account';\",1500);</script>";
        } else {
            $data['v_error']= "<div class=\"alert alert-danger\" role=\"alert\"> Wrong verification code. </div> ";
			$this->load->view('verification', $data);
        }

        $this->load->view('template/footer');

    }

    public function send_email() {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mailhub.eait.uq.edu.au',
            'smtp_port' => 25,
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE ,
            'mailtype' => 'html',
            'starttls' => true,
            'newline' => "\r\n"
            );

		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');

        $username = $this->session->userdata('username');
		$email = $this->user_model->get_email($username);
        $this->load->model('verify_model');
        $this->load->helper('string');
        $code = random_string('alnum', 16);
        $this->verify_model->gen_code($username, $code);

        $this->email->initialize($config);
        $this->email->from(get_current_user().'@student.uq.edu.au',get_current_user());
        $this->email->to($email);
        $this->email->subject('Unissence verification code');
        $this->email->message($code);
        $this->email->send();

        $this->load->view('verification');
		$this->load->view('template/footer');

	}

}
