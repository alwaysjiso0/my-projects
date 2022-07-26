<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ajax extends CI_Controller {
    public function fetch()
    {
		$this->load->model('post_model'); 
        $output = '';
        $query = '';
        if($this->input->get('query')){ 
            $query = $this->input->get('query');
        }
        $data = $this->post_model->fetch_data_search($query);
        
        if($data != null){
            echo json_encode ($data->result());
        }else{
            echo  "";
        }
    }
}
?>