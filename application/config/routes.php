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
$route['default_controller'] = 'Views/personal';
$route['tasks'] = 'Views/personal';
// $route['tasks'] = 'tasks/index';

# view
$route['personal'] = 'Views/personal';
$route['team/(:any)'] = 'Views/team/$1';


# API
# user
$route['api/user/(:any)']['GET'] = 'users/get/$1';

# team
$route['api/team']['POST'] = 'Teams/post';
$route['api/team']['GET'] = 'Teams/get';

$route['api/team/(:any)']['POST'] = 'Teams/post/$1';
$route['api/team/(:any)']['GET'] = 'Teams/get/$1';


$route['api/validate_member/(:any)']['POST'] = 'teams/validate_member/$1';
$route['api/validate_member']['POST'] = 'teams/validate_member';

$route['api/leave_team/(:any)']['POST'] = 'Teams/leave_team/$1';

# board
$route['api/board/(:any)']['POST'] = 'boards/post_board/$1';
$route['api/board/(:any)']['GET'] = 'boards/get_board/$1';

$route['api/board/(:any)/(:any)']['POST'] = 'boards/post_board/$1/$2';
$route['api/board/(:any)/(:any)']['GET'] = 'boards/get_board/$1/$2';

$route['api/column/(:any)']['POST'] = 'boards/post_column/$1';
$route['api/column/(:any)']['GET'] = 'boards/get_column/$1';

$route['api/column/(:any)/(:any)']['POST'] = 'boards/post_column/$1/$2';
$route['api/column/(:any)/(:any)']['GET'] = 'boards/get_column/$1/$2';

$route['api/delete_column/(:any)']['POST'] = 'boards/delete_column/$1';

$route['api/update_columns']['POST'] = 'boards/change_columns_position';

# task
$route['api/task/(:any)']['POST'] = 'Tasks/post/$1';
$route['api/task/(:any)']['GET'] = 'Tasks/get/$1';

$route['api/task/(:any)/(:any)']['POST'] = 'Tasks/post/$1/$2';
$route['api/task/(:any)/(:any)']['GET'] = 'Tasks/get/$1/$2';

$route['api/note/(:any)']['POST'] = 'Tasks/post_notes/$1';
$route['api/note/(:any)']['GET'] = 'Tasks/get_notes/$1';

$route['api/done/(:any)']['POST'] = 'Tasks/mark_as_done/$1';

$route['api/change_column/(:any)']['POST'] = 'Tasks/change_column/$1';

$route['api/get_user_team_task/(:any)']['GET'] = 'Tasks/get_user_team_task/$1';
# end-of-API


# other
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;