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
-|
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
$route['default_controller'] = 'Views/personal';
$route['tasks'] = 'Views/personal';
// $route['tasks'] = 'tasks/index';

# view
$route['personal']                              = 'Views/personal';
$route['project/(:any)']                           = 'Views/project/$1';

# API
# user
$route['api/user/(:any)']['GET']                = 'Users/get/$1';

# project
$route['api/project/get']['GET']                = 'Projects/get';
$route['api/project/insert']['POST']            = 'Projects/insert';
$route['api/project/update']['POST']            = 'Projects/update';
$route['api/project/leave']['POST']             = 'Projects/leave_project';
$route['api/validate_member']['POST']           = 'Projects/validate_member';

# board
$route['api/board/get']['GET']                  = 'Boards/get_board_by_project';
$route['api/board/insert']['POST']              = 'Boards/insert_board';

$route['api/column/get']['GET']                 = 'Boards/get_column';
$route['api/column/get_all']['GET']             = 'Boards/get_all_columns';
$route['api/column/insert']['POST']             = 'Boards/insert_column';
$route['api/column/update']['POST']             = 'Boards/update_column';
$route['api/column/delete']['POST']             = 'Boards/delete_column';
$route['api/column/change_position']['POST']    = 'Boards/update_many_columns';

# task
$route['api/task/get']['GET']                   = 'Tasks/get';
$route['api/task/get_all']['GET']               = 'Tasks/get_all';
$route['api/task/get_user_task']['GET']         = 'Tasks/get_task_by_actor';
$route['api/task/insert']['POST']               = 'Tasks/insert';
$route['api/task/update']['POST']               = 'Tasks/update';
$route['api/task/archive']['POST']              = 'Tasks/archive';
$route['api/task/change_column']['POST']        = 'Tasks/change_column';
# end-of-API


# other
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;