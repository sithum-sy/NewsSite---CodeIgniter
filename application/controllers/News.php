<?php
class News extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News archive';

        $this->load->view('templates/header', $data);
        $this->load->view('pages/home', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['news_item'] = $this->news_model->get_news($slug);

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
}
