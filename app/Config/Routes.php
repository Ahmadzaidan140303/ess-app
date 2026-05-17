<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login/process', 'Auth::login_process');
$routes->get('/logout', 'Auth::logout');

// Rute khusus untuk Karyawan
$routes->get('/karyawan/dashboard', 'Karyawan::index');

// Rute khusus untuk Admin (antisipasi jika login sebagai admin)
$routes->get('/admin/dashboard', 'Admin::index');

// Rute khusus untuk Cuti
$routes->get('/karyawan/cuti', 'Karyawan::cuti');
$routes->post('/karyawan/cuti/store', 'Karyawan::cuti_store');

// Rute khusus untuk Slip Gaji
$routes->get('/karyawan/slip-gaji', 'Karyawan::slip_gaji');

// Rute khusus untuk Download Surat
$routes->get('/karyawan/download-surat', 'Karyawan::download_surat');
$routes->get('/karyawan/download-surat/proses/(:num)', 'Karyawan::proses_download/$1');
