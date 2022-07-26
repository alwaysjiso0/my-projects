<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Verify_model extends CI_Model{

    public function __construct() {
        $this->load->database();
    }

    // Generate a new verification code
    public function gen_code($username, $code) {
        $this->db->where('username', $username);
        $result = $this->db->get('verification_code');

        if($result->num_rows() == 0){
            $data = [
                'username' => $username,
                'code' => $code
            ];
            $this->db->insert('verification_code',$data);
        } else {
            $this -> db -> where('username', $username);
            $this -> db -> delete('verification_code');
            
            $data = [
                'username' => $username,
                'code' => $code
            ];
            $this->db->insert('verification_code',$data);
        }
    }

    // Check if the verification code from user input and the one on db are the same
    public function code_match($vcode) {
        $this->db->where('code', $vcode);
        $result = $this->db->get('verification_code');
        if ($result->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

}
?>
