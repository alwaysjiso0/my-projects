<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Likes_model extends CI_Model{

    // Increase the number of likes and the users who liked a post
    public function increase_like($username, $post_id) {
        $this->db->where('username', $username);
        $this->db->where('post_id', $post_id);
        $result = $this->db->get('likes');

        if($result->num_rows() == 0){
            $data = [
                'username' => $username,
                'post_id' => $post_id
            ];
            $this->db->insert('likes', $data);

            $this->db->set('likes', '`likes`+ 1', FALSE);
            $this->db->where('id', $post_id);
            $this->db->update('post');

        } else {
            return null;
        }
    }

    // Decrease the number of likes and the users who liked a post
    public function decrease_like($username, $post_id) {
        $this->db->where('username', $username);
        $this->db->where('post_id', $post_id);
        $result = $this->db->get('likes');

        if($result->num_rows() == 1){
            $this -> db -> where('username', $username);
            $this -> db -> where('post_id', $post_id);
            $this -> db -> delete('likes');

            $this->db->set('likes', '`likes`- 1', FALSE);
            $this->db->where('id', $post_id);
            $this->db->update('post');

        } else {
            return null;
        }
    }

    // Check the like status of a post from username
    public function like_status($username, $post_id) {
        $this->db->where('username', $username);
        $this->db->where('post_id', $post_id);
        $result = $this->db->get('likes');

        if($result->num_rows() == 1){
            return 1;
        } else {
            return 0;
        }
    }

}
?>