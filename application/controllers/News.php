<?php
class News extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->model('User_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function view()
    {
        $data['news'] = $this->News_model->get_published_news();

        if (empty($data['news'])) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['categories'] = $this->News_model->get_all_categories();
        $data['tags'] = $this->News_model->get_all_tags();

        $this->load->view('news/create', $data);
    }


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

    // View a single news from a journalist
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

        $this->load->view('dashboards/journalist/view_news', $data);
    }

    // View single news for reviewing by editor
    public function review_news($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Debug the `id` being passed
        // echo "ID Passed: " . $id;
        // echo "<br>";

        $data['news_item'] = $this->News_model->get_single_submitted_news($id);

        if (empty($data['news_item'])) {
            echo "Article not found for ID: " . $id;
            show_404();
        }

        $this->load->view('dashboards/editor/review_news', $data);
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
        $this->load->model('News_model');
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
}
