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

    public function view($page = 'home')
    {

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['users'] = $this->User_model->get_users();


        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
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
                redirect('editor-dashboard');
                break;
            case 3: // Journalist
                redirect('journalist-dashboard');
                break;
            case 4: // Reader
                redirect('home');
                break;
            default:
                redirect('login');
                break;
        }
    }

    public function load_register()
    {
        $this->load->model('User_model');

        $data['roles'] = $this->User_model->get_roles();

        $this->load->view('templates/header', $data);
        $this->load->view('pages/register', $data);
        $this->load->view('templates/footer', $data);
    }

    public function register_user()
    {
        $this->load->library('form_validation');
        $this->load->model('User_model');

        $this->form_validation->set_rules('id', 'Role', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('pages/register');
            $this->load->view('templates/footer');
        } else {
            $data = [
                'role_id' => $this->input->post('id'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'contact_number' => $this->input->post('contact_number'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            ];

            if ($this->User_model->add_user($data)) {
                $this->session->set_flashdata('success', 'User registered successfully!');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Failed to register user.');
                redirect('dashboard');
            }
        }
    }
}
