<?php

class AuthMiddleware
{
    // public function checkAuth()
    // {
    //     $CI = &get_instance(); // Get the CodeIgniter instance

    //     if ($CI === null) {
    //         log_message('error', 'CodeIgniter instance is null in AuthMiddleware.');
    //         show_error('An unexpected error occurred. Please contact support.', 500);
    //         return;
    //     }

    //     $CI->load->library('session');
    //     $CI->load->helper('url');

    //     // Exclude specific pages from authentication check
    //     $excluded_routes = ['home', 'about', 'contact', 'login', 'register']; // Add routes you want to exclude
    //     $current_route = $CI->uri->segment(1); // Get the first segment of the URI

    //     if (in_array($current_route, $excluded_routes)) {
    //         return; // Skip auth check for excluded routes
    //     }

    //     // Debug session variable
    //     log_message('error', 'Session logged_in value: ' . print_r($CI->session->userdata('logged_in'), TRUE));

    //     // Check if the user is logged in
    //     if (!$CI->session->userdata('logged_in')) {
    //         redirect('login'); // Redirect to login page if not authenticated
    //     }
    // }
}
