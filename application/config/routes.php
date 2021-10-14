<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'accounts/1';

//Word
$route['gen'] = 'gen/index';

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
