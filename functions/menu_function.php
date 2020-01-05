<?php
function show_menu($menu = "utama", $p = "")
{
	$mn = "";
	switch ($menu) {

		case "barang":
			$mn = "master_data/barang.php";
			break;
		case "kategori":
			$mn = "master_data/kategori.php";
			break;
		case "penjualan":
			$mn = "master_data/penjualan.php";
			break;






			// case "lihat_pembelian_lokal":
			// 	$mn="/pembelian/lihat_pembelian_lokal.php";
			// 	if($p=="detail"){
			// 		$mn="/pembelian/detail/detail_pembelian_lokal.php";
			// 	}else if($p=="edit"){
			// 		$mn="/pembelian/edit/edit_pembelian_lokal.php";
			// 	}
			// break;

		default:
			$mn = "dashboard.php";
	}
	include_once("menu/admin/" . $mn);
}
