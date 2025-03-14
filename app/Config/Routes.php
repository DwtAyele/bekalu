<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories. 
$routes->match(['get', 'post'], '/', 'Search::index'); 


$routes->match(['get', 'post'], 'kalat', 'Search::searchword');
$routes->get('kalat', 'Search::index');
$routes->match(['get', 'post'], 'search', 'Search::searchword');


$routes->get('admin', 'Home::index');
$routes->get('home', 'Home::index');
$routes->match(['get', 'post'], 'login', 'Users::index');
$routes->match(['get', 'post'], 'register', 'Users::register');
$routes->match(['get', 'post'], 'forgotpassword', 'Users::forgotpassword');
$routes->match(['get', 'post'], 'recoverpassword', 'Users::recoverpassword');
$routes->get('lockscreen', 'Users::lockscreen');
$routes->get('signout', 'Users::signout');
$routes->match(['get', 'post'], 'profile', 'Users::profile');

$routes->match(['get', 'post'], 'addmeaning', 'Meaning::addmeaning');
$routes->match(['get', 'post'], 'import', 'Meaning::importdata');

$routes->match(['get', 'post'], 'dictionarylist', 'Dictionary::dictionarylist');
$routes->match(['get', 'post'], 'dictionarypage/(:num)', 'Dictionary::dictionarypage/$1');
$routes->match(['get', 'post'], 'dictionarypage/(:segment)/(:num)', 'Dictionary::dictionarypage/$1/$2');

$routes->match(['get', 'post'], 'wordmeaninglist', 'Meaning::wordmeaninglist');
$routes->match(['get', 'post'], 'edit/(:num)', 'EditMeaning::edit/$1');
$routes->match(['get', 'post'], 'edit/(:num)/(:num)', 'EditMeaning::edit/$1/$2');
$routes->match(['get', 'post'], 'edit', 'EditMeaning::update');
$routes->match(['get', 'post'], 'update', 'EditMeaning::update');


$routes->match(['get', 'post'], 'mywiki', 'Home::mywiki');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
