<?php
class News extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['news'] = $this->News_model->get_news();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('pages/home', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['news_item'] = $this->News_model->get_news($slug);

        // If the news item doesn't exist, show 404 error
        if (empty($data['news_item'])) {
            show_404();
        }

        // Pass the news item data and title
        $data['title'] = $data['news_item']['title'];

        // Load the views
        $this->load->view('templates/header', $data);
        $this->load->view('news/view', $data);  // Assuming you have a view.php for a single article
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create');
            $this->load->view('templates/footer');
        } else {
            $this->News_model->set_news();
            $this->load->view('templates/header', $data);
            $this->load->view('news/success');
            $this->load->view('templates/footer');
        }
    }
}
