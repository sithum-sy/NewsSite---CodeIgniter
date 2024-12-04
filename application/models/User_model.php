<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_user_by_email($email)
    {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->row();
    }

    public function get_roles()
    {
        $query = $this->db->get('roles');
        return $query->result_array();
    }

    public function add_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_users()
    {
        // $query = $this->db->get('users');
        // return $query->result_array();

        $this->db->select('users.*, roles.role');
        $this->db->from('users');
        $this->db->join('roles', 'users.role_id = roles.id', 'left'); // Adjust join type if needed
        $query = $this->db->get();
        return $query->result_array();
    }
}
