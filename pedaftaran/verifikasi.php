<?php


// echo '</div>';

defined('INDEX_AUTH') or die('Direct access not allowed!');

// IP based access limitation
require LIB . 'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-bibliography');
// start the session
require SB . 'admin/default/session.inc.php';
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';

if (isset($_POST['saveData'])) {
    $id = $_POST['updateRecordID'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $hp = $_POST['hp'];

    try {
        // ambil koneksi database
        $db = \SLiMS\DB::getInstance();
        // simpan data ke database
        $stmn = $db->prepare("insert into member (member_id, member_name, member_email, member_phone, gender, expire_date) values (:id, :nama, :email, :hp, 0, :expire)");
        $stmn->bindValue(':id', 'M00000' . $id);
        $stmn->bindValue(':nama', $nama);
        $stmn->bindValue(':email', $email);
        $stmn->bindValue(':hp', $hp);
        $stmn->bindValue(':expire', date('Y-m-d', strtotime("+1 year")));

        $stmn->execute();
        $db->query('delete from tabel_sementara where id=' . $id);

        echo 'Data berhasil disimpan.';

        exit;
    } catch (\Throwable $th) {
        throw $th;
    }
}

?>

<div class="menuBox">
    <div class="menuBoxInner printIcon">
        <div class="per_title">
            <h2><?php echo __('Verifikasi Anggota'); ?></h2>
        </div>
        <div class="infoBox">
            <?= __('Masukan nama yang akan dicari') ?>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-default"><?php echo __('Report'); ?></a>
            </div>
            <form name="read_counter" action="<?= $_SERVER['PHP_SELF'] ?>" id="search" method="post"
                class="form-inline"><?php echo __('Nama'); ?>&nbsp;:&nbsp;
                <input type="text" name="nama" class="form-control col-md-3" autocomplete="off" />
                <input type="submit" id="doAdd" value="<?php echo __('Search'); ?>"
                    class="s-btn btn btn-success" />
            </form>
        </div>
    </div>
</div>

<?php

if (isset($_GET['itemID']) && isset($_GET['detail']) && $_GET['detail'] === 'true') {
    $id = $_GET['itemID'];

    $db = \SLiMS\DB::getInstance();
    $query = $db->query("select * from tabel_sementara where id = $id");
    $data = $query->fetch(PDO::FETCH_ASSOC);

    $form = new simbio_form_table_AJAX('main-form', $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
    $form->edit_mode = true;
    $form->submit_button_attr = 'name="saveData" value="' . __('Oke Diterima') . '" class="s-btn btn btn-success"';
    $form->record_id = $id;
    $form->addTextField('text', 'nama', 'NAMA', $data['nama'] ?? '');
    $form->addTextField('text', 'email', 'EMAIL', $data['email'] ?? '');
    $form->addTextField('text', 'hp', 'No HP', $data['hp'] ?? '');

    echo $form->printOut();
} else {
    $grid = new simbio_datagrid('class="table table-striped"');
    $grid->setSQLColumn("id", "nama", "email", "hp");
    $grid->setSQLorder('nama DESC');
    echo $grid->createDataGrid(\SLiMS\DB::getInstance('mysqli'), 'tabel_sementara', 20, true);
}
