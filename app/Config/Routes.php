<?php

namespace Config;

use App\Controllers\Admin\users;
use App\Controllers\Customer;
use App\Controllers\Home;
use App\Controllers\Penjualan;
use CodeIgniter\Commands\Utilities\Routes;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(false); 

/*$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] =  FALSE;

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/','Home::index');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

// $routes->get('/coba/(:any)/(:num)', 'Home::about/$1/$2');
$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
$routes->get('coba2/(:uuid)', function ($uuid){
    echo "UUID: $uuid";
}
);

$routes->get('/coba', function()
{
    echo 'Hello World';
});

$routes->get('/', 'Auth::indexlogin');
$routes->get('/coba/(:any)/(:num)', 'Home::about/$1/$2');
$routes->get('/contact','Home::about');
$routes->get('/Tugascontainer','Home::Tugascontainer');
$routes->get('/Tugas2','Tugas2::index');
// $routes->get('admin/Tugas2','Home::\Tugas2\index');
// $routes->get('/users', 'Admin\Users::index');
// $routes->get('/master', 'Admin\Master::index');

//--------------------------------------------------//

$routes->get('/', 'Home::index', ['filter' => 'role:Admin, Owner, Manajer, Karyawan']);
$routes->get('/book', 'Book::index');
$routes->get('/book/create', 'Book::create');
$routes->post('/book/create', 'Book::save');
$routes->get('/book/edit/(:any)', 'Book::edit/$1');
$routes->post('/book/edit/(:any)', 'Book::update/$1');
$routes->get('/book/(:any)', 'Book::detail/$1');
$routes->delete('/book/(:num)', 'Book::delete/$1');
$routes->post('/book/import', 'Book::importData');

//-------------------------------------------------//
$routes->get('/', 'Home::index', ['filter' => 'role:Admin, Owner, Karyawan, Manajer']);
$routes->get('/komik', 'Komik::index');
$routes->get('/komik/create', 'Komik::create');
$routes->post('/komik/create', 'Komik::save');
$routes->get('/komik/edit/(:any)', 'Komik::edit/$1');
$routes->post('/komik/edit/(:any)', 'Komik::update/$1');
$routes->get('/komik/(:any)', 'Komik::detail/$1');
$routes->delete('/komik/(:num)', 'Komik::delete/$1');
$routes->post('/komik/import', 'Komik::importData');

//-------------------------------------------------//

$routes->get('/customer/index', 'Customer::index', ['filter' => 'role:Admin, Owner, Manajer']);
$routes->addRedirect('/customer', '/customer/index')->get('/customer/index', 'Customer::index')->setAutoRoute(true);

//-------------------------------------------------//

$routes->get('/supplier/index', 'Supplier::index', ['filter' => 'role:Manajer, Owner']);
$routes->addRedirect('/supplier', '/supplier/index')->get('/supplier/index', 'Supplier::index')->setAutoRoute(true);

//-------------------------------------------------//

$routes->get('/mahasiswa_1553/index', 'Mahasiswa_1553::index');
$routes->addRedirect('/mahasiswa_1553', '/mahasiswa_1553/index')->get('/mahasiswa_1553/index', 'Mahasiswa_1553::index')->setAutoRoute(true);

//------------------------------------------------//

$routes->group('login', function($r){
    $r->get('/', 'Auth::indexlogin');
    $r->post('auth', 'Auth::auth');
    $r->get('register', 'Auth::indexregister');
    $r->post('save', 'Auth::saveRegister');
});
$routes->get('/logout', 'Auth::logout');

$routes->group('users', ['filter' => 'auth'], function($r) {
    $r->get('/', 'Users::index', ['filter' => 'role:Admin, Owner']);
    $r->get('index', 'Users::index');
    $r->get('create', 'Users::create');
    $r->post('create', 'Users::save');
    $r->get('edit/(:num)', 'Users::edit/$1');
    $r->post('edit/(:num)', 'Users::update/$1');
    $r->delete('(:num)', 'Users::delete/$1');
});

$routes->group('jual', ['filter' => 'auth'],function ($r)
{
    $r->get('/', 'Penjualan::index');
});

$routes->group('jual', ['filter' => 'auth'], function ($r)
{
    $r->get('/', 'Penjualan::index');
    $r->get('load', 'Penjualan::loadCart');
    $r->get('gettotal', 'Penjualan::getTotal');
    $r->post('/', 'Penjualan::addCart');
    $r->post('update', 'Penjualan::updateCart');
    $r->post('bayar', 'Penjualan::pembayaran');
    $r->delete('(:any)', 'Penjualan::deleteCart/$1');
    $r->get('laporan', 'Penjualan::report');
    $r->post('laporan/filter', 'Penjualan::filter');
    $r->get('exportpdf', 'Penjualan::exportPDF');
    $r->get('exportexcel', 'Penjualan::exportExcel');

});

$routes->group('beli', ['filter' => 'auth'], function ($r)
{
    $r->get('/', 'Pembelian::index');
    $r->get('load', 'Pembelian::loadCart');
    $r->post('/', 'Pembelian::addCart');
    $r->get('gettotal', 'Pembelian::getTotal');
    $r->post('update', 'Pembelian::updateCart');
    $r->post('bayar', 'Pembelian::pembayaran');
    $r->delete('(:any)', 'Pembelian::deleteCart/$1');
    $r->get('laporan', 'Pembelian::report');
    $r->post('laporan/filter', 'Pembelian::filter');
    $r->get('exportpdf', 'Pembelian::exportPDF');
    $r->get('cetak', 'Pembelian::cetak');
    $r->get('exportexcel', 'Pembelian::exportExcel');
    
});

$routes->get('/', 'Home::index');
//Penjualan
$routes->post('/chart-transaksi', 'Home::showChartTransaksi');
$routes->post('/chart-customer', 'Home::showChartCustomer');

//Pembelian
$routes->post('/chart-pembelian', 'Home::showChartPembelian');
$routes->post('/chart-supplier', 'Home::showChartSupplier');

// $routes->get('/book', 'Book::index');
// $routes->get('/book/create', 'Book::create');
// $routes->post('/book/create', 'Book::save');
// $routes->get('/book/(:any)', 'Book::detail/$1');


// $routes->get('/komik', 'Komik::index');
// $routes->get('/komik/create', 'Komik::create');
// $routes->post('/komik/create', 'Komik::save');
// $routes->get('/komik/(:any)', 'Komik::detail/$1');


// $routes->group('adm', function ($r){
//     $r->get('users', 'Admin\Users::index');
//     $r->get('master', 'Admin\Master::index');
// });


