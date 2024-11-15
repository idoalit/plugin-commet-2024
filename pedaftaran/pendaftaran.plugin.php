<?php
/**
 * Plugin Name: Pendaftaran Mandiri
 * Plugin URI: http:://github.com/idoalit/pendaftaran-mandiri
 * Description: Formulir pendaftaran mandiri
 * Version: 0.0.1
 * Author: Waris Agung Widodo
 * Author URI: http:://github.com/idoalit
*/

// Mengambil instance dari SLiMS Plugin
$plugin = SLiMS\Plugins::getInstance();

// Menambahkan menu pada OPAC
// http://<alamat slims>/index.php?p=pendaftaran_mandiri
$plugin->registerMenu('opac', 'Pendaftaran Anggota', __DIR__ . '/formulir.php');

// Menambahkan menu verifikasi anggota di admin
$plugin->registerMenu('membership', 'Verifikasi Anggota', __DIR__ . '/verifikasi.php');