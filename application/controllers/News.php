<?php
class News extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['News_model', 'User_model']);
        $this->load->helper(['url_helper', 'form', 'text']);
        $this->load->library(['form_validation', 'session', 'pagination']);
    }

    // Get all news articles to Homepage
    public function index()
    {
        $data['news'] = $this->News_model->get_published_news();

        if (empty($data['news'])) {
            show_404();
        }


        // // Configuration for pagination
        // $config['base_url'] = site_url('news/index');
        // $config['total_rows'] = $this->News_model->get_total_news();
        // $config['per_page'] = 9; // Number of news items per page

        // // Bootstrap 4 pagination styling
        // $config['full_tag_open'] = '<ul class="pagination">';
        // $config['full_tag_close'] = '</ul>';
        // $config['first_link'] = '&laquo;';
        // $config['first_tag_open'] = '<li class="page-item">';
        // $config['first_tag_close'] = '</li>';
        // $config['last_link'] = '&raquo;';
        // $config['last_tag_open'] = '<li class="page-item">';
        // $config['last_tag_close'] = '</li>';
        // $config['next_link'] = '&rsaquo;';
        // $config['next_tag_open'] = '<li class="page-item">';
        // $config['next_tag_close'] = '</li>';
        // $config['prev_link'] = '&lsaquo;';
        // $config['prev_tag_open'] = '<li class="page-item">';
        // $config['prev_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        // $config['cur_tag_close'] = '</a></li>';
        // $config['num_tag_open'] = '<li class="page-item">';
        // $config['num_tag_close'] = '</li>';
        // $config['attributes'] = array('class' => 'page-link');

        // $this->pagination->initialize($config);

        // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // $data['news'] = $this->News_model->get_published_news($config['per_page'], $page);
        // $data['pagination'] = $this->pagination->create_links();

        $this->load->view('templates/header');
        $this->load->view('pages/home', $data);
        $this->load->view('templates/footer');
    }

    // AJAX method to load news
    // public function load_news()
    // {
    //     if (!$this->input->is_ajax_request()) {
    //         exit('No direct script access allowed');
    //     }

    //     $page = $this->input->get('page') ? $this->input->get('page') : 0;
    //     $per_page = 9;

    //     $news = $this->News_model->get_published_news($per_page, $page);
    //     $total_rows = $this->News_model->get_total_news();

    //     $response = [
    //         'news' => $news,
    //         'total_pages' => ceil($total_rows / $per_page),
    //         'current_page' => $page
    //     ];

    //     header('Content-Type: application/json');
    //     echo json_encode($response);
    // }

    // View a single published news by logged in reader
    public function view_single($slug)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['news_item'] = $this->News_model->get_news_by_slug($slug);

        if (empty($data['news_item'])) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }


    // Get form to create a news by journalist
    public function create()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['categories'] = $this->News_model->get_all_categories();
        $data['tags'] = $this->News_model->get_all_tags();

        $this->load->view('templates/header');
        $this->load->view('news/create', $data);
        $this->load->view('templates/footer');
    }

    // Store a news by journalist
    public function store_news()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $config['upload_path'] = './uploads/news_images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            $image_path = 'uploads/news_images/' . $upload_data['file_name']; // Store the path


            $slug = url_title($this->input->post('title'), 'dash', TRUE);

            $news_data = [
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'category_id' => $this->input->post('category'),
                'tag_id' => $this->input->post('tag'),
                'status' => 'pending', // Default status
                'journalist_id' => $this->session->userdata('user_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'slug' => $slug,
                'image' => $image_path // Store image path in the database
            ];

            if ($this->News_model->insert_article($news_data)) {
                $this->session->set_flashdata('success', 'News article submitted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to submit news article.');
            }
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }

        redirect('dashboard');
    }

    // View a single news by journalist
    public function view_news($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $news_item = $this->News_model->get_news_by_id($id);

        if (empty($news_item)) {
            show_404();
        }

        $data = [
            'news_item' => $news_item,
        ];

        $this->load->view('templates/header');
        $this->load->view('dashboards/journalist/view_news', $data);
        $this->load->view('templates/footer');
    }

    // View edit form of a news article by journalist
    public function edit_news_form($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $news_item = $this->News_model->get_news_by_id($id);
        $categories = $this->News_model->get_all_categories();
        $tags = $this->News_model->get_all_tags();

        if (!$news_item) {
            show_404();
        }

        $data = [
            'news_item' => $news_item,
            'categories' => $categories,
            'tags' => $tags,
        ];

        $this->load->view('templates/header');
        $this->load->view('dashboards/journalist/edit_news', $data);
        $this->load->view('templates/footer');
    }

    public function update_news($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Content', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['validation_errors'] = validation_errors();  // Capture the validation errors
            $data['news_item'] = $this->News_model->get_news_by_id($id);
            $data['categories'] = $this->News_model->get_all_categories();
            $data['tags'] = $this->News_model->get_all_tags();


            // $this->load->view('dashboards/journalist/edit_news', $data);
        } else {
            $title = $this->input->post('title');
            $content = $this->input->post('content');
            $category_id = $this->input->post('category');
            $tag_id = $this->input->post('tag');

            $image_path = NULL;
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/news_images/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $image_path = 'uploads/news_images/' . $upload_data['file_name'];
                } else {
                    $data['upload_error'] = $this->upload->display_errors();
                    $this->edit_news_form($id);
                    return;
                }
            }

            $news_data = [
                'title' => $title,
                'content' => $content,
                'category_id' => $category_id,
                // 'tag_id' => $tag_id,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($image_path) {
                $news_data['image'] = $image_path;
            }

            $this->load->model('News_model');
            $updated = $this->News_model->update_news($id, $news_data, $tag_id);

            if ($updated) {
                $this->session->set_flashdata('success', 'News article updated successfully.');
                // redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Failed to update the news article.');
                // redirect('journalist/edit_news_form/' . $id);
            }

            redirect('news/view_news/' . $id);
        }
    }


    // Delete a news article by journalist
    public function delete_news_article($id)
    {
        if ($this->News_model->delete_news_article($id)) {
            $this->session->set_flashdata('success', 'News article deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete news article.');
        }
        redirect('dashboard');
    }

    // View single news for reviewing by editor
    public function review_news($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['news_item'] = $this->News_model->get_single_submitted_news($id);

        if (empty($data['news_item'])) {
            echo "Article not found for ID: " . $id;
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('dashboards/editor/review_news', $data);
        $this->load->view('templates/footer');
    }


    // Review news_article by editor
    public function review_news_article()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $news_id = $this->input->post('news_id');
        $action = $this->input->post('action');

        if ($action === 'approve') {
            $status = 'approved';
        } elseif ($action === 'reject') {
            $status = 'rejected';
        } else {
            redirect('dashboard');
        }

        // Update news status
        $this->load->model('News_model');
        $this->News_model->update_news_status($news_id, $status);

        $this->session->set_flashdata('success', 'News article has been ' . $status . '.');
        redirect('dashboard');
    }

    public function download_pdf($id)
    {
        $this->load->library('pdf');

        $data['news_item'] = $this->News_model->get_single_submitted_news($id);

        if (empty($data['news_item'])) {
            show_404();
        }

        $html = $this->load->view('dashboards/editor/news_pdf', $data, true);

        $this->pdf->createPDF($html, 'news_article_' . $id . '.pdf');
    }

    // Publish the article by journalist
    public function publish($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model('News_model');

        $update_data = array(
            'status' => 'published'
        );

        $this->News_model->update_news_status_to_published($id, $update_data);

        $this->session->set_flashdata('success', 'News article has been ' . $update_data['status'] . '.');
        redirect('dashboard');
    }

    // Get headlines to be viewed in Homepage
    public function fetch_latest_headline()
    {
        $latest_news = $this->News_model->get_latest_news();

        if ($latest_news) {
            echo json_encode($latest_news);
        } else {
            echo json_encode([]);
        }
    }

    // Get news viewed accroding to their category
    public function view_category($category)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['news'] = $this->News_model->get_all_news_by_category($category);
        $data['category'] = ucfirst($category);

        $this->load->view('templates/header');
        $this->load->view('pages/news_categories', $data);
        $this->load->view('templates/footer');
    }
}
