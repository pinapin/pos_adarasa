<?php
include "../../../../functions/config/koneksi.php";
$simpan = isset($_POST['simpan']);
$edit = isset($_POST['edit']);
$hapus = isset($_POST['hapus']);

if ($simpan == "simpan") {

    $kd_barang =  trim($_POST['kd_barang']);
    $id_kategori =  trim($_POST['id_kategori']);
    $nama_barang =  trim($_POST['nama_barang']);
    $harga_barang =  trim($_POST['harga_barang']);

    $cek = $mysqli->query("SELECT kd_barang FROM tb_barang where kd_barang='$kd_barang'");
    if ((mysqli_num_rows($cek) > 0)) {
        $status = array('status' => '0', 'pesan' => 'DATA SUDAH ADA');
    } else {
        $simpan = $mysqli->query("INSERT INTO `tb_barang`(`kd_barang`, `id_kategori`, `nama_barang`, `harga_barang`, `created_date`) VALUES ('$kd_barang','$id_kategori','$nama_barang','$harga_barang',NOW())");

        $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DISIMPAN');
    }
} else if ($edit == "edit") {
    $id =  trim($_POST['id']);
    $kd_barang =  trim($_POST['kd_barang']);
    $id_kategori =  trim($_POST['id_kategori']);
    $nama_barang =  trim($_POST['nama_barang']);
    $harga_barang =  trim($_POST['harga_barang']);

    $sql_update = $mysqli->query("UPDATE `tb_barang` SET 
													`kd_barang`='$kd_barang',
													`nama_barang`='$nama_barang',
													`id_kategori`='$id_kategori',
													`harga_barang`='$harga_barang'
													WHERE `id`='$id'");
    if ($sql_update) {
        $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DIEDIT');
    } else {
        $status = array('status' => '2', 'pesan' => 'DATA GAGAL DIEDIT');
    }
} else if ($hapus == "hapus") {
    $id =  trim($_POST['id']);
    $sql_hapus = $mysqli->query("DELETE FROM tb_barang where id='$id'");


    if ($sql_hapus) {
        $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DIHAPUS');
    } else {
        $status = array('status' => '2', 'pesan' => 'DATA GAGAL DIHAPUS');
    }
}
echo json_encode($status);
