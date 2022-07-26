<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Post_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Insert new post data on db
    public function new_post($data) { 
        $this->db->insert('post',$data);
    }

    // Get all posts that contains query
    public function fetch_data_search($query)
    {
        if($query == '')
        {
            return null;
        }else{
            $this->db->select('*');
            $this->db->from('post');
            $this->db->like('title', $query);
            $this->db->or_like('username', $query);
            $this->db->order_by('title', 'DESC');
            return $this->db->get();
        }
    }

    // Get all posts on a category
    public function fetch_list($tab_name)
    {
        $query = $this->db->query("SELECT *
			FROM post
			WHERE category = '$tab_name'
            ORDER BY created_at DESC
            ");
        
        return $query->result();
    }

    // Get the most popular posts on a category
    public function fetch_top_list($tab_name)
    {
        $query = $this->db->query("SELECT *
			FROM post
			WHERE category = '$tab_name'
            ORDER BY likes DESC LIMIT 3;
            ");
        
        return $query->result();
    }

    // Get post variable from post id
    public function get_post_from_id($post_id) {
        $query = $this->db->query("SELECT *
			FROM post
			WHERE id = '$post_id'");
        
        return $query->row();
    }

    // Increase the number of views of a post on db
    public function increase_view($post_id) {
        $this->db->set('views', '`views`+ 1', FALSE);
        $this->db->where('id', $post_id);
        $this->db->update('post');
    
    }

    // Update post data from user input on db
    public function edit_post($post_id, $new_title, $new_content, $new_categories) {
        $data = [
            'title' => $new_title,
            'content' => $new_content,
            'category' => $new_categories
        ];

        $this->db->where('id', $post_id);
        $this->db->update('post',$data);
    }

    // Delete post row on db
    public function delete_post($post_id) {
        $this -> db -> where('id', $post_id);
        $this -> db -> delete('post');
    }

    // Insert new comment on db
    public function add_comment($data) {
        $this->db->insert('post_comment',$data);
    }

    // Get all comments of a post from post id
    public function fetch_comment_list($post_id) {
        $query = $this->db->query("SELECT pc.username as username, pc.comment as comment, pc.created_at as created_at
			FROM post p, post_comment pc
			WHERE pc.post_id = '$post_id'
            AND p.id = pc.post_id
            ORDER BY pc.created_at DESC
            ");
        
        return $query->result();
    }


}
?>
