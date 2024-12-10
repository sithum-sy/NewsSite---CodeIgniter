<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['home'] = 'pages/view/home';
$route['about'] = 'pages/view/about';
$route['contact'] = 'pages/view/contact';


$route['login'] = 'users/login';
$route['logout'] = 'users/logout';
$route['dashboard'] = 'users/view';
$route['register'] = 'users/load_register';
$route['registerUser'] = 'users/register_user';
$route['toggleUserStatus'] = 'users/toggle_user_status';

$route['news/create'] = 'news/create';
$route['news/store'] = 'news/store_news';
$route['news/(:any)'] = 'news/view_single/$1';
$route['news'] = 'news';
// $route['(:any)'] = 'pages/view/$1';

$route['journalist/news/(:num)'] = 'news/view_news/$1';
$route['journalist/publish/(:num)'] = 'news/publish/$1';
$route['editor/news/(:num)'] = 'news/review_news/$1';
$route['editor/news/review'] = 'news/review_news_article';
$route['editor/news/download_pdf/(:num)'] = 'news/download_pdf/$1';


$route['default_controller'] = 'pages/view';
