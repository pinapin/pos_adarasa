<?php
session_start();
$sesi = isset($_SESSION['user']['id_user']) ? $_SESSION['user'] : 0;

if ($sesi['level'] == 'admin') {
	include("menu/admin/index.php");
} else if ($sesi['level'] == 'pemimpin') {
	include("menu/pemimpin/index.php");
} else {
	include("menu/login.php");
}
