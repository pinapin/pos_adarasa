<?php
include "../../../../functions/config/koneksi.php";
$tambah = isset($_POST['tambah']);
$simpan = isset($_POST['simpan']);
$edit = isset($_POST['edit']);
$hapus = isset($_POST['hapus']);
$update_jumlah = isset($_POST['update_jumlah']);
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

    $id_penjualan =  trim($_POST['id_penjualan']);
    $tgl = date('Ymd');
    $jam = date('His');
    $bayar = $_POST['bayar'];


    $simpan = $mysqli->query("INSERT INTO `tb_penjualan` (id_penjualan,tgl,jam,bayar) VALUES ('$id_penjualan','$tgl','$jam','$bayar')");

    $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DISIMPAN');
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
} else if ($update_jumlah == "update_jumlah") {
    $kd_barang = $_POST['kd_barang'];
    $jumlah = $_POST['jumlah'];

    //cek stok dulu bro
    $query2 = $mysqli->query("SELECT SUM(IF(tipe='in',jml,0)) AS masuk,SUM(IF(tipe='out',jml,0)) AS keluar FROM tb_stok a JOIN tb_barang b ON a.id_barang=b.id WHERE b.kd_barang='$kd_barang'");
    $data2 = $query2->fetch_array();
    $stok = $data2['masuk'] - $data2['keluar'];

    if ($stok < $jumlah) {
        $status = array('status' => '2', 'pesan' => 'JUMLAH MELEBIHI STOK');
    } else {
        $update = $mysqli->query("UPDATE tb_tmp_penjualan set jml='$jumlah' WHERE kd_barang='$kd_barang'");
        if ($update) {
            $status = array('status' => '1', 'pesan' => 'DATA BERHASIL DIUBAH');
        } else {
            $status = array('status' => '2', 'pesan' => 'GAGAL');
        }
    }
}
echo json_encode($status);
