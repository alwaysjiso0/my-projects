<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Captcha_model extends CI_Model{

    // Verify whether captcha code from user input and db are the same
    public function check_captcha($user_captcha) {
        $expiration = time() - 20; // Two hour limit
		$this->db->where('captcha_time < ', $expiration)
				->delete('captcha');

        $this->db->where('word', $user_captcha);
        $result = $this->db->get('captcha');

        if($result->num_rows() == 0){
            return false;
        } else {
            return true;
        }
		
    }

}
?>
