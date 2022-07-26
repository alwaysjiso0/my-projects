<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPassword extends CI_Controller {
	public function index()
	{
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
        $this->load->view('forgot_password');
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
		$email = $this->input->post('email');
        

		if (! $this->user_model->reg_validate_email($email)) {
            $this->load->model('verify_model');
            $this->load->helper('string');
            $username = $this->user_model->get_username($email);
            set_cookie("username", $username, '300');
            $code = random_string('alnum', 16);
            
            $this->verify_model->gen_code($username, $code);

            $this->email->initialize($config);
            $this->email->from(get_current_user().'@student.uq.edu.au',get_current_user());
            $this->email->to($email);
            $this->email->subject('Unissence verification code');
            $this->email->message($code);
            $this->email->send();

            $data['error']= "<div class=\"alert\" role=\"alert\"> Email successfully sent. </div> ";
			$this->load->view('forgot_password', $data);
            
		} else {
			$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> The email doesn't exist. </div> ";
			$this->load->view('forgot_password', $data);
		}

		$this->load->view('template/footer');

	}

    public function verify_code() {

        $this->load->model('verify_model');
        $this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$vcode = $this->input->post('vcode');

        if ($this->verify_model->code_match($vcode)) {
            set_cookie('verified', 'true', '60'); // Stay verified for 1 minute
            $data['v_error']= "<div class=\"alert\" role=\"alert\"> Successfully matched code, enter new password. </div> ";
			$this->load->view('forgot_password', $data);
        } else {
            $data['v_error']= "<div class=\"alert alert-danger\" role=\"alert\"> Wrong verification code. </div> ";
			$this->load->view('forgot_password', $data);
        }

        $this->load->view('template/footer');
    }

    public function change_password() { 

        $this->load->model('user_model');
        $new_password = $this->input->post('new_password');
        $username = get_cookie('username');

        $this->load->view('template/header');
        $verified = get_cookie('verified');

        if (isset($new_password)) {
            if ($verified == 'true') {
                if (strlen($new_password) > 5) {
                    $this->user_model->change_pwd($username, $new_password);
                    $data['user'] = $this->user_model->get_user($username);
                    echo '<script type="text/javascript">
                        window.onload = function () { alert("Your password has successfully been changed."); } 
                        </script>'; 
                        echo "<script>setTimeout(\"location.href = 'https://infs3202-50c98acc.uqcloud.net/jisoo_project/login';\",1500);</script>";
                } else {
                    echo '<script type="text/javascript">
                        window.onload = function () { alert("Your password should be at least 6 characters."); } 
                        </script>'; 
                    echo "<script>setTimeout(\"location.href = 'https://infs3202-50c98acc.uqcloud.net/jisoo_project/ForgotPassword';\",1500);</script>";
                }
            } else {
                echo '<script type="text/javascript">
                    window.onload = function () { alert("You must enter correct verification code to change password."); } 
                    </script>'; 
                $this->load->view('forgot_password');
                $this->load->view('template/footer');
            }
            
        }

    } 

}
?>