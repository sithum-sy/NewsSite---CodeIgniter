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
        $this->db->select('users.*, roles.role');
        $this->db->from('users');
        $this->db->where('deleted_at IS NULL');
        $this->db->join('roles', 'users.role_id = roles.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_by_id($user_id)
    {
        $this->db->select('users.*, roles.role');
        $this->db->from('users');
        $this->db->join('roles', 'users.role_id = roles.id', 'left');
        $this->db->where('users.id', $user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', ['deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function toggle_status($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', ['is_active' => $status]);
    }
}
