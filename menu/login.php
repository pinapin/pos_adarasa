<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Aplikasi Pos</title>

	<!-- Global stylesheets -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css"> -->
	<link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="global_assets/js/main/jquery.min.js"></script>
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="assets/js/app.js"></script>
	<!-- /theme JS files -->

</head>

<body class="bg-dark">




	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login form -->
				<form class="login-form mb-5">
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
								<h5 class="mb-0">Silahkan Login</h5>

							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input id="txt_username" type="text" class="form-control" placeholder="Username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input id="txt_password" type="password" class="form-control" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button onclick="check_login()" id="btnLogin" type="submit" class="btn btn-primary btn-block">Login <i class="icon-circle-right2 ml-2"></i></button>
							</div>


						</div>
					</div>
				</form>
				<!-- /login form -->

			</div>
			<!-- /content area -->




		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>

</html>

<script type="text/javascript">
	function check_login() {
		//Mengambil value dari input username & Password
		var username = $('#txt_username').val();
		var password = $('#txt_password').val();
		//Ubah alamat url berikut, sesuaikan dengan alamat script pada komputer anda
		var url_login = 'proccess/login_proccess.php';
		var url_admin = './';

		//Ubah tulisan pada button saat click login
		$('#btnLogin').html('Memproses ...');

		//Gunakan jquery AJAX
		$.ajax({
			url: url_login,
			//mengirimkan username dan password ke script login.php
			data: 'var_usn=' + username + '&var_pwd=' + password,
			//Method pengiriman
			type: 'POST',
			//Data yang akan diambil dari script pemroses
			dataType: 'html',
			//Respon jika data berhasil dikirim
			success: function(pesan) {
				if (pesan == 'ok') {
					// $('#gagal').attr('style','display:none');
					// $('#sukses').attr('style','display:');
					//Arahkan ke halaman admin jika script pemroses mencetak kata ok
					window.location = url_admin;
				} else {
					//Cetak peringatan untuk username & password salah
					alert(pesan);
					// $('#gagal').attr('style','display:');
					$('#btnLogin').html('Coba Lagi ...');
				}
			},
		});
	}
</script>