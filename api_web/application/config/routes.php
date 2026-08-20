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

  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */

// $route['default_controller'] = 'Api/Auth';
$route['default_controller'] = 'api/auth';
$route['api/auth/register'] = 'api/auth/register';
$route['api/auth/login'] = 'api/auth/login'; // t

// $route['api/service/(:any)'] = 'api/service/';
// $route['api/service/get'] = 'api/service/get/$1';
// $route['api/service/all'] = 'api/service/all';
// $route['api/service/mine'] = 'api/service/mine';
// $route['api/service/(:num)']['put'] = 'api/service/update/$1';

// $route['api/booking/accept/(:num)'] = 'api/booking/accept/$1';
// $route['api/booking/reject/(:num)'] = 'api/booking/reject/$1';
// $route['api/booking/start/(:num)'] = 'api/booking/start/$1';
// $route['api/booking/complete/(:num)'] = 'api/booking/complete/$1';
// $route['api/booking/confirm_done/(:num)'] = 'api/booking/confirm_done/$1';
// $route['api/booking/my'] = 'api/booking/list_by_user';
// $route['api/booking/update_status'] = 'api/booking/update_status';
// $route['api/booking/cancel']        = 'api/booking/cancel';          // POST
// $route['api/booking/review']        = 'api/booking/review';          // POST
// $route['api/booking/list_by_user'] = 'api/booking/list_by_user';
// $route['api/booking/list_by_client'] = 'api/booking/list_by_client';
// $route['api/booking/list_by_provider'] = 'api/booking/list_by_provider';

// $route['api/service/byProvider/(:num)'] = 'api/service/byProvider/$1';

// $route['admincp'] = 'admincp/order';
// $route['pray'] = 'pray';
// $route['donate'] = 'index/donate';
// $route['danh-muc/(:any)'] = 'index/category/$1/1';
// $route['danh-muc/(:any)/(:num)'] = 'index/category/$1/$2';
// $route['tim-kiem'] = 'index/search';
// $route['san-pham/(:any)-(:num).html'] = 'index/product/$2';
// $route['san-pham/(:any)-(:num).htm'] = 'index/product/$2';
// $route['gio-hang.html'] = 'index/cart';
// $route['dat-hang-thanh-cong.html'] = 'index/finish_order';
$route['(:any).html'] = 'index/page/$1';
$route['test.html'] = 'index/test';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
