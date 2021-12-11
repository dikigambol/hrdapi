<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {

	// ---------------------------------- HRD APP -----------------------------------------------//

	// ======LOGIN=====
	$app->post("/hrd/user/login/{ul}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		require 'link/surat/link_surat.php';

		$un = $_POST["user_name"];
		$up = $_POST["user_password"];

		// $b1=base64_encode($up);
		// $b2=base64_encode($b1);

		// $dup=$b2;

		$sql = "SELECT * FROM user_entity WHERE user_id='$un' AND id_hidden=1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();


		if ($stmt->rowCount() == 1) {
			$result = $stmt->fetch();

			$postencript = $result['user_password'];
			require 'fuction/decript.php';
			$hasil = trim($plaintext_dec);

			if ($hasil == $up) {
				$name_login = $result['id'];
				$sql_c_level = "SELECT * FROM `level_detail` WHERE `id` = '$name_login'";
				$cf_level = $this->db->prepare($sql_c_level);
				$cf_level->execute();
				$level_result = $cf_level->fetchAll();

				$vcode = array([
					"filedatas" => "1",
					"idus" => $name_login
				]);
			} else {
				$vcode = array([
					"filedatas" => "0a"
				]);
			}
		} else {
			$vcode = array([
				"filedatas" => "0b"
			]);
		}

		return $response->withJson($vcode, 200);
	});

	$app->get("/hrd/loading/search/{inview}", function (Request $request, Response $response, $args) {
		$idus = $_GET['uid'];
		$sql = "SELECT id AS nd, level_id AS nl, id_urt AS nr, grub_id AS ng, id_hidden AS nh FROM `level_detail` where id='$idus' AND level_id='19'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$sql2a = "SELECT * FROM `level_detail` where id='$idus' AND level_id='19'";
		$stmt2a = $this->db->prepare($sql2a);
		$stmt2a->execute();
		$rstmt2a = $stmt2a->fetch();
		$nstmt2a = $stmt2a->rowCount();

		if ($nstmt2a == "") {
			$ak = 0;
		} else {
			if ($rstmt2a['level_id'] == 19) {
				$ak = 19;
			} else {
				$ak = 0;
			}
		}

		$dataready = $result['nl'];
		require 'fuction/encript.php';
		$acc = $ciphertext_base64;

		$sql2 = "SELECT * FROM `user_entity` where id='$idus'";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();

		$dataready = $result2['user_id'];
		require 'fuction/encript.php';
		$usid = $ciphertext_base64;

		$dataready = $result2['id'];
		require 'fuction/encript.php';
		$usid2id = $ciphertext_base64;

		$vcode = array([
			'aks' => $acc,
			'user_id' => $usid,
			'user_nama' => $result2['user_name'],
			'usid' => $usid2id
		]);

		return $response->withJson($vcode, 200);
	});

	$app->get("/hrd/lodeng/anyar/{inview}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$idus = $_GET['uid'];
		$app = $_GET['app'];
		$sql = "SELECT * FROM `level_detail` WHERE `id` = '$idus'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$nstmt = $stmt->rowCount();
		if ($nstmt == 0) {
			$reslv = "-";
		} else {
			$resultsementara = $stmt->fetch();

			$reslv = $resultsementara['level_id'];
		}

		$sqlzs = "SELECT * FROM `level_detail` WHERE `id` = '$idus'";
		$stmtzs = $this->db->prepare($sqlzs);
		$stmtzs->execute();
		$nstmtzs = $stmtzs->rowCount();

		$os = array();

		if ($nstmtzs > 0) {
			while ($rstmtzs = $stmtzs->fetch()) {
				$idurt = $rstmtzs['level_id'];
				$idn = $rstmtzs['id'];
				$sqlzsrule = "SELECT level_detail.id AS vid, rule.aplikasi_id AS apid, level_detail.level_id AS idlc, rule.aplikasi_id AS menuidapp FROM level_detail JOIN rule ON level_detail.level_id=rule.level_id WHERE level_detail.level_id='$idurt' AND level_detail.id='$idus' AND rule.aplikasi_id='$app'";

				$stmtzsrule = $this->db->prepare($sqlzsrule);
				$stmtzsrule->execute();
				$nstmtzsrule = $stmtzsrule->rowCount();
				$rstmtzsrule = $stmtzsrule->fetch();

				if ($rstmtzsrule['menuidapp'] == $app) {
					$gr = $rstmtzsrule['idlc'];
					$sqlg = "SELECT * FROM user_grub where grub_id='$gr'";
					$ssqlg = $this->db->prepare($sqlg);
					$ssqlg->execute();
					$rssqlg = $ssqlg->fetch();

					$h['acc_user'] = "1";
					$dataready = $gr;
					require 'fuction/encript.php';
					$akses = $ciphertext_base64;
					$h['akses'] = $akses;

					array_push($os, $h);
				}
			}
		} else {
			$h['acc_user'] = "0";
			$h['akses'] = "0";

			$a = array_push($os, $h);
		}

		$sql2 = "SELECT * FROM `user_entity` where id='$idus'";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();

		$dataready = $result2['id'];
		require 'fuction/encript.php';
		$iduser = $ciphertext_base64;

		$dataready = $result2['user_id'];
		require 'fuction/encript.php';
		$userid = $ciphertext_base64;

		$sql3 = "SELECT * FROM `versi` WHERE `id` = '$idus' AND `aplikasi_id` = '$app'";
		$stmt3 = $this->db->prepare($sql3);
		$stmt3->execute();
		$result3 = $stmt3->fetch();

		$sql4 = "SELECT * FROM aplikasi WHERE `aplikasi_id` = '$app'";
		$stmt4 = $this->db->prepare($sql4);
		$stmt4->execute();
		$result4 = $stmt4->fetch();

		$userversi = $result3['v_versi'];
		$appversi = $result4['v_aplikasi'];

		if ($userversi == $appversi) {
			$bversi = 1;
		} else {
			$bversi = 0;
		}

		$vcode = array([
			'aks' => $os,
			'user_id' => $userid,
			'user_nama' => $result2['user_name'],
			'usid' => $iduser,
		]);

		return $response->withJson($vcode, 200);
	});

	$app->get("/cari/aks/hrd/aps/{vvv}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';

		$postencript = $_GET['ak'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `level_detail` WHERE level_id='$id' ORDER BY `id` DESC LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		return $response->withJson($res, 200);
	});
	// =======END LOGIN=========

	// view pegawai 
	$app->get("/tampil/hrd/{view}", function (Request $request, Response $response, $args) {
		$sql = "SELECT * FROM `user_entity` EXCEPT SELECT * FROM `user_entity` WHERE posisi1 = 'Dosen LB' ORDER BY `id` DESC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {
			$h['aban'] = $nn++;
			$dataready = $result['id'];
			require 'fuction/encript.php';
			$hasil = $ciphertext_base64;
			$h['abun'] = $hasil;
			$h['abon'] = $result['user_id'];
			$h['acas'] = $result['user_name'];
			$h['apem'] = $result['tgl_masuk'];
			$h['bakwan'] = $result['tgl_keluar'];
			$h['bolu'] = $result['alamat'];
			$h['cincau'] = $result['alamat_sekarang'];
			$h['cuanki'] = $result['no_hp'];
			$h['cucur'] = $result['tempat'];
			$h['duren'] = $result['tanggal_lahir'];
			$h['duku'] = $result['jenis_kelamin'];
			$h['donat'] = $result['nidn'];
			$h['fuyunghai'] = $result['no_ktp'];
			$h['gudeg'] = $result['status_nikah'];
			$h['gulali'] = $result['posisi1'];
			$h['lolipop'] = $result['posisi2'];
			$h['gulali'] = $result['posisi1'];
			$h['permen'] = $result['jabatan'];
			$h['soto'] = $result['id_hidden'];
			$h['sogun'] = $result['bpjs_kesehatan'];
			$h['taichan'] = $result['masa_aktif_kesehatan'];
			$h['tape'] = $result['bpjs_ketenagakerjaan'];
			$h['telo'] = $result['masa_aktif_ketenagakerjaan'];
			$h['udang'] = $result['jenjang'];
			$h['urap'] = $result['foto'];

			array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end view pegawai 

	// tambah pegawai 
	$app->post("/tambah/user/hrd/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$uid = $_POST["user_id"];
		$un = $_POST["user_name"];
		$nidn = $_POST["nidn"];
		$upd = date('sMys');
		$dvs = $_POST["jabatan"];
		$almt = $_POST["alamat"];
		$almtnow = $_POST["alamat_sekarang"];
		$hp = $_POST["no_hp"];
		$ps1 = $_POST["posisi1"];
		$ps2 = $_POST["posisi2"];
		$jurdos = $_POST["jurusan_dosen"];
		$stados = $_POST["status_dosen"];
		$date_now = $_POST["tgl_masuk"];
		$tmpt = $_POST["tempat"];
		$tgllahir = $_POST["tanggal_lahir"];
		$jnsklmn = $_POST["jenis_kelamin"];
		$ktp = $_POST["no_ktp"];
		$nikah = $_POST["status_nikah"];
		$bpjs_kshtn = $_POST["bpjs_kesehatan"];
		$ms_kshtn = $_POST["masa_aktif_kesehatan"];
		$bpjs_ktngkrjn = $_POST["bpjs_ketenagakerjaan"];
		$ms_ktngkrjn = $_POST["masa_aktif_ketenagakerjaan"];
		$jenjang = $_POST["jenjang"];
		$datemasuk = $date_now;
		$kunci = "UptSI";
		$string = $upd;

		$b1 = base64_encode($string);
		$b2 = base64_encode($b1);

		$dup = $b2;

		$csql_user = "SELECT * FROM user_entity WHERE user_id='$uid'";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		if ($cstmt_user->rowCount() == 0) {

			$sql = "INSERT INTO `user_entity` (`id`, `user_id`, `user_name`, `user_password`, `tgl_masuk`, `tgl_keluar`, `user_pass_def`, `alamat`, `alamat_sekarang`, `no_hp`, `tempat`, `tanggal_lahir`, `jenis_kelamin`, `nidn`, `no_ktp`, `status_nikah`, `posisi1`, `posisi2`, `jabatan`, `jurusan_dosen`,`status_dosen`,`kode_dosen`, `bpjs_kesehatan`, `masa_aktif_kesehatan`, `bpjs_ketenagakerjaan`, `masa_aktif_ketenagakerjaan`, `jenjang`,`foto`, `id_hidden`) 
			VALUES (NULL, '$uid', '$un', '$dup', '$datemasuk', NULL, '$upd', '$almt', '$almtnow', '$hp', '$tmpt', '$tgllahir', '$jnsklmn', '$nidn', '$ktp', '$nikah', '$ps1', '$ps2', '$dvs', '$jurdos', '$stados','0', '$bpjs_kshtn', '$ms_kshtn', '$bpjs_ktngkrjn', '$ms_ktngkrjn', '$jenjang','',1)";

			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$cek = 1;

			$sqlId = "SELECT * FROM `user_entity` ORDER BY id DESC LIMIT 1";
			$oghey = $this->db->prepare($sqlId);
			$oghey->execute();
			$roghey = $oghey->fetch();
			$dataready = $roghey['id'];
			require 'fuction/encript.php';
			$id = $ciphertext_base64;
		} else {
			$cek = 0;
			$id = null;
		}

		$vcode = array([
			"filedatas" => $cek,
			"id" => $id
		]);

		return $response->withJson($vcode, 200);
	});
	// end tambah pegawai 

	// detail pegawai 
	$app->get("/detail/hrd/id/{view}", function (Request $request, Response $response, $args) {
		$iden = $_GET["id"];
		$postencript = $iden;
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		if ($id == 0) {
		} else {

			$sql2 = "SELECT * FROM `user_entity` WHERE `id`='$id'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$res = array();
			$nn = 1;

			while ($result = $stmt2->fetch()) {
				$h['aban'] = $nn++;
				$h['abun'] = $result['id'];
				$h['abon'] = $result['user_id'];
				$h['acas'] = $result['user_name'];
				$h['apem'] = $result['tgl_masuk'];
				$h['bakwan'] = $result['tgl_keluar'];
				$h['bolu'] = $result['alamat'];
				$h['cincau'] = $result['alamat_sekarang'];
				$h['cuanki'] = $result['no_hp'];
				$h['cucur'] = $result['tempat'];
				$h['duren'] = $result['tanggal_lahir'];
				$h['duku'] = $result['jenis_kelamin'];
				$h['donat'] = $result['nidn'];
				$h['fuyunghai'] = $result['no_ktp'];
				$h['gudeg'] = $result['status_nikah'];
				$h['gulali'] = $result['posisi1'];
				$h['lolipop'] = $result['posisi2'];
				$h['gulali'] = $result['posisi1'];
				$h['permen'] = $result['jabatan'];
				$h['pempek'] = $result['jurusan_dosen'];
				$h['pilus'] = $result['status_dosen'];
				$h['soto'] = $result['id_hidden'];
				$h['sogun'] = $result['bpjs_kesehatan'];
				$h['taichan'] = $result['masa_aktif_kesehatan'];
				$h['tape'] = $result['bpjs_ketenagakerjaan'];
				$h['telo'] = $result['masa_aktif_ketenagakerjaan'];
				$h['udang'] = $result['jenjang'];
				$h['urap'] = $result['foto'];

				$a = array_push($res, $h);
			}
		}
		return $response->withJson($res, 200);
	});
	// end detail pegawai 

	// edit pegawai 
	$app->post("/hrd/updet/user/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		$usid = $_POST['user_id'];
		$usnm = $_POST['user_name'];
		$uspf = $_POST['user_pass_def'];
		$nidn = $_POST['nidn'];
		$dvs = $_POST['jabatan'];
		$almt = $_POST["alamat"];
		$almtnow = $_POST["alamat_sekarang"];
		$hp = $_POST["no_hp"];
		$ps1 = $_POST["posisi1"];
		$ps2 = $_POST["posisi2"];
		$jurdos = $_POST["jurusan_dosen"];
		$stados = $_POST["status_dosen"];
		$date_now = $_POST["tgl_masuk"];
		$tglkr = $_POST["tgl_keluar"];
		$tmpt = $_POST["tempat"];
		$tgllahir = $_POST["tanggal_lahir"];
		$jnsklmn = $_POST["jenis_kelamin"];
		$ktp = $_POST["no_ktp"];
		$nikah = $_POST["status_nikah"];
		$bpjs_kshtn = $_POST["bpjs_kesehatan"];
		$ms_kshtn = $_POST["masa_aktif_kesehatan"];
		$bpjs_ktngkrjn = $_POST["bpjs_ketenagakerjaan"];
		$ms_ktngkrjn = $_POST["masa_aktif_ketenagakerjaan"];
		$jenjang = $_POST["jenjang"];

		$datemasuk = $date_now;
		$datekeluar = $tglkr;

		$csql_user = "SELECT * FROM `user_entity` WHERE `user_id`='$usid' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		$sql = "UPDATE `user_entity` SET `user_id` = '$usid', `user_name` = '$usnm', `tgl_masuk` = '$datemasuk', `tgl_keluar` = '$datekeluar', `alamat` = '$almt', `alamat_sekarang` = '$almtnow', `no_hp` = '$hp', `tempat` = '$tmpt', `tanggal_lahir` = '$tgllahir', `jenis_kelamin` = '$jnsklmn', `nidn` = '$nidn', `no_ktp` = '$ktp', `status_nikah` = '$nikah', `posisi1` = '$ps1', `posisi2` = '$ps2', `jabatan` = '$dvs', `jurusan_dosen` = '$jurdos', `status_dosen` = '$stados',`bpjs_kesehatan` = '$bpjs_kshtn', `masa_aktif_kesehatan` = '$ms_kshtn', `bpjs_ketenagakerjaan` = '$bpjs_ktngkrjn', `masa_aktif_ketenagakerjaan` = '$ms_ktngkrjn', `jenjang` = '$jenjang' WHERE `id` = '$id' ";

		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();

		if ($imsgs) {

			$cek = 1;
		} else {
			$cek = 0;

			$id = null;
		}

		$vcode = array([
			"filedatas" => $cek,
			"id" => $id
		]);
		return $response->withJson($vcode, 200);
	});
	// end edit pegawai 

	// upload gambar pegawai 
	$app->post("/upload/gambar/user/{add}", function (Request $request, Response $response) {
		require 'link/hrd/linkGbr.php';
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$pict = $_FILES['foto']['tmp_name'];
		$pictNama = $_FILES['foto']['name'];
		if (!empty($pict)) {

			$temp = explode(".", $_FILES["foto"]["name"]);
			$namabaru = round(microtime(true)) . '.' . end($temp);

			$pengUpload = $gambarHRD . basename($pictNama);

			$lokasi = $gambarHRD . $namabaru;

			if (!move_uploaded_file($pict, $pengUpload)) {
				$cek = "move file";
			}
			if (!rename($pengUpload, $lokasi)) {
				$cek = "rename file";
			}

			$sql = "UPDATE `user_entity` SET `foto` = '$namabaru' WHERE `id` = '$id'";
			$imsgs = $this->db->prepare($sql);
			$imsgs->execute();
			$cek = 1;
		}
		$validasi = array([
			"validasi" => $cek
		]);
		return $response->withJson($validasi, 200);
	});
	// end upload gambar 

	// upload gambar edit 
	$app->post("/upld/gmbr/{add}", function (Request $request, Response $response) {
		require 'link/hrd/linkGbr.php';
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$pict = $_FILES['foto']['tmp_name'];
		$pictNama = $_FILES['foto']['name'];
		if (!empty($_FILES['foto']['tmp_name'])) {

			$sqlGbr = "SELECT `foto` FROM `user_entity` WHERE `id`='$id'";
			$exec = $this->db->prepare($sqlGbr);
			$exec->execute();
			$gbrLama = $exec->fetch();

			$temp = explode(".", $_FILES["foto"]["name"]);
			$namabaru = round(microtime(true)) . '.' . end($temp);
			$pengUpload = $gambarHRD . basename($_FILES['foto']['name']);
			$lokasi = $gambarHRD . $namabaru;

			$fileLama = $gbrLama['foto'];

			if ($fileLama == "" or $fileLama == null) {
			} else {
				unlink($gambarHRD . $fileLama);
			}

			if (!move_uploaded_file($_FILES['foto']['tmp_name'], $pengUpload)) {
				$cek = "move file";
			}
			if (!rename($pengUpload, $lokasi)) {
				$cek = "rename file";
			}

			$sql = "UPDATE `user_entity` SET `foto` = '$namabaru' WHERE `id` = '$id'";
			$imsgs = $this->db->prepare($sql);
			$imsgs->execute();
			$cek = 1;
		}
		$validasi = array([
			"validasi" => $cek
		]);
		return $response->withJson($validasi, 200);
	});
	// end upload gambar edit 

	// user non aktif 
	$app->put("/nonaktif/user/hrd/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "UPDATE `user_entity` SET `id_hidden` = '0'  WHERE `id` = '$id'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// end user non-aktif 

	// aktif user 
	$app->put("/aktifkan/orang/user/hrd/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		$sql = "UPDATE `user_entity` SET `id_hidden` = '1'  WHERE `id` = '$id'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});
	// end aktif user

	// view absensi 
	$app->get("/shw/absensi", function (Request $request, Response $response, $args) {
		$sql = "SELECT * FROM `absensi_hrd` ORDER BY tglawal_absensihrd DESC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();

		while ($result = $stmt->fetch()) {

			$dataready = $result['id_absensihrd'];
			require 'fuction/encript.php';
			$hasil = $ciphertext_base64;
			$h['biru'] = $hasil;
			$h['merah'] = $result['tglawal_absensihrd'];
			$h['jingga'] = $result['tglakhir_absensihrd'];
			$h['kuning'] = $result['file_absensihrd'];

			array_push($res, $h);
		}
		return $response->withJson($res, 200);
	});
	// end view absensi 

	// tambah absensi
	$app->post("/tambah/hrd/abesensi/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['usd'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$tglawal = $_POST['tglawal_absensihrd'];
		$tglakhir = $_POST['tglakhir_absensihrd'];

		$sql = "INSERT INTO `absensi_hrd` (`id_absensihrd`, `id`, `tglawal_absensihrd`, `tglakhir_absensihrd`, `file_absensihrd`)
			    VALUES (NULL, '$id', '$tglawal', '$tglakhir', '')";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();

		if ($imsgs) {

			$sqlId = "SELECT * FROM `absensi_hrd` ORDER BY id_absensihrd DESC LIMIT 1";
			$oghey = $this->db->prepare($sqlId);
			$oghey->execute();
			$roghey = $oghey->fetch();
			$dataready = $roghey['id_absensihrd'];
			require 'fuction/encript.php';
			$idv = $ciphertext_base64;

			$cek = 1;
			$ids = $idv;
		} else {
			$cek = 0;

			$ids = null;
		}

		$vcode = array([
			"filedatas" => $cek,
			"id" => $ids
		]);
		return $response->withJson($vcode, 200);
	});
	// end tambah absensi 

	// file upload absensi 
	$app->post("/upload/file/absensi/{add}", function (Request $request, Response $response) {
		require 'link/hrd/linkAbsen.php';
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$pict = $_FILES['file_absensihrd']['tmp_name'];
		$pictNama = $_FILES['file_absensihrd']['name'];
		if (!empty($pict)) {

			$temp = explode(".", $_FILES["file_absensihrd"]["name"]);
			$namabaru = round(microtime(true)) . '.' . end($temp);

			$pengUpload = $absenHRD . basename($pictNama);

			$lokasi = $absenHRD . $namabaru;

			if (!move_uploaded_file($pict, $pengUpload)) {
				$cek = "move file";
			}
			if (!rename($pengUpload, $lokasi)) {
				$cek = "rename file";
			}

			$sql = "UPDATE `absensi_hrd` SET `file_absensihrd` = '$namabaru' WHERE `id_absensihrd` = '$id'";
			$imsgs = $this->db->prepare($sql);
			$imsgs->execute();
			$cek = 1;
		}
		$validasi = array([
			"validasi" => $cek
		]);
		return $response->withJson($validasi, 200);
	});
	// end file upload absensi 

	// delete absensi 
	$app->delete("/absHps/absensi/{add}/", function (Request $request, Response $response, $args) {
		require 'link/hrd/linkAbsen.php';
		// $id = $_GET['id'];
		$postencript = $_GET['id_absensihrd'];
		require 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sqlFile = "SELECT `file_absensihrd` FROM `absensi_hrd` WHERE `id_absensihrd`='$id'";
		$exec = $this->db->prepare($sqlFile);
		$exec->execute();
		$fileOld = $exec->fetch();

		$fileLama = $fileOld['file_absensihrd'];

		if ($fileLama == "") {
		} else {
			unlink($absenHRD . $fileLama);
		}

		$sql = "DELETE FROM `absensi_hrd` WHERE `id_absensihrd` = '$id' ";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		$cek = 1;

		$validasi = array([
			"validasi" => $cek
		]);
		return $response->withJson($validasi, 200);
	});
	// end delete absensi 

	// view jadwal user 
	$app->get("/tampil/orang/jadwal/{view}", function (Request $request, Response $response, $args) {
		$sql = "SELECT * FROM `user_entity` WHERE `posisi1` = 'Karyawan'  ORDER BY `id` DESC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {
			$h['aban'] = $nn++;
			$dataready = $result['id'];
			require 'fuction/encript.php';
			$hasil = $ciphertext_base64;
			$h['abun'] = $hasil;
			$h['abon'] = $result['user_id'];
			$h['acas'] = $result['user_name'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end view jadwal user 

	// view jadwal dosen
	$app->get("/tampil/nama/dosen/jadwal/{view}", function (Request $request, Response $response, $args) {
		$sql = "SELECT * FROM `user_entity` WHERE `posisi1` = 'Dosen FTD' OR `posisi1`='Dosen FEB'  ORDER BY `id` DESC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {
			$h['aban'] = $nn++;
			$dataready = $result['id'];
			require 'fuction/encript.php';
			$hasil = $ciphertext_base64;
			$h['abun'] = $hasil;
			$h['abon'] = $result['user_id'];
			$h['acas'] = $result['user_name'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end view jadwal dosen 

	// detail jadwal hrd 
	$app->get("/detail/jadwal/hrd/{view}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `user_entity` WHERE `id` = '$id' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();

		while ($result = $stmt->fetch()) {

			$sql2 = "SELECT * FROM `jadwal_hrd` WHERE `id_user` = '$id' ORDER BY `id_jadwal` DESC";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$h['merah'] = $result['user_name'];
			$h['jingga'] = $result['posisi1'];
			$h['hitam'] = $result['posisi2'];
			$h['kuning'] = $result['status_dosen'];
			$h['ungu'] = $result['jurusan_dosen'];
			$h['putih'] = $result['nidn'];
			$h['st'] = $result2['status_jadwal'] ?? null;

			array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end detail jadwal hrd 

	// list jadwal view 
	$app->get("/jadwal/view/hrd/{view}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `jadwal_hrd` WHERE `id_user` = '$id' ORDER BY `hari` ASC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {

			$vhari = $result['hari'];
			if ($vhari == 1) {
				$hari = 'Senin';
			} elseif ($vhari == 2) {
				$hari = 'Selasa';
			} elseif ($vhari == 3) {
				$hari = 'Rabu';
			} elseif ($vhari == 4) {
				$hari = 'Kamis';
			} elseif ($vhari == 5) {
				$hari = 'Jumat';
			} elseif ($vhari == 6) {
				$hari = 'Sabtu';
			} else {
				$hari = 'Minggu';
			}

			$h['koceng'] = $nn++;
			$h['kerbau'] = $result['id_jadwal'];
			$h['dino'] = $result['id_user'];
			$h['sapi'] = $hari;
			$h['kambing'] = $result['jam'];
			$h['ayam'] = $result['absen_tempat'];
			$h['hiu'] = $result['status_jadwal'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end list jadwal view 

	// view jadwal hrd muncul 
	$app->get("/muncul/jadwal/hrd/{view}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$idus = trim($plaintext_dec);

		$sql2 = "SELECT * FROM `struktural`  WHERE `id` = '$idus' AND `id_hidden`='1' ";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();
		$struktural = $result2['id_rektor'];

		$sql = "SELECT DISTINCT `id_user`, `status_jadwal` FROM `jadwal_hrd` WHERE`status_jadwal` = '3' AND `id_struktural`='$struktural' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {
			$ids = $result['id_user'];
			$sql2 = "SELECT * FROM `user_entity` WHERE`id` = '$ids' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$h['no'] = $nn++;
			$h['ids'] = $result2['id'];
			$h['nm'] = $result2['user_name'];
			$h['sapi'] = $result['hari'];
			$h['st'] = $result['status_jadwal'];
			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// muncul jadwal di hrd end

	// tambah jadwal pegawai 
	$app->post("/tambah/jadwal/hrd/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		$hari = $_POST["hari"];
		$jam = $_POST["jam"];
		$absn = $_POST["absen_tempat"];

		$sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) 
		VALUES (NULL, '$id', '$hari', '$jam', '$absn', '3', '0')";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if ($stmt) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// end tambah jadwal pegawai 

	// edit jadwal pegawai 
	$app->post("/edit/jadwal/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$idj = $_GET['id_jadwal'];
		$hari = $_POST["hari"];
		$jam = $_POST["jam"];
		$absn = $_POST["absen_tempat"];

		$sql = "UPDATE `jadwal_hrd` SET `hari` = '$hari', `jam` = '$jam', `absen_tempat` = '$absn' WHERE `id_jadwal` = '$idj' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if ($stmt) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// end edit jadwal pegawai 

	// edit jadwal dosen
	$app->post("/edit/jadwal/dosen/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$idj = $_GET['id_jadwal'];
		$hari = $_POST["hari"];
		$jam = $_POST["jam"];
		$absn = $_POST["absen_tempat"];

		//ambil id_user dari jadwal yang diedit
		$sqlTampil = "SELECT * FROM `jadwal_hrd` WHERE id_jadwal = '$idj'";
		$sqlTampilExec = $this->db->prepare($sqlTampil);
		$sqlTampilExec->execute();
		$id_user_jadwal = $sqlTampilExec->fetch();
		//end ambil

		//rubah semua status_jadwal sesuai id_user yang diedit jadwalnya
		$sqlUpdate = "UPDATE `jadwal_hrd` SET status_jadwal = 0 WHERE id_user = '" . $id_user_jadwal['id_user'] . "'";
		$sqlUpdateExec = $this->db->prepare($sqlUpdate);
		$sqlUpdateExec->execute();

		$sql = "UPDATE `jadwal_hrd` SET `hari` = '$hari', `jam` = '$jam', `absen_tempat` = '$absn' WHERE `id_jadwal` = '$idj' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if ($stmt) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// end edit jadwal dosen

	// hapus jadwal pegawai  
	$app->delete("/hps/jadwal/hrd/{add}", function (Request $request, Response $response, $args) {
		$id = $_GET['id_jadwal'];

		$sql = "DELETE FROM `jadwal_hrd` WHERE `id_jadwal` = '$id' ";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();

		if ($imsgs) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$validasi = array([
			"validasi" => $cek
		]);
		return $response->withJson($validasi, 200);
	});
	// end hapus jadwal pegawai  

	// tambah jadwal dosen  
	$app->post("/insert/jadwal/dosen/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$hari = $_POST["hari"];
		$jam = $_POST["jam"];
		$absn = $_POST["absen_tempat"];

		$sql2 = "SELECT * FROM `user_entity`  WHERE `id` = '$id' ";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();
		$isdekan = $result2['posisi2'];

		if ($isdekan == "Dekan") {
			$stjadwal = 3;
		} else {
			$stjadwal = 0;
		}

		$sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) 
		VALUES (NULL, '$id', '$hari', '$jam', '$absn', '$stjadwal', '0')";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if ($isdekan != "Dekan") {
			$sqlUpdate = "UPDATE `jadwal_hrd` SET status_jadwal = 0, id_struktural = 0 WHERE id_user = '$id'";
			$sqlUpdateExec = $this->db->prepare($sqlUpdate);
			$sqlUpdateExec->execute();
		}

		if ($stmt) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// end tambah jadwal dosen 

	// hapus jadwal dosen 
	$app->delete("/hps/jadwal/dosen/{add}", function (Request $request, Response $response, $args) {
		$id = $_GET['id_jadwal'];

		//ambil id_user dari jadwal yang dihapus
		$sqlTampil = "SELECT * FROM `jadwal_hrd` WHERE id_jadwal = '$id'";
		$sqlTampilExec = $this->db->prepare($sqlTampil);
		$sqlTampilExec->execute();
		$id_user_jadwal = $sqlTampilExec->fetch();
		//end ambil

		//rubah semua status_jadwal sesuai id_user yang dihapus jadwalnya
		$sqlUpdate = "UPDATE `jadwal_hrd` SET status_jadwal = 0 WHERE id_user = '" . $id_user_jadwal['id_user'] . "'";
		$sqlUpdateExec = $this->db->prepare($sqlUpdate);
		$sqlUpdateExec->execute();

		$sql = "DELETE FROM `jadwal_hrd` WHERE `id_jadwal` = '$id' ";

		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();

		if ($imsgs) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$validasi = array([
			"validasi" => $cek
		]);
		return $response->withJson($validasi, 200);
	});
	// end hapus jadwal dosen 

	// pengajuan jadwal dosen
	$app->post("/ajukan/jadwal/dosen/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql2 = "SELECT * FROM `user_entity` WHERE `id` = '$id' ";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();
		$jur = $result2['jurusan_dosen'];

		if ($jur == "Manajemen") {
			$sqlm = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-PMB' AND `id_hidden`='1' ";
			$stmtm = $this->db->prepare($sqlm);
			$stmtm->execute();
			$resultm = $stmtm->fetch();
			$strukm = $resultm['id_rektor'];
			$kodeKPMJ = $resultm['id'];

			if ($kodeKPMJ == $id) {
				$getDekanFEB = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FEB' AND `id_hidden`='1' ";
				$prepsDekanFEB = $this->db->prepare($getDekanFEB);
				$prepsDekanFEB->execute();
				$dekanFEB = $prepsDekanFEB->fetch();
				$strukm = $dekanFEB['id_rektor'];
				$stMJ = 2;
			} else {
				$stMJ = 1;
			};

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '$stMJ', `id_struktural`= '$strukm' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		} elseif ($jur == "Akuntansi") {
			$sqla = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-AK' AND `id_hidden`='1' ";
			$stmta = $this->db->prepare($sqla);
			$stmta->execute();
			$resulta = $stmta->fetch();
			$struka = $resulta['id_rektor'];
			$kodeKPAK = $resulta['id'];

			if ($kodeKPAK == $id) {
				$getDekanFEB = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FEB' AND `id_hidden`='1' ";
				$prepsDekanFEB = $this->db->prepare($getDekanFEB);
				$prepsDekanFEB->execute();
				$dekanFEB = $prepsDekanFEB->fetch();
				$struka = $dekanFEB['id_rektor'];
				$stAK = 2;
			} else {
				$stAK = 1;
			};

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '$stAK', `id_struktural`= '$struka' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		} elseif ($jur == "Teknik Informatika") {
			$sqli = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-INF' AND `id_hidden`='1' ";
			$stmti = $this->db->prepare($sqli);
			$stmti->execute();
			$resulti = $stmti->fetch();
			$struki = $resulti['id_rektor'];
			$kodeKPTI = $resulti['id'];

			if ($kodeKPTI == $id) {
				$getDekanFTD = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FTD' AND `id_hidden`='1' ";
				$prepsDekanFTD = $this->db->prepare($getDekanFTD);
				$prepsDekanFTD->execute();
				$dekanFTD = $prepsDekanFTD->fetch();
				$struki = $dekanFTD['id_rektor'];
				$stTI = 2;
			} else {
				$stTI = 1;
			};

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '$stTI', `id_struktural`= '$struki' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		} elseif ($jur == "DKV") {
			$sqld = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-DKV' AND `id_hidden`='1' ";
			$stmtd = $this->db->prepare($sqld);
			$stmtd->execute();
			$resultd = $stmtd->fetch();
			$strukd = $resultd['id_rektor'];
			$kodeKPDKV = $resultd['id'];

			if ($kodeKPDKV == $id) {
				$getDekanFTD = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FTD' AND `id_hidden`='1' ";
				$prepsDekanFTD = $this->db->prepare($getDekanFTD);
				$prepsDekanFTD->execute();
				$dekanFTD = $prepsDekanFTD->fetch();
				$strukd = $dekanFTD['id_rektor'];
				$stDKV = 2;
			} else {
				$stDKV = 1;
			};

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '$stDKV', `id_struktural`= '$strukd' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		} elseif ($jur == "Magister Management") {
			$sqls2 = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'S2-MM' AND `ketkode_rektor` = 'Kaprodi Pascasarjana' AND `id_hidden`='1' ";
			$stmts2 = $this->db->prepare($sqls2);
			$stmts2->execute();
			$results2 = $stmts2->fetch();
			$struks2 = $results2['id_rektor'];
			$kodes2 = $results2['id'];

			if ($kodes2 == $id) {
				$getDekanFEB = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FEB' AND `id_hidden`='1' ";
				$prepsDekanFEB = $this->db->prepare($getDekanFEB);
				$prepsDekanFEB->execute();
				$dekanFEB = $prepsDekanFEB->fetch();
				$struks = $dekanFEB['id_rektor'];
				$sts2 = 2;
			} else {
				$sts2 = 1;
			};

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '$sts2', `id_struktural`= '$struks2' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		} else {
			$sqls = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-SK' AND `id_hidden`='1' ";
			$stmts = $this->db->prepare($sqls);
			$stmts->execute();
			$results = $stmts->fetch();
			$struks = $results['id_rektor'];
			$kodeKPSK = $results['id'];

			if ($kodeKPSK == $id) {
				$getDekanFTD = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FTD' AND `id_hidden`='1' ";
				$prepsDekanFTD = $this->db->prepare($getDekanFTD);
				$prepsDekanFTD->execute();
				$dekanFTD = $prepsDekanFTD->fetch();
				$struks = $dekanFTD['id_rektor'];
				$stSK = 2;
			} else {
				$stSK = 1;
			};

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '$stSK', `id_struktural`= '$struks' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		}

		if ($stmt) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// pengajuan jadwal dosen 

	// tampil jadwal di kaprodi 
	$app->get("/tampil/semua/hal/kapro/{view}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$idus = trim($plaintext_dec);

		$sql2 = "SELECT * FROM `struktural`  WHERE `id` = '$idus' AND `id_hidden`='1' ";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();
		$struktural = $result2['id_rektor'];

		$sql = "SELECT DISTINCT `id_user`, `status_jadwal` FROM `jadwal_hrd` WHERE`status_jadwal` = '1' AND `id_struktural`='$struktural' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {
			$ids = $result['id_user'];
			$sql2 = "SELECT * FROM `user_entity` WHERE`id` = '$ids' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();
			$h['no'] = $nn++;
			$dataready = $result2['id'];
			require 'fuction/encript.php';
			$ids = $ciphertext_base64;
			$h['ids'] = $ids;
			$h['nm'] = $result2['user_name'];
			$h['st'] = $result['status_jadwal'];
			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end tampil jadwal kaprodi 

	// tampil jadwal di dekan 
	$app->get("/tam/jadwal/dekan/{view}", function (Request $request, Response $response, $args) {

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$idus = trim($plaintext_dec);

		$sql2 = "SELECT * FROM `struktural`  WHERE `id` = '$idus' AND `id_hidden`='1' ";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();
		$struktural = $result2['id_rektor'];

		$sql = "SELECT DISTINCT `id_user`, `status_jadwal` FROM `jadwal_hrd` WHERE`status_jadwal` = '2' AND `id_struktural`='$struktural' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {
			$ids = $result['id_user'];

			$sql2 = "SELECT * FROM `user_entity` WHERE`id` = '$ids' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$h['no'] = $nn++;
			$dataready = $result2['id'];
			require 'fuction/encript.php';
			$ids = $ciphertext_base64;
			$h['ids'] = $ids;
			$h['nm'] = $result2['user_name'];
			$h['st'] = $result['status_jadwal'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end tampil jadwal di dekan 

	// detail jadwal di kaprodi  
	$app->get("/detail/jadwal/kaprodi/peruser/{view}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `jadwal_hrd` WHERE `id_user` = '$id' AND `status_jadwal`= '1' ORDER BY `hari` ASC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {

			$sql2 = "SELECT * FROM `user_entity` WHERE `id` = '$id' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$vhari = $result['hari'];
			if ($vhari == 1) {
				$hari = 'Senin';
			} elseif ($vhari == 2) {
				$hari = 'Selasa';
			} elseif ($vhari == 3) {
				$hari = 'Rabu';
			} elseif ($vhari == 4) {
				$hari = 'Kamis';
			} elseif ($vhari == 5) {
				$hari = 'Jumat';
			} elseif ($vhari == 6) {
				$hari = 'Sabtu';
			} else {
				$hari = 'Minggu';
			}

			$h['koceng'] = $nn++;
			$h['kerbau'] = $result['id_jadwal'];
			$h['kelinci'] = $result2['user_name'];
			$h['sapi'] = $hari;
			$h['kambing'] = $result['jam'];
			$h['ayam'] = $result['absen_tempat'];
			$h['st'] = $result['status_jadwal'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end detail jadwal di kaprodi

	// acc kaprodi jadwal
	$app->post("/ajukan/jdwl/kaprodi/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql2 = "SELECT * FROM `user_entity`  WHERE `id` = '$id' ";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();
		$jur = $result2['jurusan_dosen'];

		if ($jur == "Manajemen" or $jur == "Akuntansi" or $jur == "Magister Management") {
			$sqlm = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FEB' AND `id_hidden`='1' ";
			$stmtm = $this->db->prepare($sqlm);
			$stmtm->execute();
			$resultm = $stmtm->fetch();
			$strukm = $resultm['id_rektor'];

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '2', `id_struktural`='$strukm' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		} else {
			$sqld = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FTD' AND `id_hidden`='1' ";
			$stmtd = $this->db->prepare($sqld);
			$stmtd->execute();
			$resultd = $stmtd->fetch();
			$strukd = $resultd['id_rektor'];

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '2', `id_struktural`='$strukd' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		}


		if ($stmt) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// end acc kaprodi jadwal 

	// acc dekan jadwal 
	$app->post("/updet/jdw/dekan/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sqlm = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'HRD' AND `id_hidden`='1' ";
		$stmtm = $this->db->prepare($sqlm);
		$stmtm->execute();
		$resultm = $stmtm->fetch();
		$strukm = $resultm['id_rektor'];

		$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '3', `id_struktural`='$strukm' WHERE `id_user` = '$id' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if ($stmt) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// acc dekan jadwal end 

	// tolak kaprodi dan dekan jadwal
	$app->post("/tidak/setuju/jadwal/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '0' WHERE `id_user` = '$id' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if ($stmt) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	// tolak jadwal kaprodi dan dekan end

	// view izin dosen
	$app->get("/tabel/dosen/izin", function (Request $request, Response $response, $args) {
		$sql = "SELECT * FROM `user_entity` WHERE `posisi1` = 'Dosen FTD' OR `posisi1`='Dosen FEB'  ORDER BY `id` DESC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();

		while ($result = $stmt->fetch()) {
			$dataready = $result['id'];
			$idDecrypt = $result['id'];
			require 'fuction/encript.php';
			$id = $ciphertext_base64;

			$getCountIzin = "SELECT COUNT(*) as 'num' FROM izin_hrd WHERE id_user = '$idDecrypt' AND status_izin = 3";
			$prepsCountIzin = $this->db->prepare($getCountIzin);
			$prepsCountIzin->execute();
			$numIzin = $prepsCountIzin->fetch();

			$h['id'] = $id;
			$h['nopeg'] = $result['user_id'];
			$h['nama'] = $result['user_name'];
			$h['divisi'] = $result['posisi1'];
			$h['jumlah_izin'] = $numIzin;

			array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end view izin dosen

	// detail izin dosen 
	$app->get("/detail/izin/dosen", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `user_entity` WHERE `id` = '$id' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();

		while ($result = $stmt->fetch()) {
			$getIzin = "SELECT * FROM `izin_hrd` WHERE `id_user` = '$id' ORDER BY tgl_dibuat DESC";
			$prepsListIzin = $this->db->prepare($getIzin);
			$prepsListIzin->execute();
			$listIzin = $prepsListIzin->fetchAll();

			$h['nama'] = $result['user_name'];
			$h['fakultas'] = $result['posisi1'];
			$h['prodi'] = $result['jurusan_dosen'];
			$h['status_dosen'] = $result['status_dosen'];
			$h['list_izin'] = $listIzin;

			array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	// end detail izin dosen
	
	//tambah izin dosen
	$app->post("/tambah/izin/{dosen}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `user_entity` WHERE `id` = '$id' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		while ($result = $stmt->fetch()) {
			$_POST = json_decode(file_get_contents("php://input"), true);
			$id_user = $id;
			$tgl_mulai = $_POST["tgl_mulai"];
			$tgl_akhir = $_POST['tgl_akhir'];
			$alasan = $_POST['alasan'];
			$lama_izin = $_POST['lama_izin'];
			$acc1 = "";
			$acc2 = "";
			$ambilJurusan = $result['jurusan_dosen'];
			if($ambilJurusan == "Teknik Informatika"){
				$queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-INF'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE ketkode_rektor = 'Dekan FTD'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			}else if($ambilJurusan == "Sistem Komputer"){
			    $queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-SK'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE ketkode_rektor = 'Dekan FTD'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			}else if($ambilJurusan == "DKV"){
			    $queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-DKV'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE ketkode_rektor = 'Dekan FTD'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			}else if($ambilJurusan == "Manajemen"){
			    $queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-PMB'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE ketkode_rektor = 'Dekan FEB'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			}else if($ambilJurusan == "Akuntansi"){
			    $queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-AK'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE ketkode_rektor = 'Dekan FEB'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			}else{
			    $queryDosen = "SELECT * FROM struktural WHERE ketkode_rektor = 'Kaprodi Pascasarjana'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE ketkode_rektor = 'Direktur Pascasarjana'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			}
			$tambahIzin = "INSERT INTO izin_hrd VALUES(0,'$id_user','$tgl_mulai','$tgl_akhir','$lama_izin','$alasan','$acc1','$acc2',1)";
			$stmtTambah = $this->db->prepare($tambahIzin);
			$stmtTambah->execute();
			if($stmtTambah){
				return $response->withStatus(200);
			}
		}
		
	});
	//end tambah dosen

	//edit izin dosen
	$app->post("/edit/izin/{dosen}", function (Request $request, Response $response, $args) {

			$_POST = json_decode(file_get_contents("php://input"), true);
			$id_izin = $_POST['id_izin'];
			$tgl_mulai = $_POST["tgl_mulai"];
			$tgl_akhir = $_POST['tgl_akhir'];
			$alasan = $_POST['alasan'];
			$lama_izin = $_POST['lama_izin'];
			$editIzin = "UPDATE izin_hrd SET tgl_mulai = '$tgl_mulai', tgl_akhir = '$tgl_akhir', alasan = '$alasan', lama_izin = '$lama_izin' WHERE id_izin = '$id_izin'";
			$stmtEdit = $this->db->prepare($editIzin);
			$stmtEdit->execute();
			if($stmtEdit){
				return $response->withStatus(200);
			}
	});
	//end edit izin dosen

	//hapus izin dosen
	$app->delete("/hapus/izin/{dosen}", function (Request $request, Response $response, $args) {
		$id_izin = $_GET['id_izin'];
		$stmtHapus = "DELETE FROM izin_hrd WHERE id_izin = '$id_izin'";
		$stmt = $this->db->prepare($stmtHapus);
		$stmt->execute();

		return $response->withStatus(200);
	});
	//end hapus izin dosen

	//view acc1 dosen
	$app->get("/detail/izin/{kaprodi}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		$id_rektor = "SELECT id_rektor FROM struktural WHERE id = '$id' AND id_hidden = 1";
		$stmtIdRektor = $this->db->prepare($id_rektor);
		$stmtIdRektor->execute();
		$dataIdRektor = $stmtIdRektor->fetch();
		$sql = "SELECT * FROM `izin_hrd` WHERE `acc1` = '".$dataIdRektor['id_rektor']."' AND `status_izin` = '1' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
 
		while ($result = $stmt->fetch()) {

			$h['id_izin'] = $result['id_izin'];
			$h['id_user'] = $result['id_user'];
			$h['tgl_mulai'] = $result['tgl_mulai'];
			$h['tgl_akhir'] = $result['tgl_akhir'];
			$h['lama_izin'] = $result['lama_izin'];
			$h['alasan'] = $result['alasan'];
			$h['status_izin'] = $result['status_izin'];

			array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	//end view acc1 dosen

	//view acc2 dosen
	$app->get("/detail/izin/dosen/{dekan}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		$id_rektor = "SELECT id_rektor FROM struktural WHERE id = '$id' AND id_hidden = 1";
		$stmtIdRektor = $this->db->prepare($id_rektor);
		$stmtIdRektor->execute();
		$dataIdRektor = $stmtIdRektor->fetch();
		$sql = "SELECT * FROM `izin_hrd` WHERE `acc2` = '".$dataIdRektor['id_rektor']."' AND `status_izin` = '2' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
 
		while ($result = $stmt->fetch()) {

			$h['id_izin'] = $result['id_izin'];
			$h['id_user'] = $result['id_user'];
			$h['tgl_mulai'] = $result['tgl_mulai'];
			$h['tgl_akhir'] = $result['tgl_akhir'];
			$h['lama_izin'] = $result['lama_izin'];
			$h['alasan'] = $result['alasan'];
			$h['status_izin'] = $result['status_izin'];

			array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	//end view acc2 dosen

	//setujui izin dosen di kaprodi
	$app->put("/setujui/izin/dosen/{kaprodi}", function (Request $request, Response $response, $args) {
	$id_izin = $_GET['id_izin'];
	$sql = "UPDATE izin_hrd SET status_izin = 2 WHERE id_izin = '$id_izin'";
	$stmt = $this->db->prepare($sql);
	$stmt->execute();
	return $response->withStatus(200);
	});
	//end setujui izin kaprodi

	//tolak izin dosen
	$app->put("/tolak/izin/{dosen}", function (Request $request, Response $response, $args) {
		$id_izin = $_GET['id_izin'];
		$sql = "UPDATE izin_hrd SET status_izin = 0 WHERE id_izin = '$id_izin'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $response->withStatus(200);
	});
	//end tolak izin

	//setujui izin dosen di dekan
	$app->put("/setujui/dosen/{dekan}", function (Request $request, Response $response, $args) {
		$id_izin = $_GET['id_izin'];
		$sql = "UPDATE izin_hrd SET status_izin = 3 WHERE id_izin = '$id_izin'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		return $response->withStatus(200);
	});
	//end setujui izin dekan

	//tambah izin dosen

	$app->post("/tambah/izin/{dosen}/", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `user_entity` WHERE `id` = '$id' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		while ($result = $stmt->fetch()) {
			$_POST = json_decode(file_get_contents("php://input"), true);
			$id_user = $id;
			$tgl_mulai = $_POST["tgl_mulai"];
			$tgl_akhir = $_POST['tgl_akhir'];
			$alasan = $_POST['alasan'];
			$lama_izin = $_POST['lama_izin'];
			$acc1 = "";
			$acc2 = "";
			$ambilJurusan = $result['jurusan_dosen'];
			if ($ambilJurusan == "Teknik Informatika") {
				$queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-INF'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE rektor_id = 'FTD'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			} else if ($ambilJurusan == "Sistem Komputer") {
				$queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-SK'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE rektor_id = 'FTD'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			} else if ($ambilJurusan == "DKV") {
				$queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-DKV'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE rektor_id = 'FTD'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			} else if ($ambilJurusan == "Manajemen") {
				$queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-PMB'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE rektor_id = 'FEB'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			} else if ($ambilJurusan == "Akuntansi") {
				$queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'KP-AK'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE rektor_id = 'FEB'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			} else {
				$queryDosen = "SELECT * FROM struktural WHERE rektor_id = 'S2-MM'";
				$stmtDosen = $this->db->prepare($queryDosen);
				$stmtDosen->execute();
				$resultDosen = $stmtDosen->fetch();
				$acc1 = $resultDosen['id_rektor'];

				$queryDekan = "SELECT * FROM struktural WHERE rektor_id = 'FEB'";
				$stmtDekan = $this->db->prepare($queryDekan);
				$stmtDekan->execute();
				$resultDekan = $stmtDekan->fetch();
				$acc2 = $resultDekan['id_rektor'];
			}
			$tambahIzin = "INSERT INTO izin_hrd VALUES(0,'$id_user','$tgl_mulai','$tgl_akhir','$lama_izin','$alasan','$acc1','$acc2',0)";
			$stmtTambah = $this->db->prepare($tambahIzin);
			$stmtTambah->execute();
			if ($stmtTambah) {
				return $response->withStatus(200);
			} else {
				return $response->withStatus(666);
			}
		}
	});

	//end tambah dosen

	// login astor hrd 
	$app->get("/hrd/sign/id/{cari}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT id AS hd, user_id AS ud FROM `user_entity` WHERE id='$id' ORDER BY `id` DESC LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		return $response->withJson($res, 200);
	});

	$app->get("/hrd/aks/cari/{vvv}", function (Request $request, Response $response) {
		$postencript = $_GET['ak'];
		include 'fuction/decript.php';
		$idm = trim($plaintext_dec);
		$sql = "SELECT * FROM `level_detail` WHERE level_id='$idm' ORDER BY `id` DESC LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();
		return $response->withJson($res, 200);
	});
	// end login astor hrd 

	// menu hrd 
	$app->get("/sidebar/menu/hrd/{v}", function (Request $request, Response $response, $args) {
		$idus = $_GET['id'];
		$ak = $_GET['ak'];
		$sql1 = "SELECT user_entity.id, level_detail.grub_id, user_grub.nama_grup, rule2.id_rule2, rule2.menu_id, menu.menu_id AS idmenu, menu.menu_name AS mgname, menu.link AS mslink, menu.idm AS ckstm, menu.sub_menu_id, menu.aplikasi_id, aplikasi.nama_aplikasi, aplikasi.id_hidden FROM user_entity JOIN level_detail ON user_entity.id=level_detail.id JOIN user_grub ON level_detail.grub_id=user_grub.grub_id JOIN rule2 ON level_detail.grub_id=rule2.grub_id JOIN menu ON rule2.menu_id=menu.menu_id JOIN aplikasi ON menu.aplikasi_id=aplikasi.aplikasi_id where level_detail.level_id='$ak' AND user_entity.id='$idus' AND aplikasi.id_hidden='1' AND `idm` = 'grup'";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();

		$res = array();
		$n = 1;
		while ($rstmt1 = $stmt1->fetch()) {
			$menuid = $rstmt1['menu_id'];
			$sql2 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$menuid' AND `aplikasi_id` = 4 AND `idm` = 'sub' AND `id_hidden` = 1";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();

			$arr = array();
			$nosub = 1;
			while ($rstmt2 = $stmt2->fetch()) {
				$h2['mnid'] = $rstmt2['menu_id'];
				$h2['mnnm'] = $rstmt2['menu_name'];
				$h2['linknya'] = $rstmt2['link'];

				$a = array_push($arr, $h2);
			}

			$h['n'] = $n++;

			$dataready = $rstmt1['idmenu'];
			require 'fuction/encript.php';
			$idme = $ciphertext_base64;
			$h['mid'] = $idme;
			$h['gmenu'] = $rstmt1['mgname'];
			$h['smenu'] = $arr;
			$a = array_push($res, $h);
		}
		return $response->withJson($res, 200);
	});
	// end menu hrd 

	// ================================================================= end HRD aps =============================================== 
};
