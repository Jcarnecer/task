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
$route['default_controller'] = 'site';

$route['tasks'] = 'tasks/index';

# personal tasks
$route['tasks/create'] = 'tasks/create';
$route['tasks/view/(:any)'] = 'tasks/view/$1';
$route['tasks/done/(:any)'] = 'tasks/mark_as_done/$1';

$route['tasks/(:any)/tags/add'] = 'tags/add_tag/$1';
$route['tasks/(:any)/tags/del'] = 'tags/del_tag/$1';

$route['tasks/(:num)/notes/create'] = 'task_notes/create/$1';

# users



# team tasks
$route['tasks/team/create'] = 'team_tasks/create_task';
$route['tasks/team/view/(:any)'] = 'team_tasks/view_task/$1';

$route['tasks/team/(:num)/notes/create'] = 'task_notes/create_team_task_note/$1';

$route['api/task/(:any)']['POST'] = 'tasks/post/$1';
$route['api/task/(:any)']['GET'] = 'tasks/get/$1';

$route['api/task']['POST'] = 'tasks/post';
$route['api/task']['GET'] = 'tasks/get';

$route['api/done/(:any)']['POST'] = 'tasks/mark_as_done/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
