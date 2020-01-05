<?php
session_start();
//koneksi ke database
include "../functions/config/koneksi.php";
include "../functions/config/enkrip.php";



if (isset($_POST['var_usn']) and isset($_POST['var_pwd'])) {
	$username = addslashes($_POST['var_usn']);
	$password = addslashes(encrypt($_POST['var_pwd']));
	$check    = $mysqli->query('select * from tb_user where username="' . $username . '" AND password="' . $password . '" ');
	if (mysqli_num_rows($check) == 0) {
		echo 'Username atau Password Salah !';
	} else {
		while ($run = mysqli_fetch_assoc($check)) {
			$_SESSION['user']['id_user'] = $run['id_user'];
			$_SESSION['user']['level'] = $run['level'];
			$_SESSION['user']['username'] = $run['username'];


			echo 'ok';
		}
	}
}
