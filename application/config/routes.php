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
|	https://codeigniter.com/user_guide/general/routing.html
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

// #GRN ROUTE
// $route['grn'] = 'grn/daftar';
// $route['grn/(:any)'] = 'grn/daftar/$1';
// $route['grn/(:any)/(:any)'] = 'grn/daftar/$1/$2';

// #GRD ROUTE
// $route['grd'] = 'grd/daftar';
// $route['grd/(:any)'] = 'grd/daftar/$1';
// $route['grd/(:any)/(:any)'] = 'grd/daftar/$1/$2';

// #EXECUTE ROUTE
// $route['execute/(:any)/(:any)'] = 'execute/process/$1/$2';
// $route['execute/(:any)/(:any)/(:any)'] = 'execute/process/$1/$2/$3';

#REPORT ROUTE
// $route['laporan/pemasukan-bahan-baku'] = 'report/pemasukan_bb';
$route['api/user/login'] = 'api/users/login';