<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| FRONT END ROUTES
| -------------------------------------------------------------------------
*/

$route['learn-more'] = 'pages/about';

$route['projects'] = 'projects';

$route['projects/create'] = 'projects/projects/';
$route['projects/(:num)/details'] = 'projects/view/';
// $route['projects/(:any)'] = 'projects/view/';
$route['projects/(:num)/pledge'] = 'projects/pledge/$1';


// Payment Section
$route['payments/(:num)/(:any)'] = 'projects/payment/$1';
// $route['projects/(:num)/payments/(:any)/checkout/(:any)'] = 'projects/payment/$1';

/*
| -------------------------------------------------------------------------
| AUTHENTICATION ROUTES
| -------------------------------------------------------------------------
*/
$route['auth/login'] = 'auth/login';

/*
| -------------------------------------------------------------------------
| USER DASHBOARD ROUTES
| -------------------------------------------------------------------------
*/

$route['greenies/(:any)'] = 'greenies/show_dashboard';
$route['greenies/(:any)/projects'] = 'dashboard/projects/index';
$route['projects/create'] = 'dashboard/projects/plant';
$route['projects/(:any)/edit/(:any)'] = 'dashboard/projects/plant_continue/$1';
$route['greenies/(:any)/backed-projects'] = 'greenies/get_backed_projects';
$route['greenies/(:any)/projects/(:num)/backers'] = 'dashboard/projects/get_backers/';


/*
| -------------------------------------------------------------------------
| AJAX REQUEST ROUTES
| -------------------------------------------------------------------------
*/
$route['projects/store'] = 'dashboard/projects/ajx_plant_project'; // saving a new project
$route['projects/save'] = 'dashboard/projects/ajx_save_project'; // saving a new project

/*
| -------------------------------------------------------------------------
| ADMIN PANEL ROUTES
| -------------------------------------------------------------------------
*/

$route['g-admin'] = 'panel/base'; // show the index 
$route['g-admin/auth/login'] = 'panel/sessions/login'; // show the index 
$route['g-admin/project-management'] = 'panel/projects'; // project management
$route['g-admin/project-management/projects/(:num)/pitch'] = 'panel/projects/show_pitch/$1'; // project pitch
$route['g-admin/projects/ajx_accept'] = 'panel/projects/accept_project'; // accept projects


//fucked up routes 
$route['projects/upload'] = 'dashboard/projects/summernote';


$route['projects/tinymce/upload'] = 'dashboard/projects/tinymce';



$route['projects/upload/process'] = 'dashboard/projects/summernote_process_upload';

