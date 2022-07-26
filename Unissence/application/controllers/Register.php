<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function index()
	{
        $data['reg_username_error']= "";
        $data['reg_pw_short_error']= "";
        $data['reg_email_error']= "";
        
        $this->load->helper('form');
		$this->load->helper('url');
        $this->load->view('template/header');
        $this->load->view('register', $data);
        $this->load->view('template/footer');
	}

    public function check_reg_valid() {

        $this->load->model('user_model');
		$this->load->helper('form');
		$this->load->helper('url'); 
		$this->load->view('template/header');
        $reg_username = $this->input->post('reg_username');
		$reg_password = $this->input->post('reg_password');
        $reg_email = $this->input->post('reg_email');
        $reg_phone = $this->input->post('reg_phone');

        
        if ($this->user_model->reg_validate_username($reg_username)) {
            if (strlen($reg_password) > 5) {
                if ($this->user_model->reg_validate_email($reg_email)) {
                    if (isset($reg_phone)) {
                        $data = array(
                            'username' => $reg_username,
                            'password' => $reg_password,
                            'email' => $reg_email,
                            'phone' => $reg_phone
                        );
                    } else {
                        $data = array(
                            'username' => $reg_username,
                            'password' => $reg_password,
                            'email' => $reg_email
                        );
                    }
                    $this->user_model->register_insert($data);
                    echo '<script type="text/javascript">
                            window.onload = function () { alert("You are successfully registered! Log in and go to Manage Account to verify your email. :)"); } 
                        </script>'; 
                    echo "<script>setTimeout(\"location.href = 'https://infs3202-50c98acc.uqcloud.net/jisoo_project/login';\",1500);</script>";
                } else {
                    $data['reg_email_error']= "<div class=\"alert alert-danger\" role=\"alert\"> The email is already registered. </div> ";
                    $this->load->view('register', $data);
                }
            } else {
                $data['reg_pw_short_error']= "<div class=\"alert alert-danger\" role=\"alert\"> The password should be more than 5 characters. </div> ";
                $this->load->view('register', $data);
            }
        } else {
            $data['reg_username_error']= "<div class=\"alert alert-danger\" role=\"alert\"> The username is already taken. </div> ";
            $this->load->view('register', $data);
        }

        $this->load->view('template/footer');
    } 

}
