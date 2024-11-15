<?php
/**
 * Plugin Name: Kirim data ke email
 * Plugin URI: http:://github.com/idoalit/pendaftaran-mandiri
 * Description: Kirim data ke email setelah transaksi selasai
 * Version: 0.0.1
 * Author: Waris Agung Widodo
 * Author URI: http:://github.com/idoalit
*/

use PHPMailer\PHPMailer\PHPMailer;
use SLiMS\Plugins;

// mengambil instance dari plugin
$plugin = Plugins::getInstance();

$plugin->registerHook(Plugins::CIRCULATION_AFTER_SUCCESSFUL_TRANSACTION, function($data) {
    $query = (\SLiMS\DB::getInstance())->query("select member_email from member where member_id='" . $data['memberID']."'");
    $data = $query->fetch(PDO::FETCH_OBJ);

    // codenya disini
    // Looking to send emails in production? Check out our Email API/SMTP product!
    $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = 'b801d2e5fa9906';
    $phpmailer->Password = '22bf1ea4e8d95c';
    $phpmailer->Subject = "Notifikasi";

    $body = '';
    $body .= '---- daftar buku dipinjam ---';
    if (isset($data->loan)) {
        foreach ($data->loan as $loan) {
            $body .= 'Judul: ' . $loan['title'] . PHP_EOL;
            $body .= 'Nomer Barcode: ' . $loan['item_code'] . PHP_EOL;
            $body .= 'Tanggal Pinjam: ' . $loan['loan_date'] . PHP_EOL;
            $body .= 'Tanggal Harus Kembali: ' . $loan['due_date'] . PHP_EOL;
            $body .= "----------------";
        }
    }

    $body .= '---- daftar buku kembali ---';
    if (isset($data->return)) {
        foreach ($data->return as $loan) {
            $body .= 'Judul: ' . $loan['title'] . PHP_EOL;
            $body .= 'Nomer Barcode: ' . $loan['item_code'] . PHP_EOL;
            $body .= 'Tanggal Pinjam: ' . $loan['loan_date'] . PHP_EOL;
            $body .= 'Tanggal Kembali: ' . $loan['return_date'] . PHP_EOL;
            $body .= "----------------";
        }
    }

    $phpmailer->Body = $body;
    $phpmailer->AltBody = $body;
    $phpmailer->setFrom('perpustakaan@upi.ac.id');
    $phpmailer->addAddress($data->member_email);

    $phpmailer->send();
});