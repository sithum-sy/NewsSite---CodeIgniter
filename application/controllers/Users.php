<?php

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            $this->redirect_by_role();
        }

        $this->load->view('login');
    }

    public function do_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->get_user_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata([
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'logged_in' => TRUE
            ]);

            $this->redirect_by_role();
        } else {
            $this->session->set_flashdata('error', 'Invalid email or password.');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'role_id', 'logged_in']);
        $this->session->set_flashdata('success', 'You have been logged out.');
        redirect('login');
    }

    private function redirect_by_role()
    {
        $role_id = $this->session->userdata('role_id');

        switch ($role_id) {
            case 1: // Admin
                redirect('dashboard');
                break;
            case 2: // News-Editor
                redirect('pages/dashboard/editor-dashboard');
                break;
            case 3: // Journalist
                redirect('pages/dashboard/journalist-dashboard');
                break;
            case 4: // Reader
                redirect('home');
                break;
            default:
                redirect('pages/login');
                break;
        }
    }
}
