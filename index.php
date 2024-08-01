<?php
session_start();
require "config.php";

if (isset($_POST['submit'])) {
	if (!isset($_SESSION["login_pelanggan"])) {
		header("location:login.php");
	} else {
		$tanggal = $_POST['tanggal'];
		$tanggal_sekarang = date("Y-m-d");

		if ($tanggal < $tanggal_sekarang) {
			echo "<script>
			alert('Tanggal sudah lewat, silahkan pilih tanggal lain!');
			window.location.href='index.php';
			</script>";
			exit;
		}
		$userId = $_SESSION['id_pelanggan']; // Asumsikan id_pelanggan disimpan di session saat login
		$jumlah_pemancing = booking($tanggal);
		$user = getUserData($userId);
	}
}

if (isset($_POST['pesan_tiket'])) {
	$userId = $_SESSION['id_pelanggan'];
	$tanggal = $_POST['tanggal'];
	$bukti_transfer = $_FILES['bukti_transfer']['name'];
	$target_dir = 'images/bukti_bayar/';
	$target_file = $target_dir . basename($bukti_transfer);

	if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $target_file)) {
		saveOrder($userId, $tanggal, $target_file);
		$jumlah_pemancing = booking($tanggal); // Mengupdate jumlah pemancing setelah pemesanan
		echo "<script>
		alert('Pesanan Anda Berhasil!');
		window.location.href='index.php';
	</script>";
	} else {
		echo "<script>
		alert('Terjadi kesalah, cek kembali orderan anda!');
	</script>";
	}
}


include "header.php";
?>
<div class="hero">
	<div class="container">
		<div class="row align-items-center" id="order">
			<div class="col-lg-7">
				<div class="intro-wrap">
					<h1 class="mb-5"><span class="d-block">Let's Enjoy Your</span> Fishing In <span class="typed-words"></span></h1>
					<div class="row">
						<div class="col-12">
							<form class="form" action="" method="post">
								<div class="row mb-4">
									<div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-6">
										<label for="">Cari Tanggal</label>
										<input type="date" class="form-control" name="tanggal">
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
										<input type="submit" name="submit" class="btn btn-primary btn-block" value="Search">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="slides">
					<img src="images/hero-pancing.jpg" alt="Image" class="img-fluid active">
				</div>
			</div>
		</div>
	</div>
</div>

<?php if (isset($_POST['submit'])) {
	if (!isset($_SESSION["login_pelanggan"])) {
		header("location:login.php");
	} elseif ($jumlah_pemancing == 25) { ?>
		<div class="untree_co-section">
			<div class="container">
				<div class="row mb-5 justify-content-center">
					<div class="col-lg-6 text-center">
						<h2 class="section-title text-center mb-3">Our Services</h2>
						<div class="alert alert-info col-12" role="alert">
							Tiket habis, Jumlah Pemancingan sudah Full! <a href="#order"><b>Pilih tanggal lain</b></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else {
	?>
		<div class="untree_co-section">
			<div class="container">
				<div class="row mb-5 justify-content-center">
					<div class="col-lg-6 text-center">
						<h2 class="section-title text-center mb-3">Our Services</h2>
						<div class="alert alert-success col-12" role="alert">
							Tanggal <b><?= $_POST["tanggal"]; ?></b> jumlah pemancing <?= $jumlah_pemancing; ?>/25
						</div>
					</div>
					<div class="untree_co-section">
						<div class="container">
							<div class="row">
								<div class="col-lg-6 mb-5 mt-4 mb-lg-0">
									<form class="contact-form" action="" method="post" enctype="multipart/form-data">
										<div class="form-group">
											<label class="text-black" for="nama_user">Nama Lengkap</label>
											<input type="text" class="form-control" name="nama_user" id="nama_user" value="<?= isset($user['nama_user']) ? $user['nama_user'] : ''; ?>" disabled>
										</div>
										<div class="form-group">
											<label class="text-black" for="email">Email address</label>
											<input type="email" class="form-control" name="email" id="email" value="<?= isset($user['email']) ? $user['email'] : ''; ?>" disabled>
										</div>
										<div class="form-group">
											<label class="text-black" for="bukti_transfer"><b>Lampirkan Bukti Transfer</b></label>
											<input type="file" class="form-control" name="bukti_transfer" id="bukti_transfer" required>
										</div>
										<input type="hidden" name="tanggal" value="<?= $_POST["tanggal"]; ?>">
										<button type="submit" name="pesan_tiket" class="btn btn-primary">Pesan Tiket</button>
									</form>
								</div>
								<div class="col-lg-6 ml-auto">
									<div class="feature-1 ">
										<div class="align-self-center">
											<h2 class="mb-3">Pemancingan BangJohn Balaraja</h2>
											<p class="mb-0">Tanggal : <?= $_POST["tanggal"]; ?></p>
											<p class="mb-0">Waktu : 20.00 - 22.00</p>
											<p class="mb-3">Harga Tiket : Rp. 150.000,-</p>
											<p class="mb-0"><b>Note : Silahkan melakukan transfer pada rekening dibawah ini
													<br>
													BCA : 123123 ( Johnny Risnandar )</b></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
} ?>


<div class="site-footer">
	<div class="inner dark">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-8 mb-3 mb-md-0 mx-auto">
					<p>BangJohn Sport Fishing Copyright &copy;<script>
							document.write(new Date().getFullYear());
						</script>. All Rights Reserved.
					</p>
				</div>

			</div>
		</div>
	</div>
</div>

<div id="overlayer"></div>
<div class="loader">
	<div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	</div>
</div>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/daterangepicker.js"></script>

<script src="js/typed.js"></script>
<script>
	$(function() {
		var slides = $('.slides'),
			images = slides.find('img');

		images.each(function(i) {
			$(this).attr('data-id', i + 1);
		})

		var typed = new Typed('.typed-words', {
			strings: ["Bang John."],
			typeSpeed: 80,
			backSpeed: 80,
			backDelay: 4000,
			startDelay: 1000,
			loop: true,
			showCursor: true,
			preStringTyped: (arrayPos, self) => {
				arrayPos++;
				console.log(arrayPos);
				$('.slides img').removeClass('active');
				$('.slides img[data-id="' + arrayPos + '"]').addClass('active');
			}

		});
	})
</script>

<script src="js/custom.js"></script>

</body>

</html>