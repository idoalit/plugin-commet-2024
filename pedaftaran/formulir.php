<?php
// dump($_POST);
if (isset($_POST['nama'])) {
    // get post data
    $nama = utility::filterData('nama', 'post', true, true, true);
    $email = utility::filterData('email', 'post', true, true, true);
    $hp = utility::filterData('hp', 'post', true, true, true);

    // ambil koneksi database
    $db = \SLiMS\DB::getInstance();
    // simpan data ke database
    $stmn = $db->prepare("insert into tabel_sementara(nama, email, hp) values (:nama, :email, :hp)");
    $stmn->bindValue(':nama', $nama);
    $stmn->bindValue(':email', $email);
    $stmn->bindValue(':hp', $hp);

    if ($stmn->execute()) {
        echo '<div class="alert alert-success">Data berhasil disimpan</div>';
    } else {
        echo '<div class="alert alert-danger">Data GAGAL disimpan</div>';
    }
}
?>
<form method="POST" action="<?= $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] ?>">
    <div class="form-group">
        <label for="nama">Nama</label>
        <input name="nama" type="text" class="form-control" id="nama">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input name="email" type="email" class="form-control" id="email">
    </div>
    <div class="form-group">
        <label for="hp">HP</label>
        <input name="hp" type="text" class="form-control" id="hp">
    </div>
    <button type="submit" class="btn btn-primary">KIRIM</button>
</form>