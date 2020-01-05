<?php

// 1. fungsi-fungsi string, menampilkan teks berdasarkan kode


//menampilkan string bulan dalam tahun
function str_bln($bln)
{
   $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
   return $bulan[$bln - 1];
}

//2. Fungsi tentang pertanggalan

//ubah format tangggal dari yyyy-mm-dd
//ex:ubah_format('1992-05-18') => 18-05-1992
//	 ubah_format('1992-05-18',2) => 18 Mei 1992
//	 ubah_format('1992-05-18',3) => 18/05/1992
function ubah_format_tgl($tgl, $format = 1, $reverse = false)
{
   if ($reverse) {
      if ($format == 1) {
         return date("Y-m-d", strtotime($tgl));
      }
   } else {
      if ($format == 1) {
         return date("d-m-Y", strtotime($tgl));
      } else if ($format == 2) {
         return date("d", strtotime($tgl)) . " " . str_bln(date("m", strtotime($tgl))) . " " . date("Y", strtotime($tgl));
      } else if ($format == 3) {
         return date("d/m/Y", strtotime($tgl));
      }
   }
}


function list_kategori()
{
   include "config/koneksi.php";
   $query = $mysqli->query("SELECT * from tb_kategori ORDER BY kategori");
   return $query;
}
function get_kategori_byId($id)
{
   include "config/koneksi.php";
   $query = $mysqli->query("SELECT * from tb_kategori WHERE id_kategori='$id'");
   return $query;
}
function list_barang()
{
   include "config/koneksi.php";
   $query = $mysqli->query("SELECT * from tb_barang a JOIN tb_kategori b ON a.id_kategori=b.id_kategori ORDER BY a.nama_barang");
   return $query;
}
function get_barang_byId($id)
{
   include "config/koneksi.php";
   $query = $mysqli->query("SELECT * from tb_barang WHERE id='$id'");
   return $query;
}
function list_tmp_penjualan()
{
   include "config/koneksi.php";
   $query = $mysqli->query("SELECT * from tb_tmp_penjualan a JOIN tb_barang b WHERE a.kd_barang=b.kd_barang");
   return $query;
}
function get_total_tmp_penjualan()
{
   include "config/koneksi.php";
   $query = $mysqli->query("SELECT SUM(a.jml*b.harga_barang) AS total FROM tb_tmp_penjualan a JOIN tb_barang b ON a.kd_barang=b.kd_barang");
   return $query;
}




















function alert_process($id, $status, $data, $menu, $text = "")
{

   $stat = "";
   if ($text == "") {
      if ($id == 1) {
         $text = "menambah";
      } else if ($id == 2) {
         $text = "mengubah";
      } else if ($id == 3) {
         $text = "menghapus";
      }
   }
   if ($status) {
      $stat = "Berhasil";
   } else {
      $stat = "Gagal";
   }
   echo "<script>
	setTimeout(function () { 
			swal({
		title:'" . $stat . " " . $text . " data " . $data . "',
   type:'" . (($status) ? "success" : "error") . "'
  });
  },10);
  window.setTimeout(function(){ 
  window.location.replace('?menu=" . $menu . "');
 } ,2000); 
  </script>";
}
