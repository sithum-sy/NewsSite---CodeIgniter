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
        $this->load->helper(['url_helper', 'form', 'text', 'url']);
        $this->load->library('form_validation');
    }

    // View login page/dashboard 
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

    // Log in after entering email and password
    public function do_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->get_user_by_email($email);

        if ($user) {
            if ($user->is_active == 0) {
                $this->session->set_flashdata('error', 'Your account is deactivated. Please contact admin.');
            } else if (password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'role_id' => $user->role_id,
                    'logged_in' => TRUE
                ]);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid email or password.');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid email or password.');
        }
        redirect('login');
    }


    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'role_id', 'logged_in']);
        $this->session->set_flashdata('success', 'You have been logged out.');
        redirect('login');
    }

    // View unique dashboard based on user
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

        $data = [];

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
                // $data['news_articles'] = $this->News_model->get_published_articles();
                redirect('home');
                break;
        }

        $this->load->view('templates/header');
        $this->load->view('dashboards/' . $page, $data);
        $this->load->view('templates/footer');
    }

    // View register form in admin dashboard and in homepage for new readers
    public function load_register()
    {
        if ($this->session->userdata('logged_in')) {
            $role_id = $this->session->userdata('role_id');

            if ($role_id == 1) {
                // If admin, load the register page for admin
                $data['roles'] = $this->User_model->get_roles();

                $this->load->view('templates/header', $data);
                $this->load->view('pages/register', $data);  // Admin register page
                $this->load->view('templates/footer', $data);
            } else {
                // If user is not admin, redirect to reader registration page
                $this->load->view('templates/header');
                $this->load->view('dashboards/reader/register_reader');
                $this->load->view('templates/footer');
            }
        } else {
            // If not logged in, redirect to the reader registration page
            $this->load->view('templates/header');
            $this->load->view('dashboards/reader/register_reader');
            $this->load->view('templates/footer');
        }
    }


    // Register a user by admin and self register
    public function register_user()
    {
        $this->form_validation->set_rules('id', 'Role', 'required');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]', array(
            'matches' => 'Passwords do not match.'
        ));

        if ($this->session->userdata('logged_in')) {
            $role_id = $this->session->userdata('role_id');
        } else {
            // Default to 'reader' if not logged in
            $role_id = 4;
        }

        if ($this->form_validation->run() === FALSE) {
            $data['roles'] = $this->User_model->get_roles();
            $this->load->view('templates/header');

            if ($role_id == 1) {
                $this->load->view('pages/register', $data);
            } else {
                $this->load->view('dashboards/reader/register_reader');
            }

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

                // If the role is admin, redirect to the admin dashboard
                if ($role_id == 1) {
                    redirect('dashboard');
                }

                if ($role_id == 4) {
                    $user_data = $this->User_model->get_user_by_email($this->input->post('email'));
                    $this->session->set_userdata('logged_in', TRUE);
                    $this->session->set_userdata('user_id', $user_data->id);
                    $this->session->set_userdata('role_id', 4);
                    redirect('home');
                }
            } else {
                $this->session->set_flashdata('error', 'Failed to register user.');
                redirect('dashboard');
            }
        }
    }


    // View a single user by admin
    public function view_user($user_id)
    {
        $data['user'] = $this->User_model->get_user_by_id($user_id);

        $this->load->view('templates/header');
        $this->load->view('dashboards/admin/view_user', $data);
        $this->load->view('templates/footer');
    }

    // View edit form of a single user by admin
    public function edit_user($id)
    {
        $data['user'] = $this->User_model->get_user_by_id($id);
        $data['roles'] = $this->User_model->get_roles();

        $this->load->view('templates/header');
        $this->load->view('dashboards/admin/edit_user', $data);
        $this->load->view('templates/footer');
    }

    // Upadte edited data by admin
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

    // Toggle active/inactive by admin
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

    // Delete a user by admin
    public function delete_user($id)
    {
        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user.');
        }
        redirect('dashboard');
    }

    // Get spreadsheet of user data
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

    // Get articles' report by admin
    public function get_all_articles_report()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['news_articles'] = $this->News_model->get_submitted_news();
        $data['categories'] = $this->News_model->get_all_categories();

        $this->load->view('templates/header');
        $this->load->view('dashboards/admin/view_news_articles', $data);
        $this->load->view('templates/footer');
    }

    // Search and filter articles
    public function filter_news_articles()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Get filter values from GET request
        $filters = [];
        if ($this->input->get('title')) {
            $filters['title'] = $this->input->get('title');
        }
        if ($this->input->get('journalist')) {
            $filters['journalist'] = $this->input->get('journalist');
        }
        if ($this->input->get('category')) {
            $filters['category'] = $this->input->get('category');
        }
        if ($this->input->get('date')) {
            $filters['date'] = $this->input->get('date');
        }

        $data['news_articles'] = $this->News_model->filter_news_articles($filters);
        $data['categories'] = $this->News_model->get_all_categories();


        $this->load->view('templates/header');
        $this->load->view('dashboards/admin/view_news_articles', $data);
        $this->load->view('templates/footer');
    }

    // Get spreadsheet of news article data
    public function export_news_articles_to_excel()
    {
        $this->load->model('News_model');

        require_once FCPATH . 'vendor/autoload.php';  // Include autoload for PhpSpreadsheet

        $filters = [];
        if ($this->input->get('title')) {
            $filters['title'] = $this->input->get('title');
        }
        if ($this->input->get('journalist')) {
            $filters['journalist'] = $this->input->get('journalist');
        }
        if ($this->input->get('category')) {
            $filters['category'] = $this->input->get('category');
        }
        if ($this->input->get('date')) {
            $filters['date'] = $this->input->get('date');
        }

        $news_articles = $this->News_model->get_submitted_news($filters);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $news_articles  = $this->News_model->get_submitted_news($filters);

        // Set header for Excel sheet
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Title');
        $sheet->setCellValue('C1', 'Content');
        $sheet->setCellValue('D1', 'Journalist');
        $sheet->setCellValue('E1', 'Category');
        $sheet->setCellValue('F1', 'Tags');
        $sheet->setCellValue('G1', 'Submission Date');
        $sheet->setCellValue('H1', 'Status');

        // Fill in article data
        $row = 2;
        foreach ($news_articles as $article) {
            $sheet->setCellValue('A' . $row, $article['id']);
            $sheet->setCellValue('B' . $row, $article['title']);
            $sheet->setCellValue('C' . $row, $article['content']);
            $sheet->setCellValue('D' . $row, $article['first_name'] . ' ' . $article['last_name']);
            $sheet->setCellValue('E' . $row, $article['category_name']);
            $sheet->setCellValue('F' . $row, $article['tag_names']);
            $sheet->setCellValue('G' . $row, $article['updated_at']);
            $sheet->setCellValue('H' . $row, $article['status']);
            $row++;
        }

        // File properties and download
        $filename = 'news_articles_list_' . date('Y-m-d_H-i-s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        exit();
    }

    // Get pdf of news article data
    public function export_news_articles_to_pdf()
    {
        $this->load->model('News_model');
        $this->load->library('pdf');

        $filters = [];
        if ($this->input->get('title')) {
            $filters['title'] = $this->input->get('title');
        }
        if ($this->input->get('journalist')) {
            $filters['journalist'] = $this->input->get('journalist');
        }
        if ($this->input->get('category')) {
            $filters['category'] = $this->input->get('category');
        }
        if ($this->input->get('date')) {
            $filters['date'] = $this->input->get('date');
        }

        // Fetch data for the table
        $data['news_articles'] = $this->News_model->get_submitted_news($filters);

        // Load the view as HTML
        $html = $this->load->view('dashboards/admin/news_articles_pdf', $data, true);

        // // Load Dompdf
        // require_once FCPATH . 'vendor/autoload.php';
        // $dompdf = new \Dompdf\Dompdf();

        // // Load HTML content into Dompdf
        // $dompdf->loadHtml($html);

        // // Set paper size and orientation (e.g., A4, landscape)
        // $dompdf->setPaper('A4', 'landscape');

        // // Render PDF
        // $dompdf->render();

        // // Output PDF to browser
        // $dompdf->stream("news_articles_list_" . date('Y-m-d_H-i-s') . ".pdf", ["Attachment" => 1]);
        $this->pdf->createPDF($html, 'news_articles_list_' . date('Y-m-d_H-i-s') . '.pdf');
    }


    // Get journalists report by admin
    public function get_all_journalists()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $filters = [];
        if ($this->input->get('journalist')) {
            $filters['journalist'] = $this->input->get('journalist');
        }
        if ($this->input->get('date')) {
            $filters['date'] = $this->input->get('date');
        }

        $data['journalists'] = $this->News_model->get_journalists_report($filters);

        $this->load->view('templates/header');
        $this->load->view('dashboards/admin/view_all_journalists', $data);
        $this->load->view('templates/footer');
    }

    public function export_journalists_to_excel()
    {
        $this->load->model('News_model');

        require_once FCPATH . 'vendor/autoload.php';  // Include autoload for PhpSpreadsheet

        // Get filter parameters if any
        $filters = [];
        if ($this->input->get('journalist')) {
            $filters['journalist'] = $this->input->get('journalist');
        }
        if ($this->input->get('date')) {
            $filters['date'] = $this->input->get('date');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Pass filters to get filtered journalists
        $journalists  = $this->News_model->get_journalists_report($filters);

        // Set header for Excel sheet
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Journalist');
        $sheet->setCellValue('C1', 'Article Count');
        $sheet->setCellValue('D1', 'Latest Submission Date');
        $sheet->setCellValue('E1', 'Status');

        // Fill in article data
        $row = 2;
        foreach ($journalists as $journalist) {
            $sheet->setCellValue('A' . $row, $journalist['id']);
            $sheet->setCellValue('B' . $row, $journalist['first_name'] . ' ' . $journalist['last_name']);
            $sheet->setCellValue('C' . $row, $journalist['article_count']);
            $sheet->setCellValue('D' . $row, $journalist['latest_submission_date']);
            $sheet->setCellValue('E' . $row, $journalist['is_active']);
            $row++;
        }

        // File properties and download
        $filename = 'journalists_list_' . date('Y-m-d_H-i-s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        exit();
    }


    // Get pdf of journalists data
    public function export_journalists_to_pdf()
    {
        $this->load->model('News_model');
        $this->load->library('pdf');

        $filters = [];
        if ($this->input->get('journalist')) {
            $filters['journalist'] = $this->input->get('journalist');
        }
        if ($this->input->get('date')) {
            $filters['date'] = $this->input->get('date');
        }

        // Fetch data for the table
        $data['journalists'] = $this->News_model->get_journalists_report($filters);

        // Load the view as HTML
        $html = $this->load->view('dashboards/admin/journalists_pdf', $data, true);

        $this->pdf->createPDF($html, 'journalists_list_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
