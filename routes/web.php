<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version()." API for Catatan kasir Android";
});

$router->get('/tes', 'ExampleController@tesaja');
$router->post("/register", "AuthController@register");
$router->post("/login", "AuthController@login");
$router->post("/login-wali-santri", "AuthController@loginWaliSantri");
$router->get("/logout", "AuthController@logout");

$router->get("/user", "UserController@index");
$router->post("/user/update", "UserController@update");
$router->get("/user/detail", "UserController@detail");

$router->post("/barang/add", "BarangController@store");
$router->post("/barang/update", "BarangController@update");
$router->get("/barang/data", "BarangController@anyData");
$router->get("/barang/data/all", "BarangController@getAllBarang");
$router->get("/barang/data/stok-tipis", "BarangController@dataMenipis");
$router->get("/barang/delete", "BarangController@delete");

$router->get("/pelanggan/data", "PelangganController@anyData");
$router->get("/pelanggan/data/all", "PelangganController@getAllPelanggan");
$router->post("/pelanggan/add", "PelangganController@store");


$router->get("/santri-by-wali", "SantriController@anyData");
$router->get("/santri/kitab", "SantriController@kitabSantri");
$router->get("/santri/pelanggaran", "SantriController@pelanggaran");
$router->get("/santri/prestasi", "SantriController@prestasi");
$router->get("/santri/pembayaran", "SantriController@pembayaran");
$router->get("/santri/jadwal", "SantriController@jadwal");

