<?php

class Journalists extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'News_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // public function view_articles_by_journalist($journalist_id)
    // {

    //     $journalist_id = $this->session->userdata('journalist_id');
    //     $data['news_articles'] = $this->News_model->get_articles_by_journalist($journalist_id);

    //     $this->load->view('dashboards/journalist-dashboard', $data);
    // }


    public function add_news()
    {
        $this->load->model('News_model');

        $data = [
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'category_id' => $this->input->post('category'),
            'created_by' => $this->session->userdata('user_id'),
            'status' => 'pending'
        ];

        $tags = explode(',', $this->input->post('tags')); // Handle tags

        $this->News_model->add_news_article($data, $tags);
        $this->session->set_flashdata('success', 'News article submitted for approval.');
        redirect('dashboard');
    }
}
