<?php
include "../../../../functions/config/koneksi.php";
$tambah = isset($_POST['tambah']);
$simpan = isset($_POST['simpan']);
$edit = isset($_POST['edit']);
$hapus = isset($_POST['hapus']);
if ($tambah == "tambah") {

    $kd_barang =  trim($_POST['kd_barang']);


    $query = $mysqli->query("SELECT id,kd_barang FROM tb_barang where kd_barang='$kd_barang'");
    $data = $query->fetch_array();
    $id_barang = $data['id'];
    if (!$data['kd_barang']) {
        $status = array('status' => '0', 'pesan' => 'KODE BARANG BELUM ADA DI MASTER BARANG');
    } else {
        $query2 = $mysqli->query("SELECT SUM(IF(tipe='in',jml,0)) AS masuk,SUM(IF(tipe='out',jml,0)) AS keluar FROM tb_stok WHERE id_barang='$id_barang'");
        $data2 = $query2->fetch_array();
        $stok = $data2['masuk'] - $data2['keluar'];
        if ($stok < 1) {
            $status = array('status' => '0', 'pesan' => 'STOK KOSONG');
        } else {
            $cek = $mysqli->query("SELECT kd_barang FROM tb_tmp_penjualan where kd_barang='$kd_barang'");
            $cek1 = $cek->num_rows;
            if ($cek1 > 0) {
                $query_update = $mysqli->query("UPDATE tb_tmp_penjualan SET jml=jml+1 WHERE kd_barang='$kd_barang'");
                $status = array('status' => '1', 'pesan' => 'BERHASIL');
            } else {
                $query_simpan = $mysqli->query("INSERT INTO tb_tmp_penjualan (kd_barang,jml) VALUES ('$kd_barang','1')");
                $status = array('status' => '1', 'pesan' => 'BERHASIL');
            }
        }
    }
} else if ($simpan == "simpan") {

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
    $sql_hapus = $mysqli->query("DELETE FROM tb_tmp_penjualan where kd_barang='$id'");


    if ($sql_hapus) {
        $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DIHAPUS');
    } else {
        $status = array('status' => '2', 'pesan' => 'DATA GAGAL DIHAPUS');
    }
}
echo json_encode($status);
