<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Bookmark_model extends CI_Model{

    // Insert user bookmark on db
    public function add_bookmark($username, $post_id, $link) {
        $this->db->where('username', $username);
        $this->db->where('post_id', $post_id);
        $result = $this->db->get('bookmark');

        if($result->num_rows() == 0){
            $data = [
                'username' => $username,
                'post_id' => $post_id,
                'link' => $link
            ];
            $this->db->insert('bookmark', $data);
        } else {
            return null;
        }
    }

    // Delete user bookmark on db
    public function delete_bookmark($username, $post_id) {
        $this->db->where('username', $username);
        $this->db->where('post_id', $post_id);
        $result = $this->db->get('bookmark');

        if($result->num_rows() == 1){
            $this -> db -> where('username', $username);
            $this -> db -> where('post_id', $post_id);
            $this -> db -> delete('bookmark');

        } else {
            return null;
        }
    }

    // Get whether the user has bookmarked a post or not
    public function bookmark_status($username, $post_id) {
        $this->db->where('username', $username);
        $this->db->where('post_id', $post_id);
        $result = $this->db->get('bookmark');

        if($result->num_rows() == 1){
            return 1;
        } else {
            return 0;
        }
    }

    // Get all the bookmark list from username
    public function fetch_bmark_list($username)
    {
        $query = $this->db->query("SELECT p.title, p.content, b.link, p.category, b.post_id
			FROM bookmark b, post p
			WHERE b.username = '$username'
            AND b.post_id = p.id
            ORDER BY b.created_at DESC
            ");
        
        return $query->result();
    }

}
?>