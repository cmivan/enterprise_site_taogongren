<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "index";
$route['404_override'] = ""; //重定向404页面

//$route['scaffolding_trigger'] = "admin";


$route['index']      = "index/index";
$route['user/(\d+)'] = "user/info/$1";
$route['retrieval/view/(\d+)'] = "retrieval/view/$1";
//for company
$route['company/(\d+)'] = "company/index/$1";
//$route['company/(\d+)/about'] = "company/index/$1/about";
$route['company/v(\d+)_([a-z]+)'] = "company/$2/$1";


$route['about'] = "page/about";
$route['agreement'] = "page/agreement";
$route['projects'] = "page/projects";
$route['payment'] = "page/payment";
$route['statement'] = "page/statement";
$route['help'] = "page/help";


/* End of file routes.php */
/* Location: ./application/config/routes.php */