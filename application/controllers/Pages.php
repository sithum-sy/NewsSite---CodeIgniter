<?php
class Pages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('text');
    }

    // Homepage view
    public function view($page = 'contact')
    {

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        // $data['news'] = $this->News_model->get_published_news();

        $this->load->view('templates/header');
        $this->load->view('pages/' . $page);
        $this->load->view('templates/footer');
    }
}
