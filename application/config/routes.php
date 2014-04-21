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

// Home page
$route['default_controller'] = 'browse/index';

// Grid refreshing
$route['ajax/grid'] = 'browse/grid';

// View video at each of the levels
$route['(:any)/(:any)/(:any)/watch/(:any)/(:num)'] = 'browse/watch/$1/$2/$3/$4/$5';
$route['(:any)/(:any)/watch/(:any)/(:num)'] = 'browse/watch/$1/$2/$3/$4';
$route['search/watch/(:any)/(:num)'] = 'browse/search/$1/$2/$3';
$route['(:any)/watch/(:any)/(:num)'] = 'browse/watch/$1/$2/$3';
$route['watch/(:any)/(:num)'] = 'browse/watch/$1/$2';

// Comments
$route['comments/get'] = 'comments/get';
$route['comments/post'] = 'comments/post';
$route['comments/flag'] = 'comments/flag';

//Admin: Manage hierachy.xml used to create/modify page taxonomy.
$route['admin/index'] = 'admin/index';
$route['admin/get'] = 'admin/get';
$route['admin/post'] = 'admin/post';
$route['admin/proxy'] = 'admin/proxy';
$route['admin/validatelineupids'] = 'admin/validatelineupids';


//Moderation
$route['moderation/index'] = 'moderation/index';
$route['moderation/delete/(:num)'] = 'moderation/delete/$1';
$route['moderation/clear/(:num)'] = 'moderation/clear/$1';


// Ratings
$route['ratings/rate'] = 'ratings/rate';
$route['ratings/get'] = 'ratings/get';

// Video forwarder
$route['watch/(:num)'] = 'browse/forward/$1';

// Search
$route['search/(:any)/(:num)'] = 'browse/search/$1/$2';
$route['search'] = 'browse/search';

// Browsing at each of the levels
$route['(:any)/(:any)/(:any)'] = 'browse/index/$1/$2/$3';
$route['(:any)/(:any)'] = 'browse/index/$1/$2';
$route['(:any)'] = 'browse/index/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */