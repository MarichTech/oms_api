<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'students';

//Login Routes

//Student routes
$route['students/add'] = 'students/add_student';
$route['students/import'] = 'students/importStudents';
$route['students/update'] = 'students/update';
$route['students/(:any)'] = 'students/get_students/$1';
$route['students/edit/(:any)'] = 'students/get_student/$1';

$route['students/delete/(:any)'] = 'students/delete_student/$1';
////-


//Accounts routes
$route['accounts/create'] = 'accounts/create';
$route['accounts/update'] = 'accounts/update';
$route['accounts/(:any)'] = 'accounts/user_accounts/$1';
$route['accounts/edit/(:any)'] = 'accounts/get_account/$1';

$route['accounts/delete/(:any)'] = 'accounts/delete/$1';
////-------------------------------------

//Opportunity routes
$route['opportunities/create'] = 'opportunities/create';
$route['opportunities/update'] = 'opportunities/update';
$route['opportunities/(:any)'] = 'opportunities/account_opportunities/$1';
$route['opportunities/edit/(:any)'] = 'opportunities/get_opportunity/$1';
$route['opportunities/delete/(:any)'] = 'opportunities/delete/$1';
////--------------------------------------


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
