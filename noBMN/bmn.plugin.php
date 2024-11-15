<?php
/**
 * Plugin Name: Tambah field BMN
 * Plugin URI: http:://github.com/idoalit/pendaftaran-mandiri
 * Description: Menambahkan field BMN di formulir bibliografi
 * Version: 0.0.1
 * Author: Waris Agung Widodo
 * Author URI: http:://github.com/idoalit
*/

use SLiMS\Plugins;

$plugin = \SLiMS\Plugins::getInstance();

// $plugin->registerMenu('bibliography', 'Biblio BMN', __DIR__ . '/bmn.php');

$plugin->registerHook(Plugins::BIBLIOGRAPHY_INIT, function() {
    require __DIR__ . '/bmn.php';
    exit;
});