<?php

use PhpSpreadsheet\Spreadsheet;
use PhpSpreadsheet\Writer\Xlsx;

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('News_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            $role_id = $this->session->userdata('role_id');

            redirect('dashboard');
        }

        $this->load->view('templates/header');
        $this->load->view('pages/login');
        $this->load->view('templates/footer');
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
            redirect('dashboard');
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

    public function view($page = null)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        if (!$page) {
            $role_id = $this->session->userdata('role_id');

            switch ($role_id) {
                case 1: // Admin
                    $page = 'admin-dashboard';
                    break;
                case 2: // News-Editor
                    $page = 'editor-dashboard';
                    break;
                case 3: // Journalist
                    $page = 'journalist-dashboard';
                    break;
                case 4: // Reader
                    $page = 'reader-dashboard';
                    break;
                default:
                    show_404();
            }
        }

        if (!file_exists(APPPATH . 'views/dashboards/' . $page . '.php')) {
            show_404();
        }

        // Initialize the data array
        $data = [];

        // Populate data based on role
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('user_id');

        switch ($role_id) {
            case 1: // Admin: View all users
                $data['users'] = $this->User_model->get_users();
                break;

            case 2: // News Editor: View articles for approval
                $data['news_articles'] = $this->News_model->get_submitted_news();
                break;

            case 3: // Journalist: View articles written by themselves
                $data['news_articles'] = $this->News_model->get_articles_by_journalist($user_id);
                break;

            case 4: // Reader: View all published articles
                $data['news_articles'] = $this->News_model->get_published_articles();
                break;
        }

        $this->load->view('dashboards/' . $page, $data);
    }


    public function load_register()
    {
        $data['roles'] = $this->User_model->get_roles();

        $this->load->view('templates/header', $data);
        $this->load->view('pages/register', $data);
        $this->load->view('templates/footer', $data);
    }

    public function register_user()
    {
        $this->form_validation->set_rules('id', 'Role', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules(
            'confirm_password',
            'Confirm Password',
            'required|matches[password]',
            array(
                'matches' => 'Passwords do not match.'
            )
        );

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

    public function view_user($user_id)
    {
        $data['user'] = $this->User_model->get_user_by_id($user_id);

        $this->load->view('dashboards/view_user', $data);
    }

    public function edit_user($id)
    {
        $data['user'] = $this->User_model->get_user_by_id($id);
        $data['roles'] = $this->User_model->get_roles();

        $this->load->view('dashboards/edit_user', $data);
    }

    public function update_user($id)
    {
        $user_id = $this->input->post('user_id');
        $role_id = $this->input->post('role_id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $contact_number = $this->input->post('contact_number');
        $current_status = $this->input->post('current_status');

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        // $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|numeric|trim');
        $this->form_validation->set_rules('role_id', 'Role', 'integer');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, load the edit view with errors
            $data['validation_errors'] = validation_errors();  // Capture the validation errors
            $data['user'] = $this->User_model->get_user_by_id($id);
            $data['roles'] = $this->User_model->get_roles();

            // Pass the validation errors to the view and reload
            $this->load->view('dashboards/edit_user', $data);
        } else {
            $update_data = array(
                'role_id' => $role_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'contact_number' => $contact_number,
                'is_active' => $current_status
            );

            $result = $this->User_model->update_user($user_id, $update_data);

            if ($result) {
                $this->session->set_flashdata('success', 'User updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update user. Please try again.');
            }

            redirect('users/view_user/' . $user_id);
        }
    }

    public function toggle_user_status($id)
    {
        $current_status = $this->input->post('current_status');
        $new_status = $current_status == 1 ? 0 : 1;

        if ($this->User_model->toggle_status($id, $new_status)) {
            $this->session->set_flashdata('success', 'User status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update user status.');
        }
        redirect('dashboard');
    }

    public function delete_user($id)
    {
        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user.');
        }
        redirect('dashboard');
    }


    public function export_users_to_excel()
    {
        $this->load->model('User_model');

        require_once FCPATH . 'vendor/autoload.php';  // Include autoload for PhpSpreadsheet

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $users = $this->User_model->get_users();

        // Set header for Excel sheet
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Role');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Mobile');
        $sheet->setCellValue('F1', 'Status');

        // Fill in user data
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user['id']);
            $sheet->setCellValue('B' . $row, $user['first_name'] . ' ' . $user['last_name']);
            $sheet->setCellValue('C' . $row, $user['role']);
            $sheet->setCellValue('D' . $row, $user['email']);
            $sheet->setCellValue('E' . $row, $user['contact_number']);
            $sheet->setCellValue('F' . $row, ($user['is_active'] == 1 ? 'Active' : 'Inactive'));
            $row++;
        }

        // File properties and download
        $filename = 'users_list_' . date('Y-m-d_H-i-s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        exit();
    }
}
