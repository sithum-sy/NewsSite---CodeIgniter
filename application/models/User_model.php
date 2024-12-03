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

    // public function login()
    // {
    //     $email = $this->input->post('email');
    //     $password = $this->input->post('password');

    //     $this->load->model('User_model');
    //     $user = $this->User_model->get_user_by_email($email);

    //     if ($user && password_verify($password, $user->password)) {
    //         $this->session->set_userdata([
    //             'user_id' => $user->id,
    //             'role_id' => $user->role_id,
    //             'logged_in' => TRUE
    //         ]);

    //         // Redirect based on role
    //         if ($user->role_id == 1) { // Assuming 1 is the admin role ID
    //             redirect('pages/dashboard/admin-dashboard');
    //         } else {
    //             redirect('home'); // Redirect other users to a default page
    //         }
    //     } else {
    //         $this->session->set_flashdata('error', 'Invalid login credentials');
    //         redirect('login');
    //     }
    // }
}
