<?php
include "../../../../functions/config/koneksi.php";
$simpan = isset($_POST['simpan']);
$edit = isset($_POST['edit']);
$hapus = isset($_POST['hapus']);

if ($simpan == "simpan") {

    $kategori =  trim($_POST['kategori']);

    $cek = $mysqli->query("SELECT kategori FROM tb_kategori where kategori='$kategori'");
    if ((mysqli_num_rows($cek) > 0)) {
        $status = array('status' => '0', 'pesan' => 'DATA SUDAH ADA');
    } else {
        $simpan = $mysqli->query("INSERT INTO `tb_kategori` (kategori) VALUES ('$kategori')");

        $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DISIMPAN');
    }
} else if ($edit == "edit") {
    $id_kategori =  trim($_POST['id_kategori']);
    $kategori =  trim($_POST['kategori']);

    $sql_update = $mysqli->query("UPDATE `tb_kategori` SET 
													`kategori`='$kategori'
													WHERE `id_kategori`='$id_kategori'");
    if ($sql_update) {
        $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DIEDIT');
    } else {
        $status = array('status' => '2', 'pesan' => 'DATA GAGAL DIEDIT');
    }
} else if ($hapus == "hapus") {
    $id =  trim($_POST['id']);
    $sql_hapus = $mysqli->query("DELETE FROM tb_kategori where id_kategori='$id'");


    if ($sql_hapus) {
        $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DIHAPUS');
    } else {
        $status = array('status' => '2', 'pesan' => 'DATA GAGAL DIHAPUS');
    }
}
echo json_encode($status);
