<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
	$container = $app->getContainer();

	//================================================== TEST CODE ========================================//
	$app->get("/test", function (Request $request, Response $response, $args) {
		echo "Sukses Neng....!";
		// SELECT * FROM level_detail JOIN user_grub ON level_detail.nama_grup=user_grub.nama_grup WHERE level_detail.id=1;
	});

	$app->get("/seting/user/acses/kanan/{view}", function (Request $request, Response $response, $args) {
		$sql = "SELECT * FROM `aplikasi` ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();
		while ($result = $stmt->fetch()) {
			$query1 = "SELECT * FROM `menu` WHERE  `idm`='grup'";
			$asrt = $this->db->prepare($query1);
			$asrt->execute();
			while ($result2 = $asrt->fetch()) {
				$grd = $result2['menu_id'];
				$querys = "SELECT `menu_id`,`menu_name` FROM `menu` WHERE `sub_menu_id`='$grd' AND `idm`='sub'";
				$asrts = $this->db->prepare($querys);
				$asrts->execute();
				$result3 = $asrts->fetchAll();

				$h['aplikasi_id'] = $result['aplikasi_id'];
				$h['nama_aplikasi'] = $result['nama_aplikasi'];
				$h['grup_menu'] = $result2['menu_name'];
				$h['sub_menu'] = $result3;

				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
	});

	//================================================== ADMINISTRATOR ========================================//
	//----------------------------- LOGIN AKUN -----------------------------//
	//-------------------------- LOGIN AKUN ADMINISTRATOR --------------------------//
	$app->post("/login/{ul}", function (Request $request, Response $response, $args) {
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
	// ----------------------------- Login Surat Rektorat, Lembaga, Admin -----------------------------//
	$app->post("/login/staf/surat/{ul}", function (Request $request, Response $response, $args) {
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
					"filedatas" => '0'
				]);
			}
		} else {
			$vcode = array([
				"filedatas" => "0a"
			]);
		}

		return $response->withJson($vcode, 200);
		// json_encode($response);
	});
	// ------------------------------- Login KUI -----------------------------------------//
	$app->post("/kui/login/{ul}", function (Request $request, Response $response, $args) {
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

	//-------------------------- VIEW --------------------------//

	$app->get("/pass/deff/enkrp/{v}", function (Request $request, Response $response, $args) {

		$pass = date('sMys');
		$vcode = array([
			"pass" => $pass
		]);

		return $response->withJson($vcode, 200);
	});

	$app->get("/surat/search/lv/{inview}", function (Request $request, Response $response, $args) {
		$idus = $_GET['uid'];
		$sql = "SELECT * FROM `level_detail` where id='$idus'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		$sql2a = "SELECT * FROM `level_detail` where id='$idus'";
		$stmt2a = $this->db->prepare($sql2a);
		$stmt2a->execute();
		$rstmt2a = $stmt2a->fetch();
		$nstmt2a = $stmt2a->rowCount();

		if ($nstmt2a == "") {
			$ak = 0;
		} else {
			if ($rstmt2a['level_id'] == 0) {
				$ak = 1;
			} else {
				$ak = 0;
			}
		}

		$dataready = $ak;
		require 'fuction/encript.php';
		$acc = $ciphertext_base64;

		$sql2 = "SELECT * FROM `user_entity` where id='$idus'";
		//$sql="SELECT * FROM sent_letter where id_hidden=1";
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
			'lv' => $result,
			'aks' => $acc,
			'user_id' => $usid,
			'user_nama' => $result2['user_name'],
			'usid' => $usid2id
		]);

		return $response->withJson($vcode, 200);
	});
	$app->get("/user_entiti/lv/{view}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM user_entity ORDER BY `id` ASC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		while ($result = $stmt->fetch()) {

			if ($result['id_hidden'] == 1) {
				$gh = 1;
			} else {
				$gh = 2;
			}
			if ($result['id'] == 1) {
				$on = 0;
			} else {
				$on = 1;
			}

			// $h['gmenu'] = $result2['menu_name'];
			$h['groub_hidden'] = $gh;
			$h['on_off'] = $on;

			$h['id'] = $result['id'];
			$h['user_id'] = $result['user_id'];
			$h['user_name'] = $result['user_name'];
			$h['user_password'] = $result['user_password'];
			$h['user_pass_def'] = $result['user_pass_def'];
			$h['nidn'] = $result['nidn'];
			$h['id_hidden'] = $result['id_hidden'];

			$a = array_push($res, $h);
		}
		return $response->withJson($res, 200);
		// json_encode($response);
	});
	$app->get("/administrator/level/all/{view}", function (Request $request, Response $response, $args) {
		//$un=$_SESSION['uptasia_appall'];
		//$sql = "SELECT * FROM user_entity where user_name='$un'";
		$sql = "SELECT * FROM `divisi`";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();
		while ($result = $stmt->fetch()) {

			$h['divisi_id'] = $result['divisi_id'];
			$h['divisi_name'] = $result['divisi_name'];
			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
		// json_encode($response);
	});
	$app->get("/menu/lw/{view}", function (Request $request, Response $response, $args) {
		//$un=$_SESSION['uptasia_appall'];
		//$sql = "SELECT * FROM user_entity where user_name='$un'";

		$sql = "SELECT * FROM menu";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $response->withJson($result, 200);
		// json_encode($response);
	});
	$app->get("/menu/grub/caca/lv/{view}", function (Request $request, Response $response, $args) {

		$sql = "SELECT menu.menu_id, menu.menu_name, menu.id_hidden AS m, aplikasi.id_hidden AS a, aplikasi.aplikasi_id, aplikasi.nama_aplikasi FROM `menu`INNER JOIN `aplikasi`ON menu.aplikasi_id=aplikasi.aplikasi_id WHERE `idm`='grup'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();
		while ($result = $stmt->fetch()) {

			if ($result['a'] == 1) {
				$gh = 1;
			} else {
				$gh = 2;
			}

			$h['grub_hidden'] = $gh;
			$h['menu_id'] = $result['menu_id'];
			$h['menu_name'] = $result['menu_name'];
			$h['id_hidden'] = $result['m'];
			$h['aplikasi_id'] = $result['aplikasi_id'];
			$h['nama_aplikasi'] = $result['nama_aplikasi'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	$app->get("/sub/grub/menu/lz/{view}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM `menu`WHERE `idm`='sub' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		// $result = $stmt->fetchAll();

		$res = array();
		while ($result = $stmt->fetch()) {
			$tarica = $result['sub_menu_id'];
			if ($tarica == "-" or $tarica == "") {
			} else {
				$sql2 = "SELECT * FROM `menu` WHERE `menu_id` = '$tarica'";
				$stmt2 = $this->db->prepare($sql2);
				$stmt2->execute();
				$result2 = $stmt2->fetch();

				if ($result2['id_hidden'] == 1) {
					$gh = 1;
				} else {
					$gh = 2;
				}

				$h['gmenu'] = $result2['menu_name'];
				$h['groub_hidden'] = $gh;

				$h['menu_id'] = $result['menu_id'];
				$h['menu_name'] = $result['menu_name'];
				$h['link'] = $result['link'];
				$h['sub_menu_id'] = $result['sub_menu_id'];
				$h['aplikasi_id'] = $result['aplikasi_id'];
				$h['id_hidden'] = $result['id_hidden'];

				$h['idm'] = $result['idm'];

				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
	});
	$app->get("/surat/Log/Surat/{view}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';

		$a = "$host_api_surat/surat/Log/Surat/view?$key_api_surat";
		$b = file_get_contents($a);
		$c = json_decode($b);
		$d = count($c);
		$t = $c[0];

		$res = array();
		for ($i = 0; $i < $d; $i++) {
			$iduser = $c[$i]->id;
			$sql = "SELECT id, user_name FROM `user_entity` where id='$iduser'";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch();

			$h['id'] = $c[$i]->id;
			$h['user_name'] = $result['user_name'];
			$h['Log_id'] = $c[$i]->Log_id;
			$h['Log_date'] = $c[$i]->Log_date;
			$h['Log_action'] = $c[$i]->Log_action;
			$h['Log_id'] = $c[$i]->Log_id;
			$a = array_push($res, $h);
		}

		// echo $res;
		return $response->withJson($res, 200);
	});
	$app->get("/surat/Log/Surat/dicoba/{json}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';

		$sql = "SELECT id, user_name FROM `user_entity`";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		// $result = $stmt->fetchAll();
		$res = array();
		while ($result = $stmt->fetch()) {
			$h['id'] = $result['id'];
			// $h['user_id'] = $result['user_id'];
			$h['user_name'] = $result['user_name'];
			// $h['nidn'] = $result['nidn'];
			// $h['id_hidden'] = $result['id_hidden'];
			// $h['id'] = $result['id'];
			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	$app->get("/surat/user/react/select/{json}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';

		$sql = "SELECT id, user_name FROM `user_entity`";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		// $result = $stmt->fetchAll();
		$res = array();
		while ($result = $stmt->fetch()) {
			$h['id'] = $result['id'];
			// $h['user_id'] = $result['user_id'];
			$h['label'] = $result['user_name'];
			// $h['nidn'] = $result['nidn'];
			// $h['id_hidden'] = $result['id_hidden'];
			// $h['id'] = $result['id'];
			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	$app->get('/test/taricha/{view}', function (Request $request, Response $response, array $args) use ($container) {
		include 'link/surat/link_surat.php';

		$a = "$host_api_surat/surat/Log/Surat/view?$key_api_surat";
		$b = file_get_contents($a);
		$c = json_decode($b);
		$d = count($c);
		$t = $c[0];

		$res = array();
		for ($i = 0; $i < $d; $i++) {
			$iduser = $c[$i]->id;
			$sql = "SELECT id, user_name FROM `user_entity` where id='$iduser' order by id DESC";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch();

			$h['id'] = $c[$i]->id;
			$h['user_name'] = $result['user_name'];
			$h['Log_id'] = $c[$i]->Log_id;
			$h['Log_date'] = $c[$i]->Log_date;
			$h['Log_action'] = $c[$i]->Log_action;
			// $h['Log_id'] = $c[$i]->Log_id;
			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	$app->get("/cari/id/user/seleketep/{view}", function (Request $request, Response $response, $args) {
		$id = $_GET["idus"];
		$sql = "SELECT * FROM user_entity WHERE id='$id' ORDER BY `user_id` DESC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $response->withJson($result, 200);
	});
	$app->get("/administrator/level/adit/akses/all/{v}", function (Request $request, Response $response, $args) {
		//$un=$_SESSION['uptasia_appall'];
		//$sql = "SELECT * FROM user_entity where user_name='$un'";
		$sql = "SELECT * FROM `level`";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		// $result = $stmt->fetchAll();

		$res = array();
		while ($result = $stmt->fetch()) {
			if ($result['level_id'] == 0) {
			} else {
				$h['level_id'] = $result['level_id'];
				$h['level_name'] = $result['level_name'];
				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
		// json_encode($response);
	});
	$app->get("/aplikasi/tampil/ok/{v}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM `aplikasi` WHERE `aplikasi_id`!= 0";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $response->withJson($result, 200);
		// json_encode($response);
	});
	$app->get("/aplikasi/admin/wkwk/{view}", function (Request $request, Response $response, $args) {
		$id_aps = $_GET['idacc'];

		$sql = "SELECT * FROM `aplikasi` WHERE `id_hidden` = 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();
		while ($result = $stmt->fetch()) {
			$idap = $result['aplikasi_id'];

			$sql2 = "SELECT * FROM `rule` WHERE `aplikasi_id` = '$idap' AND `level_id` = '$id_aps'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$nsmt2 = $stmt2->rowCount();
			if ($idap == 0) {
			} else {

				if ($nsmt2 == 0) {
					$result2 = $stmt2->fetch();
					$idrl = $result2['id_rule'];
					$as = 0;
				} else {
					$result2 = $stmt2->fetch();
					$idrl = $result2['id_rule'];
					$as = 1;
				}

				$h['aplikasi_id'] = $result['aplikasi_id'];
				$h['id_rule'] = $idrl;
				$h['lv_id'] = $id_aps;
				$h['nama_aplikasi'] = $result['nama_aplikasi'];
				$h['id_hidden'] = $result['id_hidden'];
				$h['btn'] = $as;
				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
		// WHERE aplikasi_id='$id_aps' ORDER BY `aplikasi_id` DESC
	});
	$app->get("/aplikasi/per/id/{view}", function (Request $request, Response $response, $args) {
		// $id_aps = $_GET['aplikasi_id'];
		$aplikasi_id = $_GET["aplikasi_id"];
		if ($aplikasi_id == 0) {
		} else {

			$sql2 = "SELECT * FROM `aplikasi` WHERE `aplikasi_id`='$aplikasi_id'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();
		}
		return $response->withJson($result2, 200);
		// WHERE aplikasi_id='$id_aps' ORDER BY `aplikasi_id` DESC
	});
	$app->get("/usr/entiti/tiap/id/{view}", function (Request $request, Response $response, $args) {
		$id = $_GET["id"];
		if ($id == 0) {
		} else {

			$sql2 = "SELECT * FROM `user_entity` WHERE `id`='$id'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();
		}
		return $response->withJson($result2, 200);
	});
	$app->get("/grub/tiap/ids/{view}", function (Request $request, Response $response, $args) {
		// $id_aps = $_GET['aplikasi_id'];
		$menu_id = $_GET["menu_id"];
		$sql = "SELECT menu.menu_id, menu.menu_name, aplikasi.aplikasi_id, aplikasi.nama_aplikasi FROM `menu` INNER JOIN `aplikasi`ON menu.aplikasi_id=aplikasi.aplikasi_id WHERE `menu_id`= '$menu_id' AND `idm`='grup' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result2 = $stmt->fetch();

		return $response->withJson($result2, 200);
	});
	$app->get("/sub/di/idu/{view}", function (Request $request, Response $response, $args) {
		// $id_aps = $_GET['aplikasi_id'];
		$menu_id = $_GET["menu_id"];
		$sql = "SELECT * FROM `menu` WHERE `menu_id`= '$menu_id' AND `idm`='sub' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		while ($result = $stmt->fetch()) {
			$tarica = $result['sub_menu_id'];
			if ($tarica == "-" or $tarica == "") {
			} else {
				$sql2 = "SELECT * FROM `menu` WHERE `menu_id` = '$tarica'";
				$stmt2 = $this->db->prepare($sql2);
				$stmt2->execute();
				$result2 = $stmt2->fetch();
				$h['gmenu'] = $result2['menu_name'];

				$h['menu_id'] = $result['menu_id'];
				$h['menu_name'] = $result['menu_name'];
				$h['link'] = $result['link'];
				$h['sub_menu_id'] = $result['sub_menu_id'];
				$h['aplikasi_id'] = $result['aplikasi_id'];
				$h['idm'] = $result['idm'];

				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
		// WHERE aplikasi_id='$id_aps' ORDER BY `aplikasi_id` DESC
	});
	$app->get("/struktural/saben/idr/{view}", function (Request $request, Response $response, $args) {
		$idr = $_GET["id_rektor"];
		if ($idr == 0) {
		} else {

			$sql2 = "SELECT * FROM `struktural` WHERE `id_rektor`='$idr'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();
		}
		return $response->withJson($result2, 200);
	});
	$app->get("/menusis/tari/admin/{view}", function (Request $request, Response $response, $args) {
		// $id_lev = $_GET['level_id'];

		$sql = "SELECT * FROM `level` ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		while ($result = $stmt->fetch()) {
			$id_lev = $result['level_id'];
			$sql1 = "SELECT * FROM `rule` JOIN `aplikasi` ON rule.aplikasi_id=aplikasi.aplikasi_id WHERE `level_id`='$id_lev' ";
			$stmt1 = $this->db->prepare($sql1);
			$stmt1->execute();
			$result1 = $stmt1->fetchAll();

			$h['level_id'] = $result['level_id'];
			$h['level_name'] = $result['level_name'];
			$h['id_hidden'] = $result['id_hidden'];
			$h['woy'] = $result1;

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	$app->get("/user/grub/lw/{view}", function (Request $request, Response $response, $args) {

		$sql = "SELECT level_detail.id_urt, level_detail.level_id, level_detail.nama_grup, level_detail.id_hidden AS l, user_entity.id_hidden AS u, user_entity.id, user_entity.user_id, user_entity.user_name  FROM `level_detail` JOIN `user_entity` ON level_detail.id=user_entity.id ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();
		while ($result = $stmt->fetch()) {
			$id_lev = $result['level_id'];

			$sql2 = "SELECT *  FROM `level` WHERE `level_id`='$id_lev' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			if ($result['u'] == 1) {
				$gh = 1;
			} else {
				$gh = 2;
			}

			$h['id_urt'] = $result["id_urt"];
			$h['nama_grup'] = $result["nama_grup"];
			$h['user_id'] = $result["user_id"];
			$h['user_name'] = $result["user_name"];
			$h['groub_hidden'] = $gh;
			$h['level_id'] = $result2["level_id"];
			$h['level_name'] = $result2["level_name"];
			$h['id_hidden'] = $result['l'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	$app->get("/user/gb/duo/{view}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM `user_grub` ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();
		while ($result = $stmt->fetch()) {
			$id_lev = $result['level_id'];

			$sql2 = "SELECT *  FROM `level` WHERE `level_id`='$id_lev' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			if ($result2['id_hidden'] == 1) {
				$gh = 1;
			} else {
				$gh = 2;
			}

			$h['grub_id'] = $result["grub_id"];
			$h['nama_grup'] = $result["nama_grup"];
			// $h['user_id'] = $result["user_id"];
			// $h['user_name'] = $result["user_name"];
			$h['groub_hidden'] = $gh;
			$h['level_id'] = $result2["level_id"];
			$h['level_name'] = $result2["level_name"];
			$h['id_hidden'] = $result['id_hidden'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	$app->get("/level/tampil/ntab/{v}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM `level`";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $response->withJson($result, 200);
		// json_encode($response);
	});
	$app->get("/user/entiti/tmpl/{v}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM `user_entity`";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $response->withJson($result, 200);
		// json_encode($response);
	});
	$app->get("/dropdown/usrentiti/combo/{v}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM `user_entity` WHERE `id_hidden`='1'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $response->withJson($result, 200);
		// json_encode($response);
	});
	$app->get("/dropdon/strktr/comb/{v}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM `level` WHERE `id_hidden`='1'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $response->withJson($result, 200);
		// json_encode($response);
	});
	$app->get("/user/grub/tiap/id/{view}", function (Request $request, Response $response, $args) {
		// $id_aps = $_GET['aplikasi_id'];
		$grd = $_GET["id_urt"];
		$sql = "SELECT * FROM `level_detail` INNER JOIN `level`ON level_detail.level_id=level.level_id WHERE `id_urt`= '$grd' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result2 = $stmt->fetch();

		return $response->withJson($result2, 200);
	});
	$app->get("/level/per/id/{view}", function (Request $request, Response $response, $args) {

		$lv = $_GET["level_id"];
		$sql = "SELECT * FROM `level` WHERE `level_id`= '$lv' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result2 = $stmt->fetch();

		return $response->withJson($result2, 200);
	});
	$app->get("/gb/pr/id/{view}", function (Request $request, Response $response, $args) {

		$lv = $_GET["grub_id"];
		$sql = "SELECT user_grub.grub_id, user_grub.nama_grup, user_grub.level_id, level.level_name FROM `user_grub` JOIN `level` ON user_grub.level_id=level.level_id WHERE user_grub.grub_id= '$lv' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result2 = $stmt->fetch();

		return $response->withJson($result2, 200);
	});
	$app->get("/usr/access/lz/{view}", function (Request $request, Response $response, $args) {

		$sql = "SELECT *  FROM `level_detail` ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		while ($result = $stmt->fetch()) {
			$grd = $result['grup_id'];

			$sql2 = "SELECT *  FROM `` WHERE `grup_id`='$grd' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$h['id'] = $result["id"];
			$h['grup_id'] = $result2["grup_id"];
			$h['nama_grup'] = $result2["nama_grup"];
			$h['id_hidden'] = $result2["id_hidden"];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	$app->get("/coba/tampil/menu/kanan/{view}", function (Request $request, Response $response) {
		// $urt=$_GET['id_urt'];

		$sql = "SELECT * FROM `aplikasi` WHERE `aplikasi_id`!= '0' AND `id_hidden`='1'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$nastmt = $stmt->rowCount();

		$resa = array();
		while ($result = $stmt->fetch()) {

			$apsm = $result['aplikasi_id'];
			// $h['id_urt'] = $urt;
			$h['aplikasi_id'] = $result['aplikasi_id'];
			$h['nama_aplikasi'] = $result['nama_aplikasi'];

			$query1 = "SELECT * FROM `menu` JOIN aplikasi ON menu.aplikasi_id=aplikasi.aplikasi_id  WHERE  menu.aplikasi_id='$apsm' AND `idm`='grup' AND menu.id_hidden='1' ";
			$asrt = $this->db->prepare($query1);
			$asrt->execute();
			// $nastmt= $asrt->rowCount();

			$res = array();
			$n = 1;
			while ($result2 = $asrt->fetch()) {
				$grd = $result2['menu_id'];
				$querys = "SELECT `menu_id`,`menu_name` FROM `menu` WHERE `sub_menu_id`='$grd' AND `idm`='sub' AND `id_hidden`='1'";
				$asrts = $this->db->prepare($querys);
				$asrts->execute();
				$result3 = $asrts->fetchAll();

				$h2['menu_id'] = $result2['menu_id'];
				$h2['grup'] = $result2['menu_name'];
				// $h2['id_urt'] = $result2['id_urt'];
				$h2['sub'] = $result3;
				$h2['total sub'] = count($result3);

				$a = array_push($res, $h2);
			}
			$nastmt = count($res);
			if ($nastmt == 0) {
			} else {
				$h['menu'] = $res;

				$a = array_push($resa, $h);
			}
		}

		return $response->withJson($resa, 200);
	});
	$app->get("/wah/weh/woh/{view}", function (Request $request, Response $response, $args) {
		$urt = $_GET['id_urt'];
		// $lv=$_GET['level_id'];

		$query = "SELECT * FROM `aplikasi` WHERE `id_hidden`='1'";
		$astmt = $this->db->prepare($query);
		$astmt->execute();

		$res = array();
		while ($result = $astmt->fetch()) {
			$aps = $result['aplikasi_id'];

			$query1 = "SELECT * FROM `menu` WHERE `aplikasi_id` = '$aps' AND `idm`='grup' AND `id_hidden`='1'";
			$astmt1 = $this->db->prepare($query1);
			$astmt1->execute();

			$ros = array();
			while ($result1 = $astmt1->fetch()) {
				$mn = $result1['menu_id'];

				$query2 = "SELECT * FROM `rule2` WHERE `menu_id` = '$mn' AND `id_urt`='$urt'";
				$astmt2 = $this->db->prepare($query2);
				$astmt2->execute();
				$nastmt2 = $astmt2->rowCount();
				$result2 = $astmt2->fetch();
				$mnr = $result2['menu_id'];

				$query3 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$mnr'";
				$astmt3 = $this->db->prepare($query3);
				$astmt3->execute();

				$rus = array();
				while ($result3 = $astmt3->fetch()) {
					$my = $result3['menu_id'];

					$query4 = "SELECT * FROM `rule2` WHERE `menu_id` = '$my' AND `id_urt`='$urt'";
					$astmt4 = $this->db->prepare($query4);
					$astmt4->execute();
					$nastmt4 = $astmt4->rowCount();
					$result4 = $astmt4->fetch();

					if ($nastmt4 == 0) {
					} else {
						$mw = $result4['menu_id'];

						$query5 = "SELECT * FROM `menu` WHERE `menu_id` = '$mw' AND `id_hidden`='1'";
						$astmt5 = $this->db->prepare($query5);
						$astmt5->execute();
						$result5 = $astmt5->fetch();

						$h3['id_rule2'] = $result4['id_rule2'];
						$h3['menu_id'] = $result5['menu_id'];
						$h3['menu_name'] = $result5['menu_name'];
						$h3['idm'] = $result5['idm'];

						$a = array_push($rus, $h3);
					}
				}
				if ($nastmt2 == 0) {
				} else {
					$h1['id_rule2'] = $result2['id_rule2'];
					$h1['idm'] = $result1['idm'];
					$h1['menu_id'] = $result1['menu_id'];
					$h1['grup'] = $result1['menu_name'];
					$h1['sub'] = $rus;

					$a = array_push($ros, $h1);
				}
			}
			$cr = count($ros);

			if ($cr == 0) {
			} else {
				$h['id_urt'] = $urt;
				// $h['level_id']=$lv;
				$h['aplikasi_id'] = $result['aplikasi_id'];
				$h['nama_aplikasi'] = $result['nama_aplikasi'];
				$h['menu'] = $ros;

				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
	});
	$app->get("/download/sql/{view}", function (Request $request, Response $response, $args) {

		$sql = "$host_api_surat/surat/Log/Surat/view?$key_api_surat";
		$num_fields = mysqli_num_fields($sql);

		$return .= 'DROP TABLE ' . $sql . ';';
		$row2 = mysqli_fetch_row(mysqli_query($connection, "SHOW CREATE TABLE " . $sql));
		$return .= "\n\n" . $row2[1] . ";\n\n";

		for ($i = 0; $i < $num_fields; $i++) {
			while ($row = mysqli_fetch_row($result)) {
				$return .= "INSERT INTO " . $sql . " VALUES(";
				for ($j = 0; $j < $num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
					if (isset($row[$j])) {
						$return .= '"' . $row[$j] . '"';
					} else {
						$return .= '""';
					}
					if ($j < $num_fields - 1) {
						$return .= ',';
					}
				}
				$return .= ");\n";
			}
		}
		$return .= "\n\n\n";
		//save file
		$handle = fopen("backuplogsurat.sql", "w+");
		fwrite($handle, $return);
		fclose($handle);
	});
	$app->get("/tampil/menus/kiri/rule2/{view}", function (Request $request, Response $response, $args) {
		$urt = $_GET['id_urt'];

		$query = "SELECT * FROM `rule2` WHERE `id_urt` = '$urt'";
		$astmt = $this->db->prepare($query);
		$astmt->execute();

		$res = array();
		while ($result = $astmt->fetch()) {

			$mn = $result['menu_id'];

			$query2 = "SELECT menu.menu_id, menu.menu_name, menu.sub_menu_id, aplikasi.aplikasi_id, aplikasi.nama_aplikasi FROM `menu` JOIN `aplikasi` ON menu.aplikasi_id=aplikasi.aplikasi_id WHERE menu.menu_id = '$mn'";
			$astmt2 = $this->db->prepare($query2);
			$astmt2->execute();
			$result2 = $astmt2->fetch();
			// $aps=$result2['aplikasi_id'];

			$h['id_rule2'] = $result['id_rule2'];
			$h['menu_id'] = $result2['menu_id'];
			$h['menu_name'] = $result2['menu_name'];
			$h['sub_menu_id'] = $result2['sub_menu_id'];
			$h['nama_aplikasi'] = $result2['nama_aplikasi'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	$app->get("/struktural/jabatan/{view}", function (Request $request, Response $response, $args) {

		$sql = "SELECT struktural.id, struktural.id_rektor, struktural.rektor_id, struktural.level_id, level.level_name, struktural.ketkode_rektor, struktural.rektor_name, struktural.nidn_rektor, struktural.p1_rekto, struktural.p2_rekto, struktural.id_hidden AS s, user_entity.nidn, user_entity.user_name, user_entity.id_hidden AS u FROM `struktural` JOIN `user_entity` ON struktural.id=user_entity.id JOIN `level` ON level.level_id=struktural.level_id ORDER BY struktural.id_hidden AND struktural.rektor_id DESC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();
		while ($result = $stmt->fetch()) {

			if ($result['u'] == 1) {
				$gh = 1;
			} else {
				$gh = 2;
			}

			$h['grub_hidden'] = $gh;
			$h['nidn'] = $result['nidn'];
			$h['user_name'] = $result['user_name'];

			$h['id'] = $result['id'];
			$h['id_rektor'] = $result['id_rektor'];
			$h['rektor_id'] = $result['rektor_id'];
			$h['ketkode_rektor'] = $result['ketkode_rektor'];
			$h['rektor_name'] = $result['rektor_name'];
			$h['nidn_rektor'] = $result['nidn_rektor'];
			$h['level_id'] = $result['level_id'];
			$h['level_name'] = $result['level_name'];
			$h['p1_rekto'] = $result['p1_rekto'];
			$h['p2_rekto'] = $result['p2_rekto'];
			$h['id_hidden'] = $result['s'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	//-------------------------- INSERT --------------------------//

	$app->post("/kelola/user/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
		$_POST = json_decode(file_get_contents("php://input"), true);

		$uid = $_POST["user_id"];
		$un = $_POST["user_name"];
		$nidn = $_POST["nidn"];
		$upd = date('sMys');
		$dvs = $_POST["jabatan"];
		$almt = $_POST["alamat"];
		$hp = $_POST["no_hp"];
		$ps1 = $_POST["posisi1"];
		$ps2 = $_POST["posisi2"];
		$date_now = $_POST["tgl_masuk"];
		// $datemasuk= date_format($date_now, "Y-m-d");
		$datemasuk = $date_now;
		// require_once("link/modul/Cipher.php");
		// $cipher = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);

		$kunci = "UptSI";
		$string = $upd;

		$b1 = base64_encode($string);
		$b2 = base64_encode($b1);

		$dup = $b2;

		// $dup = $cipher->encrypt($cipher->encrypt($string, $kunci), $kunci);


		$csql_user = "SELECT * FROM user_entity WHERE user_id='$uid'";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		// $id = $result['id'];

		if ($cstmt_user->rowCount() == 0) {
			// $sql = "INSERT INTO `user_entity` (`id`, `user_id`, `user_name`, `user_password`, `user_create`, `user_update`, `user_pass_def`, `nidn`, `id_hidden`) 
			// VALUES (NULL, '$uid', '$un', '$dup', '$date_now', '0000-00-00 00:00:00', '$upd', '$nidn', 1)";
			// ======================
			$sql = "INSERT INTO `user_entity` (`id`, `user_id`, `user_name`, `user_password`, `tgl_masuk`, `tgl_keluar`, `user_pass_def`,`alamat`,`no_hp`, `nidn`, `posisi1`, `posisi2`,`jabatan`, `id_hidden`) 
			VALUES (NULL, '$uid', '$un', '$dup', '$datemasuk', NULL, '$upd','$almt','$hp','$nidn','$ps1','$ps2','$dvs', 1)";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/aplikasi/administrator/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		//id otomatis
		$query = "SELECT max(aplikasi_id) as kdAps FROM aplikasi";
		$newKd = $this->db->prepare($query);
		$newKd->execute();
		$data1 = $newKd->fetch(PDO::FETCH_ASSOC);
		$idNyar = $data1['kdAps'];
		$tambah = $idNyar + 1;


		// $id_aps = $_POST['aplikasi_id'];
		$aps = $_POST['nama_aplikasi'];

		$csql_user = "SELECT * FROM `aplikasi` WHERE `nama_aplikasi`='$aps' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		if ($cstmt_user->rowCount() == 0) {

			$sql = "INSERT INTO `aplikasi` (`aplikasi_id`, `nama_aplikasi`,`v_aplikasi`, `id_hidden`) VALUES ( '$tambah', '$aps','1.0.0', '1')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	$app->post("/menu/sistem/administrator/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$query = "SELECT max(level_id) as kdLevel FROM `level`";
		$newKd = $this->db->prepare($query);
		$newKd->execute();
		$data1 = $newKd->fetch(PDO::FETCH_ASSOC);
		$idNyar = $data1['kdLevel'];
		$tambah = $idNyar + 1;

		// $id_lev= $_POST['level_id'];
		$lev = $_POST["level_name"];

		$csql_user = "SELECT * FROM `level` WHERE `level_name`='$lev' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		if ($cstmt_user->rowCount() == 0) {

			$sql = "INSERT INTO `level` (`level_id`, `level_name`, `id_hidden`) VALUES ( '$tambah', '$lev', '1')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	$app->post("/menu/grub/administrator/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		//id otomatis
		$query = "SELECT max(menu_id) as kdGrub FROM menu WHERE `idm`='grup' ";
		$newKd = $this->db->prepare($query);
		$newKd->execute();
		$data1 = $newKd->fetch(PDO::FETCH_ASSOC);
		$idNyar = $data1['kdGrub'];
		$lastid = (int) substr($idNyar, 2);
		$tambah = $lastid + 1;
		$kode = 'SG';
		if ($tambah < 10) {
			$kdGrub = $kode . "00" . $tambah;
		} else if ($tambah > 100) {
			$kdGrub = $kode . $tambah;
		} else {
			$kdGrub = $kode . "0" . $tambah;
		}

		$menu_name = $_POST["menu_name"];
		$id_aps = $_POST["aplikasi_id"];

		$csql_user = "SELECT * FROM `menu` WHERE `menu_name`='$menu_name' AND `aplikasi_id`='$id_aps' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		if ($cstmt_user->rowCount() == 0) {

			$sql = "INSERT INTO `menu` (`menu_id`, `menu_name`, `link`, `sub_menu_id`, `aplikasi_id`, `idm`, `id_hidden`) 
			  VALUES ('$kdGrub', '$menu_name', '#', '', '$id_aps', 'grup', '1')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	$app->post("/menu/sub/astor/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		//id otomatis
		$query = "SELECT max(menu_id) as kdSub FROM menu WHERE `idm`='sub' ";
		$newKd = $this->db->prepare($query);
		$newKd->execute();
		$data1 = $newKd->fetch(PDO::FETCH_ASSOC);
		$idNyar = $data1['kdSub'];
		$lastid = (int) substr($idNyar, 3);
		$tambah = $lastid + 1;
		$kode = 'SSG';
		if ($tambah < 10) {
			$kdSub = $kode . "00" . $tambah;
		} else if ($tambah > 100) {
			$kdSub = $kode . $tambah;
		} else {
			$kdSub = $kode . "0" . $tambah;
		}

		$menu_name = $_POST["menu_name"];
		$link = $_POST["link"];
		$subid = $_POST["sub_menu_id"];

		$sqlsub = "SELECT * FROM `menu` WHERE menu_id='$subid' AND idm='grup'";
		$stmtsub = $this->db->prepare($sqlsub);
		$stmtsub->execute();
		$rssg = $stmtsub->fetch();
		$aps = $rssg['aplikasi_id'];

		$csql_user = "SELECT * FROM `menu` WHERE `menu_name`='$menu_name' AND `sub_menu_id`='$subid' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		if ($cstmt_user->rowCount() == 0) {

			$sql = "INSERT INTO `menu` (`menu_id`, `menu_name`, `link`, `sub_menu_id`, `aplikasi_id`, `idm`, `id_hidden`) 
			  VALUES ('$kdSub', '$menu_name', '$link', '$subid', '$aps', 'sub', '1')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	$app->post("/user/grub/nambah/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$ngrb = $_POST["nama_grup"];
		$id_lev = $_POST["level_id"];
		$ids = $_POST["id"];

		$csql_user = "SELECT * FROM level_detail WHERE `level_id`='$id_lev' AND `id`='$ids'";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		if ($cstmt_user->rowCount() == 0) {

			$sql = "INSERT INTO `level_detail` (`id`, `level_id`, `nama_grup`, `id_urt`, `id_hidden`) VALUES ('$ids', '$id_lev', '$ngrb', NULL, '1');";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	$app->post("/jbtn/strktrl/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id = $_POST['id'];
		$query = "SELECT * FROM `struktural` WHERE `id`='$id'";
		$astmt = $this->db->prepare($query);
		$astmt->execute();
		$result = $astmt->fetch();

		$queryzz = "SELECT * FROM `user_entity` WHERE `id`='$id'";
		$astmtzz = $this->db->prepare($queryzz);
		$astmtzz->execute();
		$rastmtzz = $astmtzz->fetch();

		$reId = $_POST['rektor_id'];
		$lv = $_POST['level_id'];
		$query1 = "SELECT * FROM `struktural` WHERE `rektor_id`='$reId' AND `id_hidden`=1 AND `level_id`='$lv' ";
		$astmt1 = $this->db->prepare($query1);
		$astmt1->execute();
		$result1 = $astmt1->fetch();

		$ketko = $_POST['ketkode_rektor'];

		$sreId = $result1['rektor_id'];
		$slv = $result1['level_id'];

		$nidn = $rastmtzz['nidn'];
		$nm = $rastmtzz['user_name'];


		$sid = $result['id'];

		$p1 = $_POST['p1_rekto'];
		$p2 = $_POST['p2_rekto'];

		if ($id == $sid and $reId == $sreId and $lv == $slv) {

			$sql0 = "UPDATE `struktural` SET `id_hidden` = '0' WHERE `id` = '$sid' AND `rektor_id`='$sreId' AND `level_id`='$slv'";
			$imsgs0 = $this->db->prepare($sql0);
			$imsgs0->execute();

			// $sql1="UPDATE `struktural` SET `id_hidden` = '0' WHERE `rektor_id`='$sreId' AND `level_id`='$slv'";
			// $imsgs1 = $this->db->prepare($sql1);
			// $imsgs1->execute();

			// $sql2="UPDATE `struktural` SET `id_hidden` = '0' WHERE `level_id`='$slv'";
			// $imsgs2 = $this->db->prepare($sql2);
			// $imsgs2->execute();

			$sql = "INSERT INTO `struktural` (`id`, `id_rektor`, `rektor_id`, `ketkode_rektor`, `rektor_name`, `nidn_rektor`,`level_id`, `p1_rekto`, `p2_rekto`, `id_hidden`) 
				VALUES ('$id', NULL, '$reId', '$ketko', '$nm', '$nidn', '$lv','$p1', '$p2', '1')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();


			$cek = 1;
		} else {
			$sql1sa = "SELECT * FROM struktural where id='$id' AND `rektor_id`='$sreId' AND `level_id`='$slv'";
			$imsgs1sa = $this->db->prepare($sql1sa);
			$imsgs1sa->execute();

			if ($imsgs1sa->rowCount() == 0) {
				$sql = "INSERT INTO `struktural` (`id`, `id_rektor`, `rektor_id`, `ketkode_rektor`, `rektor_name`, `nidn_rektor`,`level_id`, `p1_rekto`, `p2_rekto`, `id_hidden`) 
				VALUES ('$id', NULL, '$reId', '$ketko', '$nm', '$nidn', '$lv','$p1', '$p2', '1')";
				$stmt = $this->db->prepare($sql);
				$stmt->execute();
				$cek = 1;
			} else {
				$cek = "0";
			}
		}

		$sqlassa = "SELECT id_rektor, level_id FROM struktural ORDER BY id_rektor DESC limit 1";
		$stmtsa = $this->db->prepare($sqlassa);
		$stmtsa->execute();
		$rstmtsa = $stmtsa->fetch();
		$rrid_rektor = $rstmtsa['id_rektor'];

		$vcode = array([
			"filedatas" => $cek,
			"rektor_id" => $reId,
			"levelid" => $lv,
			"nidn" => $nidn,
			"user_name" => $nm,
			"idnya" => $id,
			"sid" => $sid,
			"id_rektor" => $rstmtsa['id_rektor']

		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/usr/grb/coba/{add}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		//id otomatis
		$query = "SELECT max(grub_id) as kdGrub FROM user_grub";
		$newKd = $this->db->prepare($query);
		$newKd->execute();
		$data1 = $newKd->fetch(PDO::FETCH_ASSOC);
		$idNyar = $data1['kdGrub'];
		$tambah = $idNyar + 1;

		$menu_name = $_POST["nama_grup"];
		$id_aps = $_POST["level_id"];

		// $csql_user="SELECT * FROM `user_grub` WHERE `menu_name`='$menu_name' AND `aplikasi_id`='$id_aps' ";
		// $cstmt_user = $this->db->prepare($csql_user);
		// $cstmt_user->execute();
		// $result = $cstmt_user->fetch();

		// if ($cstmt_user->rowCount()==0){

		$sql = "INSERT INTO `user_grub` (`grub_id`, `nama_grup`, `level_id`, `id_hidden`) 
			  VALUES ('$tambah', '$menu_name','$id_aps','1')";
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

	//======================-------------------------- UPDATE --------------------------========================//
	$app->post("/administrator/regenpass/{up}", function (Request $request, Response $response, $args) {
		require 'link/surat/link_surat.php';
		// $_POST = json_decode(file_get_contents("php://input"),true);

		$regen_yes = "administrator/kelolauser?r=1";
		$regen_no = "administrator/kelolauser?r=0";
		$lregen_yes = "$host_clien$regen_yes";
		$lregen_no = "$host_clien$regen_no";
		if (!empty($_POST['check_list'])) {
			$checked_count = count($_POST['check_list']);
			$checkbox1 = $_POST['check_list'];
			$chk = "";
			// echo "You have inserted following ".$checked_count." option(s): <br/>";
			// echo"</br>";
			foreach ($_POST['check_list'] as $selected) {
				//echo "<p>".$selected ."</p>";
			}

			foreach ($checkbox1 as $chk1) {
				$chk = $chk1;
				// echo $chk;

				$csql_user = "SELECT `user_pass_def` FROM `user_entity` where `user_id`='$chk1'";
				$cstmt_user = $this->db->prepare($csql_user);
				$cstmt_user->execute();
				$result2 = $cstmt_user->fetch();
				$passdeff = $result2['user_pass_def'];

				// require_once("link/modul/Cipher.php");
				// $cipher = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);

				// $kunci = "UptSI";
				// $string= $passdeff;
				// // $string2="a";

				// // $dup = $cipher->encrypt($cipher->encrypt($string, $kunci), $kunci);

				// $b1=base64_encode($string);
				// $b2=base64_encode($b1);

				// $dup=$b2;

				// ====ENKRIPSI=====
				$dataready = $passdeff;
				require 'fuction/encript.php';
				$hasil = $ciphertext_base64;

				if ($cstmt_user->rowCount() > 0) {
					$ucsql_user = "UPDATE `user_entity` SET `user_password` = '$hasil' WHERE `user_id` = '$chk1'";
					$ucstmt_user = $this->db->prepare($ucsql_user);
					$ucstmt_user->execute();
					$cek = 1;
					return $response->withHeader('location', $lregen_yes);
					// echo "Betulll";
				} else {
					$cek = 0;
					// echo "SALLLAH";
					return $response->withHeader('location', $lregen_no);
				}
			}
			// return $response->withHeader('location', $lregen_yes);
		} else {
			$cek = 0;
			// echo"Failed To Insert, Please select at least one option";
			return $response->withHeader('location', $lregen_no);
		}
		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/user/entity/lp/updet/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$id = $_GET['id'];
		$usid = $_POST['user_id'];
		$usnm = $_POST['user_name'];
		$uspf = $_POST['user_pass_def'];
		$nidn = $_POST['nidn'];
		$dvs = $_POST['jabatan'];
		$almt = $_POST["alamat"];
		$hp = $_POST["no_hp"];
		$ps1 = $_POST["posisi1"];
		$ps2 = $_POST["posisi2"];
		$date_now = $_POST["tgl_masuk"];
		// $datemasuk= date_format($date_now, "Y-m-d");
		$tglkr = $_POST["tgl_keluar"];
		// $datekeluar= date_format($tglkr, "Y-m-d");

		$csql_user = "SELECT * FROM `user_entity` WHERE `user_id`='$usid' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();



		$sql = "UPDATE `user_entity` SET `user_id` = '$usid', `user_name` = '$usnm', `tgl_masuk`='$date_now',`tgl_keluar`='$tglkr',`user_pass_def` = '$uspf',`alamat`='$almt', `no_hp`='$hp', `nidn` = '$nidn',`posisi1`='$ps1',`posisi2`='$ps2', `jabatan`='$dvs' WHERE `id` = '$id' ";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();

		if ($imsgs) {

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->post("/administartor/aplikasi/update/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$id_aps = $_GET['aplikasi_id'];
		$aps = $_POST['nama_aplikasi'];
		$vaps = $_POST['v_aplikasi'];

		$csql_user = "SELECT * FROM `aplikasi` WHERE `nama_aplikasi`='$aps' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();
		$saps = $result['nama_aplikasi'];
		$sid_aps = $result['aplikasi_id'];

		if ($aps == $saps) {

			if ($id_aps == $sid_aps) {
				$sql = "UPDATE `aplikasi` SET `nama_aplikasi` = '$aps',`v_aplikasi` = '$vaps' WHERE `aplikasi_id` = '$id_aps'";
				$imsgs = $this->db->prepare($sql);
				$imsgs->execute();

				$cek = 1;
			} else {
				$cek = 0;
			}
		} else {

			$sql = "UPDATE `aplikasi` SET `nama_aplikasi` = '$aps',`v_aplikasi` = '$vaps' WHERE `aplikasi_id` = '$id_aps'";
			$imsgs = $this->db->prepare($sql);
			$imsgs->execute();

			if ($imsgs) {

				$cek = 1;
			} else {
				$cek = 0;
			}
		}

		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->post("/astor/menu/sistem/update/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$id_lev = $_GET['level_id'];
		$lev = $_POST['level_name'];

		$csql_user = "SELECT * FROM `level` WHERE `level_name`='$lev' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();
		$slev = $result['level_name'];
		$sid_lev = $result['level_id'];

		if ($lev == $slev) {

			if ($id_lev == $sid_lev) {
				$sql = "UPDATE `level` SET `level_name` = '$lev' WHERE `level_id` = '$id_lev' ";
				$imsgs = $this->db->prepare($sql);
				$imsgs->execute();

				$cek = 1;
			} else {
				$cek = 0;
			}
		} else {

			$sql = "UPDATE `level` SET `level_name` = '$lev' WHERE `level_id` = '$id_lev' ";
			$imsgs = $this->db->prepare($sql);
			$imsgs->execute();

			if ($imsgs) {

				$cek = 1;
			} else {
				$cek = 0;
			}
		}

		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->post("/grub/menyu/lv/update/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$id_grub = $_GET['menu_id'];
		$menu_name = $_POST['menu_name'];
		$id_aps = $_POST['aplikasi_id'];

		$csql_user = "SELECT * FROM `menu` WHERE `menu_name`='$menu_name' AND `aplikasi_id`='$id_aps' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();
		$sid = $result['menu_id'];
		$smn_nm = $result['menu_name'];
		$sid_aps = $result['aplikasi_id'];

		if ($menu_name == $smn_nm and $id_aps == $sid_aps) {

			if ($id_grub == $sid) {
				$sql = "UPDATE `menu` SET `menu_name` = '$menu_name', `link` = '#', `sub_menu_id` = '', `aplikasi_id` = '$id_aps', `idm` = 'grup' WHERE `menu_id` = '$id_grub'";;
				$imsgs = $this->db->prepare($sql);
				$imsgs->execute();

				$cek = 1;
			} else {
				$cek = 0;
			}
		} else {

			$sql = "UPDATE `menu` SET `menu_name` = '$menu_name', `link` = '#', `sub_menu_id` = '', `aplikasi_id` = '$id_aps', `idm` = 'grup' WHERE `menu_id` = '$id_grub'";;
			$imsgs = $this->db->prepare($sql);
			$imsgs->execute();
			if ($imsgs) {

				$cek = 1;
			} else {
				$cek = 0;
			}
		}

		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->post("/sub/menu/lw/update/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$id_sub = $_GET['menu_id'];
		$menu_name = $_POST['menu_name'];
		$link = $_POST['link'];
		$subid = $_POST['sub_menu_id'];

		$sqlsub = "SELECT * FROM `menu` WHERE menu_id='$subid' AND idm='grup'";
		$stmtsub = $this->db->prepare($sqlsub);
		$stmtsub->execute();
		$rssg = $stmtsub->fetch();
		$aps = $rssg['aplikasi_id'];

		$csql_user = "SELECT * FROM `menu` WHERE `menu_name`='$menu_name' AND `sub_menu_id`='$subid' ";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();
		$sid = $result['menu_id'];
		$smn_nm = $result['menu_name'];
		$sbid = $result['sub_menu_id'];

		if ($menu_name == $smn_nm and $subid == $sbid) {

			if ($id_sub == $sid) {
				$sql = "UPDATE `menu` SET `menu_name` = '$menu_name', `link` = '$link', `sub_menu_id` = '$subid', `aplikasi_id` = '$aps', `idm` = 'sub' WHERE `menu_id` = '$id_sub'";;
				$imsgs = $this->db->prepare($sql);
				$imsgs->execute();

				$cek = 1;
			} else {
				$cek = 0;
			}
		} else {

			$sql = "UPDATE `menu` SET `menu_name` = '$menu_name', `link` = '$link', `sub_menu_id` = '$subid', `aplikasi_id` = '$aps', `idm` = 'sub' WHERE `menu_id` = '$id_sub'";;
			$imsgs = $this->db->prepare($sql);
			$imsgs->execute();
			if ($imsgs) {

				$cek = 1;
			} else {
				$cek = 0;
			}
		}

		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	// $app->post("/user/grub/lz/update/{up}", function (Request $request, Response $response, $args){
	// 	$_POST = json_decode(file_get_contents("php://input"),true);
	// 	$grd=$_GET['id_urt'];
	// 	$ngrb= $_POST["nama_grup"];
	// 	$id_lev= $_POST["level_id"];

	// 	$sql="UPDATE `level_detail` SET `nama_grup` = '$ngrb', `level_id` = '$id_lev' WHERE `id_urt` = '$grd'";
	// 	$imsgs = $this->db->prepare($sql);
	// 	$imsgs->execute();

	// 	if ($imsgs) {
	// 		$cek=1;

	// 	}else{
	// 		$cek=0;
	// 	}

	// 	$vcode = array([
	// 		"filedatas" => $cek
	// 	]);
	// 	return $response->withJson($vcode, 200);
	// });
	$app->post("/gb/updt/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$grd = $_GET['grub_id'];
		$ngrb = $_POST["nama_grup"];
		$id_lev = $_POST["level_id"];

		$sql = "UPDATE `user_grub` SET `nama_grup` = '$ngrb', `level_id` = '$id_lev' WHERE `grub_id` = '$grd'";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();

		if ($imsgs) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->post("/struktural/edit/jabatan/ls/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		$rkt = $_GET['id_rektor'];

		$id = $_POST['id'];
		$query = "SELECT * FROM `user_entity` WHERE `id`='$id'";
		$astmt = $this->db->prepare($query);
		$astmt->execute();
		$result = $astmt->fetch();

		$reId = $_POST['rektor_id'];
		$query1 = "SELECT * FROM `struktural` WHERE `rektor_id`='$reId'";
		$astmt1 = $this->db->prepare($query1);
		$astmt1->execute();
		$result1 = $astmt1->fetch();
		$ketko = $result1['ketkode_rektor'];
		$sreId = $result1['rektor_id'];

		$p1 = $_POST['p1_rekto'];
		$p2 = $_POST['p2_rekto'];
		$sid = $result['id'];
		$nidn = $result['nidn'];
		$nm = $result['user_name'];


		if ($id == $sid and $reId == $sreId) {

			$sql0 = "UPDATE `struktural` SET `id_hidden` = '0' WHERE `id` = '$sid' ";
			$imsgs0 = $this->db->prepare($sql0);
			$imsgs0->execute();

			$sql1 = "UPDATE `struktural` SET `id_hidden` = '0' WHERE `rektor_id`='$sreId'";
			$imsgs1 = $this->db->prepare($sql1);
			$imsgs1->execute();

			$sql = "UPDATE `struktural` SET `id` = '$id',`rektor_id` = '$reId', `ketkode_rektor` = '$ketko',`rektor_name`='$nm', `nidn_rektor`='$nidn', `p1_rekto` = '$p1', `p2_rekto` = '$p2' WHERE `id_rektor` = '$rkt'";
			$imsgs = $this->db->prepare($sql);
			$imsgs->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/aktifkan/aps/menusis/{add}", function (Request $request, Response $response, $args) {

		$id_lev = $_GET['level_id'];
		$id_aps = $_GET['aplikasi_id'];
		$sql1 = "INSERT INTO `rule` (`id_rule`, `aplikasi_id`, `level_id`, id_hidden) VALUES (NULL, '$id_aps', '$id_lev', '1')";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();
		if ($stmt1) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	//-------------------------- AKTFIKAN --------------------------//
	$app->put("/aktf/usr/entiti/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id = $_GET['id'];

		$sql = "UPDATE `user_entity` SET `id_hidden` = '1'  WHERE `id` = '$id'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$sql1 = "UPDATE `level_detail` SET `id_hidden` = '1'  WHERE `id` = '$id'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();

			$sql2 = "UPDATE `struktural` SET `id_hidden` = '1'  WHERE `id` = '$id'";
			$c_sql2 = $this->db->prepare($sql2);
			$c_sql2->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/aktfikan/aplikasi/mantab/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id_aps = $_GET['aplikasi_id'];

		$sql = "UPDATE `aplikasi` SET `id_hidden` = '1'  WHERE `aplikasi_id` = '$id_aps'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$sql1 = "UPDATE `menu` SET `id_hidden` = '1'  WHERE `aplikasi_id` = '$id_aps'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();
			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/aktif/menu/sis/oke/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id_lev = $_GET['level_id'];

		$sql = "UPDATE `level` SET `id_hidden` = '1'  WHERE `level_id` = '$id_lev'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$sql1 = "UPDATE `user_grub` SET `id_hidden` = '1'  WHERE `level_id` = '$id_lev'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();
			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/aktf/grub/menu/yoy/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id_grub = $_GET['menu_id'];

		$sql = "UPDATE `menu` SET `id_hidden` = '1'  WHERE `menu_id` = '$id_grub' AND `idm`='grup'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$sql1 = "UPDATE `menu` SET `id_hidden` = '1'  WHERE `sub_menu_id` = '$id_grub' AND `idm`='sub'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();
			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/aktifk/sub/menu/dulu/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id_sub = $_GET['menu_id'];

		$sql = "UPDATE `menu` SET `id_hidden` = '1'  WHERE `menu_id` = '$id_sub' AND `idm`='sub'";
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

	$app->put("/aktf/usr/gb/ntab/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$grd = $_GET['id_urt'];

		$sql = "UPDATE `level_detail` SET `id_hidden` = '1'  WHERE `id_urt` = '$grd'";
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

	$app->put("/aktfkan/rule2/usr/acs/{dl}", function (Request $request, Response $response) {

		$rl = $_GET['id_rule'];

		$sql = "SELECT * FROM `rule` WHERE `id_rule` = '$rl'";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		$rimsgs = $imsgs->fetch();
		$aps = $rimsgs['aplikasi_id'];
		$lv = $rimsgs['level_id'];

		$mn = $_GET['menu_id'];
		$sqlu = "UPDATE `menu` SET `id_hidden` = '0' WHERE `aplikasi_id` = '$aps' AND `menu_id`='$mn'";
		$imsgsu = $this->db->prepare($sqlu);
		$imsgsu->execute();
		if ($imsgsu) {
			$query = "SELECT max(id_rule2) as kdrl2 FROM `rule2`";
			$newKd = $this->db->prepare($query);
			$newKd->execute();
			$data1 = $newKd->fetch(PDO::FETCH_ASSOC);
			$idNyar = $data1['kdrl2'];
			$tambah = $idNyar + 1;

			$query1 = "SELECT * FROM `menu` WHERE `aplikasi_id`= '$aps' ";
			$asrt = $this->db->prepare($query1);
			$asrt->execute();
			$resolt = $asrt->fetch();

			$query2 = "SELECT * FROM `level_detail` WHERE `level_id`= '$lv' ";
			$asrta = $this->db->prepare($query2);
			$asrta->execute();
			$resolta = $asrta->fetch();
			$grd = $resolta['id_urt'];

			$sql = "INSERT INTO `rule2` (`id_rule2`, `menu_id`, `id_urt`) VALUES ('$tambah', '$mn', '$grd')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			if ($stmt) {
				$cek = 1;
			} else {
				$cek = 0;
			}

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);


		return $response->withJson($vcode, 200);
	});

	$app->put("/aktf/menu/new/{dl}", function (Request $request, Response $response) {
		$rl2 = $_GET['menu_id'];
		$urt = $_GET['adsa'];

		$query = "SELECT * FROM `menu` WHERE `menu_id`= '$rl2' ";
		$asmt = $this->db->prepare($query);
		$asmt->execute();
		$result = $asmt->fetch();
		$mn = $result['menu_id'];
		$idm = $result['idm'];
		$sub = $result['sub_menu_id'];

		// $query2="SELECT * FROM `level_detail` WHERE `level_id`='$ads'  ";
		// $asmt2= $this->db->prepare($query2);
		// $asmt2->execute();
		// $resulta= $asmt2->fetch();
		// $urt=$resulta['id_urt'];

		if ($idm == "sub") {

			// $queryz="SELECT * FROM `menu` WHERE `menu_id`= '$sub' AND `idm`='grub' ";
			// $asmtz= $this->db->prepare($queryz);
			// $asmtz->execute();
			// $resultz= $asmtz->fetch();
			// $ww=$resultz['menu_id'];

			// $sql5="INSERT INTO `rule2` (`id_rule2`, `menu_id`, `id_urt`) VALUES (null, '$ww', '$urt')";
			// $stmt5 = $this->db->prepare($sql5);
			// $stmt5->execute();

			$sql5 = "INSERT INTO `rule2` (`id_rule2`, `menu_id`, `id_urt`) VALUES (null, '$rl2', '$urt')";
			$stmt5 = $this->db->prepare($sql5);
			$stmt5->execute();
		} else {
			$sql2 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$mn'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();

			$sql3 = "SELECT * FROM `menu` WHERE `menu_id` = '$mn'";
			$stmt3 = $this->db->prepare($sql3);
			$stmt3->execute();
			$result3 = $stmt3->fetch();
			$mn2 = $result3['menu_id'];

			$sql4 = "INSERT INTO `rule2` (`id_rule2`, `menu_id`, `id_urt`) VALUES (null, '$mn2', '$urt')";
			$stmt4 = $this->db->prepare($sql4);
			$stmt4->execute();

			while ($result2 = $stmt2->fetch()) {
				$mn1 = $result2['menu_id'];
				$sql5 = "INSERT INTO `rule2` (`id_rule2`, `menu_id`, `id_urt`) VALUES (null, '$mn1', '$urt')";
				$stmt5 = $this->db->prepare($sql5);
				$stmt5->execute();
			}
		}

		if ($stmt5) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);


		return $response->withJson($vcode, 200);
	});

	$app->put("/aktfi/strk/jbt/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$idr = $_GET['id_rektor'];

		$sql = "UPDATE `struktural` SET `id_hidden` = '1'  WHERE `id_rektor` = '$idr'";
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

	$app->put("/apus/menu/kiri/{dl}", function (Request $request, Response $response) {
		$rl = $_GET['id_rule2'];
		$urt = $_GET['adsa'];

		$sql = "SELECT * FROM `rule2` WHERE `id_rule2` = '$rl' AND `id_urt`='$urt'";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		$result = $imsgs->fetch();
		$mn = $result['menu_id'];

		$query = "SELECT * FROM `menu` WHERE `menu_id`= '$mn' ";
		$asmt = $this->db->prepare($query);
		$asmt->execute();
		$results = $asmt->fetch();
		$idm = $results['idm'];

		if ($idm == "sub") {

			$sql5 = "DELETE FROM `rule2` WHERE `id_rule2` = '$rl' AND `id_urt`='$urt'";
			$imsgs5 = $this->db->prepare($sql5);
			$imsgs5->execute();
		} else {

			$sql2 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$mn'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();

			$sql3 = "SELECT * FROM `menu` WHERE `menu_id` = '$mn'";
			$stmt3 = $this->db->prepare($sql3);
			$stmt3->execute();
			$result3 = $stmt3->fetch();
			$mn2 = $result3['menu_id'];


			while ($result2 = $stmt2->fetch()) {
				$mn1 = $result2['menu_id'];

				$sql6 = "SELECT * FROM `rule2` WHERE `menu_id` = '$mn1' AND `id_urt`='$urt'";
				$stmt6 = $this->db->prepare($sql6);
				$stmt6->execute();
				$result6 = $stmt6->fetch();
				$rl2 = $result6['id_rule2'];

				$sql5 = "DELETE FROM `rule2` WHERE `id_rule2` = '$rl2' AND `id_urt`='$urt'";
				$imsgs5 = $this->db->prepare($sql5);
				$imsgs5->execute();
			}
			$sql4 = "DELETE FROM `rule2` WHERE `id_rule2` = '$rl' AND `id_urt`='$urt' ";
			$imsgs4 = $this->db->prepare($sql4);
			$imsgs4->execute();
		}

		if ($imsgs5) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});
	$app->put("/aktf/gb/y/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$grd = $_GET['grub_id'];

		$sql = "UPDATE `user_grub` SET `id_hidden` = '1'  WHERE `grub_id` = '$grd'";
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
	//-------------------------- DELETE NON AKTIF --------------------------//
	$app->put("/nonakt/user/entity/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id = $_GET['id'];

		$sql = "UPDATE `user_entity` SET `id_hidden` = '0'  WHERE `id` = '$id'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			// $sql1="UPDATE `level_detail` SET `id_hidden` = '0'  WHERE `id` = '$id'";
			// $c_sql1 = $this->db->prepare($sql1);
			// $c_sql1->execute();

			$sql2 = "UPDATE `struktural` SET `id_hidden` = '0'  WHERE `id` = '$id'";
			$c_sql2 = $this->db->prepare($sql2);
			$c_sql2->execute();

			$sql1 = "DELETE FROM `level_detail`  WHERE `id` = '$id'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/aplikasi/di/hapus/sungguhan/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id_aps = $_GET['aplikasi_id'];

		$sql = "UPDATE `aplikasi` SET `id_hidden` = '0'  WHERE `aplikasi_id` = '$id_aps'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$sql1 = "DELETE FROM `rule`  WHERE `aplikasi_id` = '$id_aps'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();

			$sql2 = "UPDATE `menu` SET `id_hidden` = '0'  WHERE `aplikasi_id` = '$id_aps'";
			$c_sql2 = $this->db->prepare($sql2);
			$c_sql2->execute();
			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/menu/sistem/hapus/sip/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id_lev = $_GET['level_id'];

		$sql = "UPDATE `level` SET `id_hidden` = '0'  WHERE `level_id` = '$id_lev'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$sql1 = "DELETE FROM `rule`  WHERE `level_id` = '$id_lev'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();

			$sql1 = "UPDATE `user_grub` SET `id_hidden` = '0'  WHERE `level_id` = '$id_lev'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();
			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/grub/menu/hapus/wae/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id_grub = $_GET['menu_id'];

		$sql = "UPDATE `menu` SET `id_hidden` = '0'  WHERE `menu_id` = '$id_grub' AND `idm`='grup'";
		$c_sql = $this->db->prepare($sql);
		$c_sql->execute();

		if ($c_sql) {
			$sql1 = "UPDATE `menu` SET `id_hidden` = '0'  WHERE `sub_menu_id` = '$id_grub' AND `idm`='sub'";
			$c_sql1 = $this->db->prepare($sql1);
			$c_sql1->execute();
			$cek = 1;
		} else {
			$cek = 0;
		}
		$vcode = array([
			"filedatas" => $cek
		]);
		return $response->withJson($vcode, 200);
	});

	$app->put("/sub/menyu/hapus/dulu/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$id_sub = $_GET['menu_id'];

		$sql = "UPDATE `menu` SET `id_hidden` = '0'  WHERE `menu_id` = '$id_sub' AND `idm`='sub'";
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

	$app->put("/user/grb/hps/dipek/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$grd = $_GET['id_urt'];

		$sql = "UPDATE `level_detail` SET `id_hidden` = '0'  WHERE `id_urt` = '$grd'";
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

	$app->put("/nnaktf/strkrl/jbtn/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$idr = $_GET['id_rektor'];

		$sql = "UPDATE `struktural` SET `id_hidden` = '0'  WHERE `id_rektor` = '$idr'";
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

	$app->put("/non/aktf/rule2/aces/{dl}", function (Request $request, Response $response) {
		$rl2 = $_GET['id_rule2'];

		$sql = "SELECT * FROM `rule2` WHERE `id_rule2` = '$rl2'";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		$rimsgs = $imsgs->fetch();
		$mnid = $rimsgs['menu_id'];
		$grid = $rimsgs['id_urt'];

		$sql1 = "DELETE FROM `rule2` WHERE `id_rule2`='$rl2'";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();

		if ($stmt1) {

			$mn = $_GET['menu_id'];
			$sqlu = "UPDATE `menu` SET `id_hidden` = '1' WHERE `menu_id`='$mn'";
			$imsgsu = $this->db->prepare($sqlu);
			$imsgsu->execute();

			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);


		return $response->withJson($vcode, 200);
	});
	$app->put("/nnaktf/gbr/yz/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$grd = $_GET['grub_id'];

		$sql = "UPDATE `user_grub` SET `id_hidden` = '0'  WHERE `grub_id` = '$grd'";
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

	//-------------------------- DELETE APS --------------------------//
	$app->delete("/delete/aps/menusis/{dl}", function (Request $request, Response $response, $args) {

		$id_rul = $_GET['id_rule'];
		$sql1 = "DELETE FROM `rule` WHERE `id_rule`='$id_rul'";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();

		return $response->withJson($stmt1, 200);
	});

	$app->delete("/back/up/hapus/{dl}", function (Request $request, Response $response, $args) {
		// include 'link/surat/link_surat.php';

		// $a= "$host_api_surat/surat/Log/Surat/view?$key_api_surat";
		// $b= file_get_contents($a);
		// $c = json_decode($b);
		// $d = count($c);
		// $t = $c[0];

		// $res = array();
		// for ($i=0;$i<$d;$i++){
		// 	// $iduser= $c[$i]->id;

		// }

		$sql1 = " DELETE FROM db_asianew.log_letter ";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();

		return $response->withJson($stmt1, 200);
	});

	//-------------------------- JOIN DB --------------------------//
	$app->get("/administrator/user/alluser/{view}", function (Request $request, Response $response, $args) {
		//$un=$_SESSION['uptasia_appall'];
		//$sql = "SELECT * FROM user_entity where user_name='$un'";
		$sql = "SELECT * FROM `user_entity`";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return $response->withJson($result, 200);
		// json_encode($response);
	});

	// ================================= SURAT APP ================================= //
	// ================================= View ================================= //
	$app->get("/user/list/teg/{view}", function (Request $request, Response $response, $args) {

		// $idurt = $_GET['id_urt'];
		$sql1 = "SELECT * FROM user_entity where id_hidden=1";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();

		$os = array();
		while ($result = $stmt1->fetch()) {
			$h['value'] = $result['id'];
			$h['label'] = $result['user_name'];

			$a = array_push($os, $h);
		}

		return $response->withJson($os, 200);
	});

	$app->get("/aplikasi/surat/search/lv/join/app/{inview}", function (Request $request, Response $response) {

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
		// $result = $stmt->fetchAll();


		$sqlzs = "SELECT * FROM `level_detail` WHERE `id` = '$idus'";
		$stmtzs = $this->db->prepare($sqlzs);
		$stmtzs->execute();
		$nstmtzs = $stmtzs->rowCount();
		// $result = $stmt->fetchAll();
		// $rstmtzs = $stmtzs->fetch();

		$os = array();

		if ($nstmtzs > 0) {
			while ($rstmtzs = $stmtzs->fetch()) {
				$idurt = $rstmtzs['level_id'];
				$idn = $rstmtzs['id'];

				// $sqlzsrule = "SELECT level_detail.level_id AS idlc, level_detail.grub_id, aplikasi.aplikasi_id, menu.aplikasi_id AS menuidapp FROM level_detail JOIN rule2 ON level_detail.grub_id=rule2.grub_id JOIN menu ON rule2.menu_id=menu.menu_id JOIN aplikasi on menu.aplikasi_id=aplikasi.aplikasi_id  where level_detail.grub_id = '$idurt' AND aplikasi.aplikasi_id='$app'";
				$sqlzsrule = "SELECT level_detail.id AS vid, rule.aplikasi_id AS apid, level_detail.level_id AS idlc, rule.aplikasi_id AS menuidapp FROM level_detail JOIN rule ON level_detail.level_id=rule.level_id WHERE level_detail.level_id='$idurt' AND level_detail.id='$idus' AND rule.aplikasi_id='$app'";

				$stmtzsrule = $this->db->prepare($sqlzsrule);
				$stmtzsrule->execute();
				$nstmtzsrule = $stmtzsrule->rowCount();
				$rstmtzsrule = $stmtzsrule->fetch();

				// if ($nstmtzsrule==0) {
				// 	$h['acc_user'] = "1";
				// 	$h['akses'] = "0";
				// 	$a = array_push($os, $h);
				// }else{
				if ($rstmtzsrule['menuidapp'] == $app) {
					$gr = $rstmtzsrule['idlc'];
					$sqlg = "SELECT * FROM user_grub where grub_id='$gr'";
					$ssqlg = $this->db->prepare($sqlg);
					$ssqlg->execute();
					$rssqlg = $ssqlg->fetch();

					$h['acc_user'] = "1";
					// $h['akses'] = $rssqlg['level_id'];
					$dataready = $gr;
					require 'fuction/encript.php';
					$akses = $ciphertext_base64;
					$h['akses'] = $akses;

					array_push($os, $h);
				}
				// }


				// else{
				// $h['acc_user'] = "1";
				// $h['akses'] = "0";	

				// $a = array_push($os, $h);
				// }

				// $s['lvid'] = $idurt;
				// $s['idn'] = $idn;
				// $s['app'] = $app;
				// $s['menuidp'] = $nstmtzsrule;
				// $a = array_push($os, $s);
			}
		} else {
			$h['acc_user'] = "0";
			$h['akses'] = "0";

			$a = array_push($os, $h);
		}


		// echo $L;

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
			'level_id' => $reslv,
			// 'user_id' => $userid,
			'user_id' => $userid,
			'user_nama' => $result2['user_name'],
			'lots' => $os,
			'usid' => $iduser,
			'v_versi' => $result3['v_versi'],
			'b_versi' => $bversi,
			'n_versi' => $result4['v_aplikasi']
		]);

		return $response->withJson($vcode, 200);
	});

	$app->get("/aps/kui/dashboard/search/{inview}", function (Request $request, Response $response) {

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
		// $result = $stmt->fetchAll();


		$sqlzs = "SELECT * FROM `level_detail` WHERE `id` = '$idus'";
		$stmtzs = $this->db->prepare($sqlzs);
		$stmtzs->execute();
		$nstmtzs = $stmtzs->rowCount();
		// $result = $stmt->fetchAll();
		// $rstmtzs = $stmtzs->fetch();

		$os = array();

		if ($nstmtzs > 0) {
			while ($rstmtzs = $stmtzs->fetch()) {
				$idurt = $rstmtzs['grub_id'];

				$sqlzsrule = "SELECT level_detail.level_id AS idlc, level_detail.grub_id, aplikasi.aplikasi_id, menu.aplikasi_id AS menuidapp FROM level_detail JOIN rule2 ON level_detail.grub_id=rule2.grub_id JOIN menu ON rule2.menu_id=menu.menu_id JOIN aplikasi on menu.aplikasi_id=aplikasi.aplikasi_id  where level_detail.grub_id = '$idurt' AND aplikasi.aplikasi_id='$app'";
				$stmtzsrule = $this->db->prepare($sqlzsrule);
				$stmtzsrule->execute();
				$nstmtzsrule = $stmtzsrule->rowCount();
				$rstmtzsrule = $stmtzsrule->fetch();

				// if ($nstmtzsrule==0) {
				// 	$h['acc_user'] = "1";
				// 	$h['akses'] = "0";
				// 	$a = array_push($os, $h);
				// }else{
				if ($rstmtzsrule['menuidapp'] == $app) {
					$gr = $rstmtzsrule['idlc'];
					$sqlg = "SELECT * FROM user_grub where grub_id='$gr'";
					$ssqlg = $this->db->prepare($sqlg);
					$ssqlg->execute();
					$rssqlg = $ssqlg->fetch();

					$h['acc_user'] = "1";
					// $h['akses'] = $rssqlg['level_id'];
					$dataready = $gr;
					require 'fuction/encript.php';
					$akses = $ciphertext_base64;
					$h['akses'] = $akses;

					$a = array_push($os, $h);
				}
				// }


				// else{
				// 	$h['acc_user'] = "1";
				// 	$h['akses'] = "0";	

				// 	$a = array_push($os, $h);
				// }
			}
		} else {
			$h['acc_user'] = "0";
			$h['akses'] = "0";

			$a = array_push($os, $h);
		}


		// echo $L;

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

		$sql3 = "SELECT * FROM `versi` WHERE `id` = '$idus' AND `aplikasi_id` = 1";
		$stmt3 = $this->db->prepare($sql3);
		$stmt3->execute();
		$result3 = $stmt3->fetch();

		$sql4 = "SELECT * FROM aplikasi WHERE `aplikasi_id` = 1";
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
			'level_id' => $reslv,
			// 'user_id' => $userid,
			'user_id' => $userid,
			'user_nama' => $result2['user_name'],
			'lots' => $os,
			'usid' => $iduser,
			'v_versi' => $result3['v_versi'],
			'b_versi' => $bversi,
			'n_versi' => $result4['v_aplikasi']
		]);

		return $response->withJson($vcode, 200);
	});

	$app->get("/tahun/copy/right/{inview}", function (Request $request, Response $response) {
		$date = date('Y');
		$idus = $_GET['idus'];
		$sql = "SELECT * FROM `versi` WHERE `id` = '$idus' AND `aplikasi_id` = 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();

		$vcode = array([
			'tahun' => $date,
			'versi' => $result['v_versi']

		]);

		return $response->withJson($vcode, 200);
	});

	// ================================= Update ================================= //
	$app->post("/update/versi/app/surat/{up}", function (Request $request, Response $response) {
		$date = date('Y');
		$postencript = $_GET['idus'];
		require 'fuction/decript.php';
		$hasil = trim($plaintext_dec);
		$idus = $hasil;
		// $idus=$_GET['idus'];
		$appid = $_GET['appid'];
		$sql = "SELECT * FROM `versi` WHERE `id` = '$idus' AND `aplikasi_id` = '$appid'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$nstmt = $stmt->rowCount();

		if ($nstmt == 0) {

			$sql2a = "INSERT INTO `versi` (`id_versi`, `id`, `aplikasi_id`, `v_versi`) 
			VALUES (NULL, '$idus', '$appid', '1.0.0')";
			$stmt2a = $this->db->prepare($sql2a);
			$stmt2a->execute();

			$sqlz = "SELECT * FROM `versi` WHERE `id` = '$idus' AND `aplikasi_id` = '$appid'";
			$stmtz = $this->db->prepare($sqlz);
			$stmtz->execute();
			$rstmtz = $stmtz->fetch();

			$sql2 = "SELECT * FROM aplikasi WHERE `aplikasi_id` = '$appid'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$idversi = $rstmtz['id_versi'];
			$versinya = $result2['v_aplikasi'];
			$sqlz = "UPDATE `versi` SET `v_versi` = '$versinya' WHERE `id_versi` = '$idversi'";
			$stmtz = $this->db->prepare($sqlz);
			$stmtz->execute();

			if ($stmtz) {
				$cek = 1;
			} else {
				$cek = 0;
			}
		} else {
			$sql2 = "SELECT * FROM aplikasi WHERE `aplikasi_id` = '$appid'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$idversi = $result['id_versi'];
			$versinya = $result2['v_aplikasi'];
			$sqlz = "UPDATE `versi` SET `v_versi` = '$versinya' WHERE `id_versi` = '$idversi'";
			$stmtz = $this->db->prepare($sqlz);
			$stmtz->execute();

			if ($stmtz) {
				$cek = 1;
			} else {
				$cek = 0;
			}
		}

		$vcode = array([
			'semongko' => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/update/versi/app/surat/lain/kali/{no}", function (Request $request, Response $response) {
		$date = date('Y');
		$postencript = $_GET['idus'];
		require 'fuction/decript.php';
		$hasil = trim($plaintext_dec);
		$idus = $hasil;
		$appid = $_GET['appid'];
		$sql = "SELECT * FROM `versi` WHERE `id` = '$idus' AND `aplikasi_id` = '$appid'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$nstmt = $stmt->rowCount();

		if ($nstmt == 0) {

			$sql2a = "INSERT INTO `versi` (`id_versi`, `id`, `aplikasi_id`, `v_versi`) 
			VALUES (NULL, '$idus', '$appid', '1.0.0')";
			$stmt2a = $this->db->prepare($sql2a);
			$stmt2a->execute();
		}

		return $response->withJson($nstmt, 200);
	});

	$app->get("/ayeye/{v}", function (Request $request, Response $response, $args) {
		$urt = $_GET['urt'];
		$query = "SELECT * FROM `aplikasi` ";
		$astmt = $this->db->prepare($query);
		$astmt->execute();

		$res = array();
		while ($result = $astmt->fetch()) {
			$aps = $result['aplikasi_id'];

			$query1 = "SELECT * FROM `menu` WHERE `aplikasi_id`='$aps' AND idm='grup'";
			$astmt1 = $this->db->prepare($query1);
			$astmt1->execute();

			$ros = array();
			while ($result1 = $astmt1->fetch()) {

				$mn = $result1['menu_id'];

				$query2 = "SELECT * FROM `rule2` WHERE `menu_id`='$mn' AND id_urt='$urt'";
				$astmt2 = $this->db->prepare($query2);
				$astmt2->execute();
				$result2 = $astmt2->rowCount();
				$res2 = $astmt2->fetch();

				$query3 = "SELECT * FROM `menu` WHERE `sub_menu_id`='$mn'";
				$astmt3 = $this->db->prepare($query3);
				$astmt3->execute();

				$cc = array();
				while ($res3 = $astmt3->fetch()) {
					$idmen = $res3['menu_id'];
					$query4 = "SELECT * FROM `rule2` WHERE `menu_id`='$idmen' AND id_urt='$urt'";
					$astmt4 = $this->db->prepare($query4);
					$astmt4->execute();
					$result4 = $astmt4->rowCount();

					if ($result4 == 0) {
					} else {
						$res4 = $astmt4->fetch();
						$idmenu5 = $res4['menu_id'];
						$query5 = "SELECT * FROM `menu` WHERE `menu_id`='$idmenu5'";
						$astmt5 = $this->db->prepare($query5);
						$astmt5->execute();
						$res5 = $astmt5->fetch();

						$h4['id_menu'] = $res5['menu_id'];
						$h4['menu_name'] = $res5['menu_name'];

						$a = array_push($cc, $h4);
					}
				}

				if ($result2 == 0) {
				} else {
					$h2['id_rule2'] = $res2['id_rule2'];
					$h2['menu_name'] = $result1['menu_name'];
					$h2['idm'] = $result1['idm'];
					$h2['sub_menu'] = $cc;

					$a = array_push($ros, $h2);
				}
			}

			if (count($ros) == 0) {
			} else {
				$h['aplikasi_id'] = $result['aplikasi_id'];
				$h['nama_aplikasi'] = $result['nama_aplikasi'];
				$h['rule2'] = $ros;
				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
	});

	$app->get("/surat/buat/rektor/tampil/all/{view}", function (Request $request, Response $response, $args) {
		$aks = $_GET['aks'];

		$sql = "SELECT * FROM `struktural` where `level_id`='$aks' AND id_hidden=1 ORDER BY id_rektor ASC";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();

		$sql1 = "SELECT * FROM `struktural` where `level_id`='1' AND id_hidden=1 ORDER BY id_rektor ASC";
		$imsgs1 = $this->db->prepare($sql1);
		$imsgs1->execute();

		$res = array();
		$nn = 1;
		while ($rimsgs = $imsgs->fetch()) {
			// $h2['nourut'] = $nn++;

			$h2['id'] = $rimsgs['id'];
			$h2['id_rektor'] = $rimsgs['id_rektor'];
			$h2['rektor_id'] = $rimsgs['rektor_id'];
			$h2['ketkode_rektor'] = $rimsgs['ketkode_rektor'];
			$h2['rektor_name'] = $rimsgs['rektor_name'];
			$h2['nidn_rektor'] = $rimsgs['nidn_rektor'];
			$h2['level_id'] = $rimsgs['level_id'];
			$h2['p1_rekto'] = $rimsgs['p1_rekto'];
			$h2['p2_rekto'] = $rimsgs['p2_rekto'];
			$h2['id_hidden'] = $rimsgs['id_hidden'];
			// $h2['id'] = $rimsgs1['id'];

			$a = array_push($res, $h2);
		}
		// if($aks==3 OR $aks==4 OR $aks==17){
		if ($aks == 1) {
		} else {
			while ($rimsgs1 = $imsgs1->fetch()) {
				$h2['id'] = $rimsgs1['id'];
				$h2['id_rektor'] = $rimsgs1['id_rektor'];
				$h2['rektor_id'] = $rimsgs1['rektor_id'];
				$h2['ketkode_rektor'] = $rimsgs1['ketkode_rektor'];
				$h2['rektor_name'] = $rimsgs1['rektor_name'];
				$h2['nidn_rektor'] = $rimsgs1['nidn_rektor'];
				$h2['level_id'] = $rimsgs1['level_id'];
				$h2['p1_rekto'] = $rimsgs1['p1_rekto'];
				$h2['p2_rekto'] = $rimsgs1['p2_rekto'];
				$h2['id_hidden'] = $rimsgs1['id_hidden'];
				// $h2['id'] = $rimsgs1['id'];

				$a = array_push($res, $h2);
			}
		}

		// }

		return $response->withJson($res, 200);
	});

	$app->get("/cari/data/struktural/{v}", function (Request $request, Response $response, $args) {
		$idr = $_GET['idr'];
		$sql = "SELECT * FROM `struktural` where id_rektor='$idr' AND id_hidden=1 ORDER BY id_rektor ASC";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		$rimsgs = $imsgs->fetchAll();

		return $response->withJson($rimsgs, 200);
	});

	$app->get("/surat/cari/kode/rektor/{view}", function (Request $request, Response $response, $args) {
		// $_POST = json_decode(file_get_contents("php://input"),true);

		$idpembuat = $_GET['idpembuat'];
		$sql = "SELECT * FROM `struktural` WHERE `id_rektor` = '$idpembuat'";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		$rimsgs = $imsgs->fetch();

		// $res = array();
		// while ($rimsgs=$imsgs->fetch()) {
		//  $h['rektor_id'] = $rimsgs2["rektor_id"];
		// }        

		return $response->withJson($rimsgs, 200);
	});

	$app->get("/buat/surat/cari/rektor/on/change/{c}", function (Request $request, Response $response, $args) {
		// $_POST = json_decode(file_get_contents("php://input"),true);
		$nid = $_GET['aks'];
		$sql = "SELECT * FROM `struktural` WHERE `id_rektor` = '$nid'";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		$rimsgs = $imsgs->fetchAll();

		return $response->withJson($rimsgs, 200);
	});

	//=============================================API AKSES BARU USER API============================================
	$app->get("/coba/usr/menu/{view}", function (Request $request, Response $response) {
		// $grd=$_GET['grub_id'];

		// $sqlz = "SELECT * FROM `user_grub` WHERE `grub_id`= '$grd'";
		// $stmtz = $this->db->prepare($sqlz);
		// $stmtz->execute();
		// $resultz = $stmtz->fetch();
		// $lv=$resultz['level_id'];

		// $sqla = "SELECT `aplikasi_id` FROM `rule` WHERE `level_id`='$lv'";
		// $stmta = $this->db->prepare($sqla);
		// $stmta->execute();
		// $resulta = $stmta->fetchAll();
		// $apzs=$resulta['aplikasi_id'];

		// if($apzs == 0){}else{}

		$sql = "SELECT * FROM `aplikasi` WHERE `aplikasi_id` != '0' AND `id_hidden`='1'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$nastmt = $stmt->rowCount();

		$resa = array();
		while ($result = $stmt->fetch()) {

			$apsm = $result['aplikasi_id'];
			// $h['id_urt'] = $urt;
			$h['aplikasi_id'] = $result['aplikasi_id'];
			$h['nama_aplikasi'] = $result['nama_aplikasi'];

			$query1 = "SELECT * FROM `menu` JOIN aplikasi ON menu.aplikasi_id=aplikasi.aplikasi_id  WHERE  menu.aplikasi_id='$apsm' AND `idm`='grup' AND menu.id_hidden='1' ";
			$asrt = $this->db->prepare($query1);
			$asrt->execute();
			// $nastmt= $asrt->rowCount();

			$res = array();
			$n = 1;
			while ($result2 = $asrt->fetch()) {
				$grd = $result2['menu_id'];
				$querys = "SELECT `menu_id`,`menu_name` FROM `menu` WHERE `sub_menu_id`='$grd' AND `idm`='sub' AND `id_hidden`='1'";
				$asrts = $this->db->prepare($querys);
				$asrts->execute();
				$result3 = $asrts->fetchAll();

				$h2['menu_id'] = $result2['menu_id'];
				$h2['grup'] = $result2['menu_name'];
				// $h2['id_urt'] = $result2['id_urt'];
				$h2['sub'] = $result3;
				$h2['total sub'] = count($result3);

				$a = array_push($res, $h2);
			}
			$nastmt = count($res);
			if ($nastmt == 0) {
			} else {
				$h['menu'] = $res;

				$a = array_push($resa, $h);
			}
		}
		return $response->withJson($resa, 200);
	});

	$app->get("/cobi/huha/ha/{view}", function (Request $request, Response $response, $args) {
		$urt = $_GET['grub_id'];
		// $lv=$_GET['level_id'];

		$query = "SELECT * FROM `aplikasi` WHERE `id_hidden`='1'";
		$astmt = $this->db->prepare($query);
		$astmt->execute();

		$res = array();
		while ($result = $astmt->fetch()) {
			$aps = $result['aplikasi_id'];

			$query1 = "SELECT * FROM `menu` WHERE `aplikasi_id` = '$aps' AND `idm`='grup' AND `id_hidden`='1'";
			$astmt1 = $this->db->prepare($query1);
			$astmt1->execute();

			$ros = array();
			while ($result1 = $astmt1->fetch()) {
				$mn = $result1['menu_id'];

				$query2 = "SELECT * FROM `rule2` WHERE `menu_id` = '$mn' AND `grub_id`='$urt'";
				$astmt2 = $this->db->prepare($query2);
				$astmt2->execute();
				$nastmt2 = $astmt2->rowCount();
				$result2 = $astmt2->fetch();
				$mnr = $result2['menu_id'];

				$query3 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$mnr'";
				$astmt3 = $this->db->prepare($query3);
				$astmt3->execute();

				$rus = array();
				while ($result3 = $astmt3->fetch()) {
					$my = $result3['menu_id'];

					$query4 = "SELECT * FROM `rule2` WHERE `menu_id` = '$my' AND `grub_id`='$urt'";
					$astmt4 = $this->db->prepare($query4);
					$astmt4->execute();
					$nastmt4 = $astmt4->rowCount();
					$result4 = $astmt4->fetch();

					if ($nastmt4 == 0) {
					} else {
						$mw = $result4['menu_id'];

						$query5 = "SELECT * FROM `menu` WHERE `menu_id` = '$mw' AND `id_hidden`='1'";
						$astmt5 = $this->db->prepare($query5);
						$astmt5->execute();
						$result5 = $astmt5->fetch();

						$h3['id_rule2'] = $result4['id_rule2'];
						$h3['menu_id'] = $result5['menu_id'];
						$h3['menu_name'] = $result5['menu_name'];
						$h3['idm'] = $result5['idm'];

						$a = array_push($rus, $h3);
					}
				}
				if ($nastmt2 == 0) {
				} else {
					$h1['id_rule2'] = $result2['id_rule2'];
					$h1['idm'] = $result1['idm'];
					$h1['menu_id'] = $result1['menu_id'];
					$h1['grup'] = $result1['menu_name'];
					$h1['sub'] = $rus;

					$a = array_push($ros, $h1);
				}
			}
			$cr = count($ros);

			if ($cr == 0) {
			} else {
				$h['grub_id'] = $urt;
				// $h['level_id']=$lv;
				$h['aplikasi_id'] = $result['aplikasi_id'];
				$h['nama_aplikasi'] = $result['nama_aplikasi'];
				$h['menu'] = $ros;

				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
	});

	$app->put("/tmbh/men/coba/{dl}", function (Request $request, Response $response) {
		$rl2 = $_GET['menu_id'];
		$urt = $_GET['grub_id'];

		$query = "SELECT * FROM `menu` WHERE `menu_id`= '$rl2' ";
		$asmt = $this->db->prepare($query);
		$asmt->execute();
		$result = $asmt->fetch();
		$mn = $result['menu_id'];
		$idm = $result['idm'];
		$sub = $result['sub_menu_id'];

		// $query2="SELECT * FROM `level_detail` WHERE `level_id`='$ads'  ";
		// $asmt2= $this->db->prepare($query2);
		// $asmt2->execute();
		// $resulta= $asmt2->fetch();
		// $urt=$resulta['id_urt'];

		if ($idm == "sub") {

			// $queryz="SELECT * FROM `menu` WHERE `menu_id`= '$sub' AND `idm`='grub' ";
			// $asmtz= $this->db->prepare($queryz);
			// $asmtz->execute();
			// $resultz= $asmtz->fetch();
			// $ww=$resultz['menu_id'];

			// $sql5="INSERT INTO `rule2` (`id_rule2`, `menu_id`, `id_urt`) VALUES (null, '$ww', '$urt')";
			// $stmt5 = $this->db->prepare($sql5);
			// $stmt5->execute();

			$sql5 = "INSERT INTO `rule2` (`id_rule2`, `menu_id`, `grub_id`) VALUES (null, '$rl2', '$urt')";
			$stmt5 = $this->db->prepare($sql5);
			$stmt5->execute();
		} else {
			$sql2 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$mn'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();

			$sql3 = "SELECT * FROM `menu` WHERE `menu_id` = '$mn'";
			$stmt3 = $this->db->prepare($sql3);
			$stmt3->execute();
			$result3 = $stmt3->fetch();
			$mn2 = $result3['menu_id'];

			$sql4 = "INSERT INTO `rule2` (`id_rule2`, `menu_id`, `grub_id`) VALUES (null, '$mn2', '$urt')";
			$stmt4 = $this->db->prepare($sql4);
			$stmt4->execute();

			while ($result2 = $stmt2->fetch()) {
				$mn1 = $result2['menu_id'];
				$sql5 = "INSERT INTO `rule2` (`id_rule2`, `menu_id`, `grub_id`) VALUES (null, '$mn1', '$urt')";
				$stmt5 = $this->db->prepare($sql5);
				$stmt5->execute();
			}
		}

		if ($stmt5) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);


		return $response->withJson($vcode, 200);
	});

	$app->put("/apusss/oeeee/{dl}", function (Request $request, Response $response) {
		$rl = $_GET['id_rule2'];
		$urt = $_GET['grub_id'];

		$sql = "SELECT * FROM `rule2` WHERE `id_rule2` = '$rl' AND `grub_id`='$urt'";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		$result = $imsgs->fetch();
		$mn = $result['menu_id'];

		$query = "SELECT * FROM `menu` WHERE `menu_id`= '$mn' ";
		$asmt = $this->db->prepare($query);
		$asmt->execute();
		$results = $asmt->fetch();
		$idm = $results['idm'];

		if ($idm == "sub") {

			$sql5 = "DELETE FROM `rule2` WHERE `id_rule2` = '$rl' AND `grub_id`='$urt'";
			$imsgs5 = $this->db->prepare($sql5);
			$imsgs5->execute();
		} else {

			$sql2 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$mn'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();

			$sql3 = "SELECT * FROM `menu` WHERE `menu_id` = '$mn'";
			$stmt3 = $this->db->prepare($sql3);
			$stmt3->execute();
			$result3 = $stmt3->fetch();
			$mn2 = $result3['menu_id'];


			while ($result2 = $stmt2->fetch()) {
				$mn1 = $result2['menu_id'];

				$sql6 = "SELECT * FROM `rule2` WHERE `menu_id` = '$mn1' AND `grub_id`='$urt'";
				$stmt6 = $this->db->prepare($sql6);
				$stmt6->execute();
				$result6 = $stmt6->fetch();
				$rl2 = $result6['id_rule2'];

				$sql5 = "DELETE FROM `rule2` WHERE `id_rule2` = '$rl2' AND `grub_id`='$urt'";
				$imsgs5 = $this->db->prepare($sql5);
				$imsgs5->execute();
			}
			$sql4 = "DELETE FROM `rule2` WHERE `id_rule2` = '$rl' AND `grub_id`='$urt' ";
			$imsgs4 = $this->db->prepare($sql4);
			$imsgs4->execute();
		}

		if ($imsgs5) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->get("/kll/pngg/{view}", function (Request $request, Response $response, $args) {
		// $id_lev = $_GET['level_id'];

		$sql = "SELECT * FROM `user_entity`  ORDER BY `id` ASC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();

		while ($result = $stmt->fetch()) {
			$id_lev = $result['id'];
			$sql1 = "SELECT * FROM `level_detail` JOIN `user_grub` ON level_detail.grub_id = user_grub.grub_id WHERE `id`='$id_lev' ";
			$stmt1 = $this->db->prepare($sql1);
			$stmt1->execute();
			$result1 = $stmt1->fetchAll();

			if ($result['id_hidden'] == 1) {
				$gh = 1;
			} else {
				$gh = 2;
			}

			if ($result['id'] == 1) {
				$on = 0;
			} else {
				$on = 1;
			}

			$h['groub_hidden'] = $gh;
			$h['on_off'] = $on;

			$h['id'] = $result['id'];
			$h['user_id'] = $result['user_id'];
			$h['user_name'] = $result['user_name'];
			$h['user_password'] = $result['user_password'];
			$h['user_pass_def'] = $result['user_pass_def'];
			$h['nidn'] = $result['nidn'];
			$h['jabatan'] = $result['jabatan'];
			$h['user_grub'] = $result1;
			$h['id_hidden'] = $result['id_hidden'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	$app->get("/kll/peng/huha/{view}", function (Request $request, Response $response, $args) {
		$id_aps = $_GET['id'];

		$sql = "SELECT * FROM `user_grub` WHERE `id_hidden` = 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		$res = array();
		while ($result = $stmt->fetch()) {
			$idap = $result['grub_id'];

			$sql2 = "SELECT * FROM `level_detail` WHERE `grub_id` = '$idap' AND `id` = '$id_aps'";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$nsmt2 = $stmt2->rowCount();

			if ($nsmt2 == 0) {
				$result2 = $stmt2->fetch();
				$idrl = $result2['id_urt'];
				$as = 0;
			} else {
				$result2 = $stmt2->fetch();
				$idrl = $result2['id_urt'];
				$as = 1;
			}

			$h['grub_id'] = $result['grub_id'];
			$h['id_urt'] = $idrl;
			$h['id'] = $id_aps;
			$h['nama_grup'] = $result['nama_grup'];
			$h['id_hidden'] = $result['id_hidden'];
			$h['btn'] = $as;
			$a = array_push($res, $h);
		}
		return $response->withJson($res, 200);
	});

	$app->put("/tmbh/kll/pgn/{add}", function (Request $request, Response $response, $args) {

		$ids = $_GET['id'];
		$idgb = $_GET['grub_id'];


		$sql = "SELECT * FROM `user_grub` WHERE `grub_id` = '$idgb'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$idlv = $result['level_id'];

		$sql1 = "INSERT INTO `level_detail` (`id`, `level_id`, `id_urt`, `grub_id`, `id_hidden`) 
				 VALUES ('$ids', '$idlv', NULL, '$idgb', '1')";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();
		if ($stmt1) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->delete("/del/peng/kel/{dl}", function (Request $request, Response $response, $args) {

		$idurt = $_GET['id_urt'];
		$sql1 = "DELETE FROM `level_detail` WHERE `id_urt`='$idurt'";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();

		if ($stmt1) {
			$cek = 1;
		} else {
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->get("/surat/tujuan/multi/{srh}", function (Request $request, Response $response, $args) {

		// $ids = $_GET['ids'];
		// $sql1 = "SELECT * FROM `user_entity` WHERE `id` = '$ids'";
		$sql1 = "SELECT * FROM `user_entity`";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();
		// $rstmt1 = $stmt1->fetchAll();
		$res = array();
		$n = 1;
		while ($rstmt1 = $stmt1->fetch()) {
			$h['nono'] = $n++;
			$h['id'] = $rstmt1['id'];
			$h['user_id'] = $rstmt1['user_id'];
			$h['namauser'] = $rstmt1['user_name'];
			$h['nidn'] = $rstmt1['nidn'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	$app->get("/surat/masuk/pembuat/{v}", function (Request $request, Response $response, $args) {

		$sql1 = "SELECT * FROM `user_entity`";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();

		$res = array();

		while ($rstmt1 = $stmt1->fetch()) {

			$h['id'] = $rstmt1['id'];
			$h['user_id'] = $rstmt1['user_id'];
			$h['namauser'] = $rstmt1['user_name'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	$app->get("/menu/user/surat/{ck}", function (Request $request, Response $response, $args) {

		// $postencript = $_GET['ids'];
		// include 'fuction/decript.php';
		// $idus = $plaintext_dec;
		$idus = $_GET['id'];
		// $postencript = $_GET['ak'];
		// include 'fuction/decript.php';
		// $ak=$plaintext_dec;
		$ak = $_GET['ak'];
		// $sql1 = "SELECT * FROM `user_entity` WHERE `id` = '$ids'";
		$sql1 = "SELECT user_entity.id, level_detail.grub_id, user_grub.nama_grup, rule2.id_rule2, rule2.menu_id, menu.menu_name AS mgname, menu.link AS mslink, menu.idm AS ckstm, menu.sub_menu_id, menu.aplikasi_id, aplikasi.nama_aplikasi, aplikasi.id_hidden FROM user_entity JOIN level_detail ON user_entity.id=level_detail.id JOIN user_grub ON level_detail.grub_id=user_grub.grub_id JOIN rule2 ON level_detail.grub_id=rule2.grub_id JOIN menu ON rule2.menu_id=menu.menu_id JOIN aplikasi ON menu.aplikasi_id=aplikasi.aplikasi_id where level_detail.level_id='$ak' AND user_entity.id='$idus' AND aplikasi.id_hidden='1'";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();


		$res = array();
		$n = 1;
		while ($rstmt1 = $stmt1->fetch()) {
			$h['n'] = $n++;
			$h['gmenu'] = $rstmt1['mgname'];
			$h['ckstm'] = $rstmt1['ckstm'];
			$h['mslink'] = $rstmt1['mslink'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	$app->get("/surat/pindah/akses/{usr}", function (Request $request, Response $response, $args) {
		// $postencript = $_GET['ids'];
		// include 'fuction/decript.php';
		// $ids = trim($plaintext_dec);
		$ids = $_GET['ids'];
		$apps = $_GET['apps'];

		$sql1 = "SELECT level_detail.id AS idld, level_detail.level_id AS lvidld, level_detail.grub_id AS gbid, level.level_name AS lnlv, level.level_id AS idlv FROM user_entity JOIN `level_detail` ON user_entity.id=level_detail.id JOIN level ON level_detail.level_id=level.level_id  where user_entity.id = '$ids'";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();
		// $rstmt1 = $stmt1->fetchAll();
		$nstmt1 = $stmt1->rowCount();

		$res = array();
		$n = 1;
		while ($rstmt1 = $stmt1->fetch()) {
			$idlvnya = $rstmt1['idlv'];

			if ($idlvnya == 0) {
			} else {
				$sql3 = "SELECT * FROM rule WHERE level_id='$idlvnya' AND aplikasi_id='$apps'";
				$stmt3 = $this->db->prepare($sql3);
				$stmt3->execute();
				$nstmt3 = $stmt3->rowCount();

				if ($nstmt1 > 1) {
					// if	()
					// if ($nstmt3>1) {
					$gbid = $rstmt1['gbid'];
					$dataready = $rstmt1['idlv'];
					include 'fuction/encript.php';
					$endaks = $ciphertext_base64;
					$h['nheader'] = $n++;
					$h['idld'] = $rstmt1['idld'];
					$h['lvidld'] = $rstmt1['lvidld'];
					$h['lnlv'] = $rstmt1['lnlv'];
					$h['idlv2'] = $endaks;
					$h['idlv'] = $rstmt1['idlv'];
					$h['gbid'] = $rstmt1['gbid'];

					// , user_grub.nama_grup AS nmgr
					$gbid = $rstmt1['gbid'];
					$sql12 = "SELECT * FROM `user_grub` WHERE `grub_id` = '$gbid' AND `id_hidden` = 1";
					$stmt12 = $this->db->prepare($sql12);
					$stmt12->execute();
					$rstmt12 = $stmt12->fetch();
					$h['nmgr'] = $rstmt12['nama_grup'];
					$h['jumlahswt'] = "Lebih dari 1";

					$a = array_push($res, $h);

					// }
					// else{
					// 	$h['nheader'] = "1";
					// 	$h['idld'] = "0";
					// 	$h['lvidld'] = "0";
					// 	$h['lnlv'] = "0";
					// 	$h['idlv'] = "0";
					// 	$h['gbid'] = "0";
					// 	$h['nmgr'] = "0";

					// 	$a = array_push($res, $h);


					// }

				} else {
					$dataready = $rstmt1['idlv'];
					include 'fuction/encript.php';
					$endaks = $ciphertext_base64;
					$h['nheader'] = $n++;
					$h['idld'] = $rstmt1['idld'];
					$h['lvidld'] = $rstmt1['lvidld'];
					$h['lnlv'] = $rstmt1['lnlv'];
					$h['idlv2'] = $endaks;
					$h['idlv'] = $rstmt1['idlv'];
					$h['gbid'] = $rstmt1['gbid'];

					// , user_grub.nama_grup AS nmgr
					$gbid = $rstmt1['gbid'];
					$sql12 = "SELECT * FROM `user_grub` WHERE `grub_id` = '$gbid' AND `id_hidden` = 1";
					$stmt12 = $this->db->prepare($sql12);
					$stmt12->execute();
					$rstmt12 = $stmt12->fetch();
					$h['nmgr'] = $rstmt12['nama_grup'];

					// $h['nheader'] = "1";
					// $h['idld'] = "0";
					// $h['lvidld'] = "0";
					// $h['lnlv'] = "0";
					// $h['idlv'] = "0";
					// $h['gbid'] = "0";
					// $h['nmgr'] = "0";
					// $h['jumlahswt']= "0";
					$a = array_push($res, $h);
				}
			}
		}

		return $response->withJson($res, 200);
	});

	$app->get("/surat/swict/akun/{user}", function (Request $request, Response $response, $args) {

		$aks = $_GET['aks'];
		$sql1 = "SELECT * FROM level WHERE level_id='$aks'";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();
		$rstmt1 = $stmt1->fetchAll();

		return $response->withJson($rstmt1, 200);
	});

	$app->get("/surat/tujuan/ttd/solo/{cri}", function (Request $request, Response $response, $args) {

		$aks = $_GET['aks'];
		$sql1 = "SELECT * FROM `struktural` WHERE `level_id` = '$aks' AND `id_hidden` = 1";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();
		$nstmt1 = $stmt1->rowCount();
		// $rstmt1 = $stmt1->fetchAll();

		return $response->withJson($nstmt1, 200);
	});

	$app->get("/surat/user/cari/rektor/{json}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';

		$sql = "SELECT * FROM struktural";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();
		// $res = array();
		// while ($result = $stmt->fetch()) {
		// 	$h['id'] = $result['id'];
		// 	// $h['user_id'] = $result['user_id'];
		// 	$h['label'] = $result['user_name'];
		// 	// $h['nidn'] = $result['nidn'];
		// 	// $h['id_hidden'] = $result['id_hidden'];
		// 	// $h['id'] = $result['id'];
		// 	$a = array_push($res, $h);
		// }

		return $response->withJson($res, 200);
	});

	$app->get("/cari/struktural/terakhir/{json}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';

		$sql = "SELECT * FROM `struktural` ORDER BY `id_rektor` DESC LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();
		// $res = array();
		// while ($result = $stmt->fetch()) {
		// 	$h['id'] = $result['id'];
		// 	// $h['user_id'] = $result['user_id'];
		// 	$h['label'] = $result['user_name'];
		// 	// $h['nidn'] = $result['nidn'];
		// 	// $h['id_hidden'] = $result['id_hidden'];
		// 	// $h['id'] = $result['id'];
		// 	$a = array_push($res, $h);
		// }

		return $response->withJson($res, 200);
	});

	$app->get("/cari/id/sign/{cari}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `user_entity` WHERE id='$id' ORDER BY `id` DESC LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		return $response->withJson($res, 200);
	});

	$app->get("/cari/id/dash/{cari}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT id as val_page FROM `user_entity` WHERE id='$id' ORDER BY `id` DESC LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		return $response->withJson($res, 200);
	});

	$app->get("/cari/aks/sign/aks/{vvv}", function (Request $request, Response $response) {
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
	$app->get("/akbar/{vvv}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';

		$postencript = $_GET['ak'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `level_detail` WHERE level_id='$id'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		return $response->withJson($res, 200);
	});

	$app->get("/surat/cari/tujuan/{struktural}", function (Request $request, Response $response, $args) {

		// $ids = $_GET['ids'];
		// $sql1 = "SELECT * FROM `user_entity` WHERE `id` = '$ids'";
		$sql1 = "SELECT * FROM `struktural`";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();
		// $rstmt1 = $stmt1->fetchAll();
		$res = array();
		$n = 1;
		while ($rstmt1 = $stmt1->fetch()) {
			$h['nono'] = $n++;
			$h['id_rektor'] = $rstmt1['id_rektor'];
			$h['rektor_id'] = $rstmt1['rektor_id'];
			$h['ketkode_rektor'] = $rstmt1['ketkode_rektor'];
			$h['rektor_name'] = $rstmt1['rektor_name'];
			$h['nidn_rektor'] = $rstmt1['nidn_rektor'];
			$h['level_id'] = $rstmt1['level_id'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	$app->get("/cari/id/inbox/dash/{cari}", function (Request $request, Response $response) {
		include 'link/surat/link_surat.php';
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT * FROM `user_entity` WHERE id='$id' ORDER BY `id` DESC LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		return $response->withJson($res, 200);
	});

	$app->post("/login/staf/dash/{ul}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		require 'link/surat/link_surat.php';
		$un = $_POST["un"];
		// $up = $_POST["user_password"];

		// $b1=base64_encode($up);
		// $b2=base64_encode($b1);

		// $dup=$b2;

		$sql = "SELECT * FROM user_entity WHERE id='$un' AND id_hidden=1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();


		// if ($stmt->rowCount() == 1){
		$result = $stmt->fetch();

		// 	$postencript = $result['user_password'];
		// 	require 'fuction/decript.php';
		// 	$hasil = trim($plaintext_dec);

		// 	if ($hasil == $up){
		// 		$name_login=$result['id'];
		// 		$sql_c_level="SELECT * FROM `level_detail` WHERE `id` = '$name_login'";
		// 		$cf_level = $this->db->prepare($sql_c_level);
		// 		$cf_level->execute();
		// 		$level_result = $cf_level->fetchAll();

		// 		$vcode = array([
		// 			"filedatas" => "1",
		// 			"idus" => $name_login
		// 		]);
		// 	}else{
		// 		$vcode = array([
		// 			"filedatas" => '0'
		// 		]);
		// 	}
		// }else{
		$vcode = array([
			"sumon" => $result['user_id'],
			"setmon" => $result['user_password']
		]);
		// }

		return $response->withJson($vcode, 200);
		// json_encode($response);
	});


	$app->post("/login/staf/dash/in/{ul}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);
		require 'link/surat/link_surat.php';
		// $un = $_POST["user_name"];
		// $up = $_POST["user_password"];

		$postencript = $_POST["user_name"];
		require 'fuction/decript.php';
		$un = trim($plaintext_dec);

		$postencript = $_POST["user_password"];
		require 'fuction/decript.php';
		$up = trim($plaintext_dec);

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
					"filedatas" => '0'
				]);
			}
		} else {
			$vcode = array([
				"filedatas" => "0a"
			]);
		}

		return $response->withJson($vcode, 200);
		// json_encode($response);
	});
	$app->get("/kua/search/{inview}", function (Request $request, Response $response, $args) {
		$idus = $_GET['uid'];
		// id AS nd, level_id AS nl, id_urt AS nr, grub_id AS ng, id_hidden AS nh
		$sql = "SELECT id AS nd, level_id AS nl, id_urt AS nr, grub_id AS ng, id_hidden AS nh FROM `level_detail` where id='$idus' AND level_id='18'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		// $dataready = $result ;
		// require 'fuction/encript.php';
		// $resulten = $ciphertext_base64;

		$sql2a = "SELECT * FROM `level_detail` where id='$idus' AND level_id='18'";
		$stmt2a = $this->db->prepare($sql2a);
		$stmt2a->execute();
		$rstmt2a = $stmt2a->fetch();
		$nstmt2a = $stmt2a->rowCount();

		if ($nstmt2a == "") {
			$ak = 0;
		} else {
			if ($rstmt2a['level_id'] == 18) {
				$ak = 18;
			} else {
				$ak = 0;
			}
		}

		$dataready = $ak;
		require 'fuction/encript.php';
		$acc = $ciphertext_base64;

		$sql2 = "SELECT * FROM `user_entity` where id='$idus'";
		//$sql="SELECT * FROM sent_letter where id_hidden=1";
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
			'lv' => $result,
			'aks' => $acc,
			'user_id' => $usid,
			'user_nama' => $result2['user_name'],
			'usid' => $usid2id
		]);

		return $response->withJson($vcode, 200);
	});
	// ---------------------------------- HRD APP -----------------------------------------------


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
		// id AS nd, level_id AS nl, id_urt AS nr, grub_id AS ng, id_hidden AS nh
		$sql = "SELECT id AS nd, level_id AS nl, id_urt AS nr, grub_id AS ng, id_hidden AS nh FROM `level_detail` where id='$idus' AND level_id='19'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();

		// $dataready = $result ;
		// require 'fuction/encript.php';
		// $resulten = $ciphertext_base64;

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

		$dataready = $ak;
		require 'fuction/encript.php';
		$acc = $ciphertext_base64;

		$sql2 = "SELECT * FROM `user_entity` where id='$idus'";
		//$sql="SELECT * FROM sent_letter where id_hidden=1";
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
			'lv' => $result,
			'aks' => $acc,
			'user_id' => $usid,
			'user_nama' => $result2['user_name'],
			'usid' => $usid2id
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

	$app->get("/tampil/hrd/{view}", function (Request $request, Response $response, $args) {

		$sql = "SELECT * FROM `user_entity` ORDER BY `id` DESC ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		$nn = 1;

		while ($result = $stmt->fetch()) {
			if ($result['id'] == 1 or $result['id'] == 2 or $result['id'] == 5 or $result['id'] == 154 or $result['id'] == 218) {
			} else {
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

				$a = array_push($res, $h);
			}
		}

		return $response->withJson($res, 200);
	});

	$app->post("/tambah/user/hrd/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
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
		// $datemasuk= date_format($date_now, "Y-m-d");
		$datemasuk = $date_now;
		// require_once("link/modul/Cipher.php");
		// $cipher = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);

		$kunci = "UptSI";
		$string = $upd;

		$b1 = base64_encode($string);
		$b2 = base64_encode($b1);

		$dup = $b2;

		// $dup = $cipher->encrypt($cipher->encrypt($string, $kunci), $kunci);


		$csql_user = "SELECT * FROM user_entity WHERE user_id='$uid'";
		$cstmt_user = $this->db->prepare($csql_user);
		$cstmt_user->execute();
		$result = $cstmt_user->fetch();

		// $id = $result['id'];

		if ($cstmt_user->rowCount() == 0) {

			$sql = "INSERT INTO `user_entity` (`id`, `user_id`, `user_name`, `user_password`, `tgl_masuk`, `tgl_keluar`, `user_pass_def`, `alamat`, `alamat_sekarang`, `no_hp`, `tempat`, `tanggal_lahir`, `jenis_kelamin`, `nidn`, `no_ktp`, `status_nikah`, `posisi1`, `posisi2`, `jabatan`, `jurusan_dosen`,`status_dosen`, `bpjs_kesehatan`, `masa_aktif_kesehatan`, `bpjs_ketenagakerjaan`, `masa_aktif_ketenagakerjaan`, `jenjang`,`foto`, `id_hidden`) 
			VALUES (NULL, '$uid', '$un', '$dup', '$datemasuk', NULL, '$upd', '$almt', '$almtnow', '$hp', '$tmpt', '$tgllahir', '$jnsklmn', '$nidn', '$ktp', '$nikah', '$ps1', '$ps2', '$dvs', '$jurdos', '$stados', '$bpjs_kshtn', '$ms_kshtn', '$bpjs_ktngkrjn', '$ms_ktngkrjn', '$jenjang','',1)";
			// $sql = "INSERT INTO `user_entity` (`id`, `user_id`, `user_name`, `user_password`, `tgl_masuk`, `tgl_keluar`, `user_pass_def`, `alamat`,`alamat_sekarang`, `no_hp`, `tempat`, `tanggal_lahir`, `jenis_kelamin`, `nidn`, `no_ktp`, `status_nikah`, `posisi1`, `posisi2`, `jabatan`, `id_hidden`) 
			// VALUES (NULL, '$uid', '$un', '$dup', '$datemasuk', NULL, '$upd', '$almt','$almtnow', '$hp', '$tmpt', '$tgllahir', '$jnsklmn', '$nidn', '$ktp', '$nikah', '$ps1', '$ps2', '$dvs', 1)";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

			$cek = 1;

			$sqlId = "SELECT * FROM `user_entity` ORDER BY id DESC LIMIT 1";
			$oghey = $this->db->prepare($sqlId);
			$oghey->execute();
			$roghey = $oghey->fetch();
			// $id = $roghey['id'];
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

	$app->post("/hrd/updet/user/{up}", function (Request $request, Response $response, $args) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		// $id = $_GET['id'];

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



		// $sql="UPDATE `user_entity` SET `user_id` = '$usid', `user_name` = '$usnm', `tgl_masuk`='$date_now',`tgl_keluar`='$tglkr',`user_pass_def` = '$uspf',`alamat`='$almt', `no_hp`='$hp', `nidn` = '$nidn',`posisi1`='$ps1',`posisi2`='$ps2', `jabatan`='$dvs' WHERE `id` = '$id' ";
		// $sql = "UPDATE `user_entity` SET `user_id` = '$usid', `user_name` = '$usnm',  `tgl_masuk` = '$datemasuk', `tgl_keluar` = '$datekeluar', `alamat` = '$almt', `alamat_sekarang`='$almtnow', `no_hp` = '$hp', `tempat` = '$tmpt', `tanggal_lahir` = '$tgllahir', `jenis_kelamin` = '$jnsklmn', `nidn` = '$nidn', `no_ktp` = '$ktp', `status_nikah` = '$nikah', `posisi1` = '$ps1', `posisi2` = '$ps2', `jabatan` = '$dvs' WHERE `id` = '$id'";
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

	$app->post("/upload/gambar/user/{add}", function (Request $request, Response $response) {
		require 'link/hrd/linkGbr.php';
		// $id = $_GET['id'];
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

	$app->post("/upld/gmbr/{add}", function (Request $request, Response $response) {
		require 'link/hrd/linkGbr.php';
		// $id = $_GET['id'];
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

	$app->put("/nonaktif/user/hrd/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		// $id = $_GET['id'];
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		// $dataready = $_GET['id'] ;
		// require 'fuction/encript.php';
		// $id = $ciphertext_base64;

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

	$app->put("/aktifkan/orang/user/hrd/{dl}", function (Request $request, Response $response) {
		$_POST = json_decode(file_get_contents("php://input"), true);

		// $id = $_GET['id'];
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		// $dataready = $_GET['id'] ;
		// require 'fuction/encript.php';
		// $id = $ciphertext_base64;

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

	// =================================ABSENSI HRD=======================

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
			// $id = $roghey['id'];
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

	$app->post("/upload/file/absensi/{add}", function (Request $request, Response $response) {
		require 'link/hrd/linkAbsen.php';
		// $id = $_GET['id'];
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

	$app->delete("/absHps/absensi/{add}/", function (Request $request, Response $response, $args) {
		require 'link/hrd/linkAbsen.php';
		// $id = $_GET['id'];
		$postencript = $_GET['id_absensihrd'];
		require 'fuction/decript.php';
		$id=trim($plaintext_dec);

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

	// ======================JADWAL HRD==================

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

	$app->get("/tampil/nama/dosen/jadwal/{view}", function (Request $request, Response $response, $args) {

		// $sql = "SELECT * FROM `user_entity` WHERE `nidn`!=''  ORDER BY `id` DESC ";
		// SELECT * FROM `user_entity` WHERE `posisi1` = 'Dosen FTD' OR `posisi1`='Dosen FEB'
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

	$app->get("/detail/jadwal/hrd/{view}", function (Request $request, Response $response, $args) {
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);
		
		$sql = "SELECT * FROM `user_entity` WHERE `id` = '$id' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();
		// $nn = 1;

		while ($result = $stmt->fetch()) {
			
			$sql2 = "SELECT * FROM `jadwal_hrd` WHERE `id_user` = '$id' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$vhari = $result2['hari'];
			if ($vhari == 1) {
				$hari = 'Senin';
			}elseif ($vhari == 2) {
				$hari = 'Selasa';
			}elseif ($vhari == 3) {
				$hari = 'Rabu';
			}elseif ($vhari == 4) {
				$hari = 'Kamis';
			}elseif ($vhari == 5) {
				$hari = 'Jumat';
			}elseif ($vhari == 6) {
				$hari = 'Sabtu';
			}else{
				$hari = 'Minggu';
			}

			$h['merah'] = $result['user_name'];
			$h['jingga'] = $result['posisi1'];
			$h['hitam'] = $result['posisi2'];
			$h['kuning'] = $result['status_dosen'];
			$h['ungu'] = $result['jurusan_dosen'];
			$h['putih'] = $result['nidn'];
			$h['hijau'] = $result2['id_jadwal'];
			$h['pink'] = $hari;
			$h['biru'] = $result2['jam'];
			$h['nila'] = $result2['absen_tempat'];
			$h['st'] = $result2['status_jadwal'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

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
			}elseif ($vhari == 2) {
				$hari = 'Selasa';
			}elseif ($vhari == 3) {
				$hari = 'Rabu';
			}elseif ($vhari == 4) {
				$hari = 'Kamis';
			}elseif ($vhari == 5) {
				$hari = 'Jumat';
			}elseif ($vhari == 6) {
				$hari = 'Sabtu';
			}else{
				$hari = 'Minggu';
			}

			$h['koceng'] = $nn++;
			$h['kerbau'] = $result['id_jadwal'];
			$h['sapi'] = $hari;
			$h['kambing'] = $result['jam'];
			$h['ayam'] = $result['absen_tempat'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	// -------------CRUD PEGAWAI--------
	$app->post("/tambah/jadwal/hrd/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
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

		if($stmt){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/edit/jadwal/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
		$_POST = json_decode(file_get_contents("php://input"), true);

		$idj = $_GET['id_jadwal'];
		// include 'fuction/decript.php';
		// $id = trim($plaintext_dec);
		
		$hari = $_POST["hari"];
		$jam = $_POST["jam"];
		$absn = $_POST["absen_tempat"];

		// $sql = "SELECT * FROM `jadwal_hrd` WHERE `id_jadwal` = '$idj' ";
		// $stmt = $this->db->prepare($sql);
		// $stmt->execute();
		// $result = $stmt->fetch();
			
		$sql = "UPDATE `jadwal_hrd` SET `hari` = '$hari', `jam` = '$jam', `absen_tempat` = '$absn' WHERE `id_jadwal` = '$idj' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if($stmt){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->delete("/hps/jadwal/hrd/{add}/", function (Request $request, Response $response, $args) {
		// require 'link/hrd/linkAbsen.php';
		$id = $_GET['id_jadwal'];
		
		$sql = "DELETE FROM `jadwal_hrd` WHERE `id_jadwal` = '$id' ";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		
		if($imsgs){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$validasi = array([
			"validasi" => $cek
		]);
		return $response->withJson($validasi, 200);
	});

	// -------CRUD DOSEN--------

	$app->get("/tampil/semua/hal/kapro/{view}", function (Request $request, Response $response, $args) {

		// $idus = $_GET['idus'];
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
			$ids=$result['id_user'];

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
			$h['sapi'] = $result['hari'];
			$h['st'] = $result['status_jadwal'];
			// $h['ayam'] = $result['absen_tempat'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	$app->get("/tam/jadwal/dekan/{view}", function (Request $request, Response $response, $args) {

		// $idus = $_GET['idus'];
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
			$ids=$result['id_user'];

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
			$h['sapi'] = $result['hari'];
			$h['st'] = $result['status_jadwal'];
			// $h['ayam'] = $result['absen_tempat'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});
	
	$app->get("/muncul/jadwal/hrd/{view}", function (Request $request, Response $response, $args) {

		// $idus = $_GET['idus'];
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
			$ids=$result['id_user'];

			$sql2 = "SELECT * FROM `user_entity` WHERE`id` = '$ids' ";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();
			$result2 = $stmt2->fetch();

			$h['no'] = $nn++;
			$h['ids'] = $result2['id'];
			$h['nm'] = $result2['user_name'];
			$h['sapi'] = $result['hari'];
			$h['st'] = $result['status_jadwal'];
			// $h['ayam'] = $result['absen_tempat'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

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
			}elseif ($vhari == 2) {
				$hari = 'Selasa';
			}elseif ($vhari == 3) {
				$hari = 'Rabu';
			}elseif ($vhari == 4) {
				$hari = 'Kamis';
			}elseif ($vhari == 5) {
				$hari = 'Jumat';
			}elseif ($vhari == 6) {
				$hari = 'Sabtu';
			}else{
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

	$app->post("/insert/jadwal/dosen/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
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
		$jur = $result2['jurusan_dosen'];

		if($jur == "Manajemen"){

			$sqlm = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-PMB' AND `id_hidden`='1' ";
			$stmtm = $this->db->prepare($sqlm);
			$stmtm->execute();
			$resultm = $stmtm->fetch();
			$strukm = $resultm['id_rektor'];

			$sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) 
			VALUES (NULL, '$id', '$hari', '$jam', '$absn', '0', '$strukm')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}elseif($jur == "Akuntansi"){
			$sqla = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-AK' AND `id_hidden`='1' ";
			$stmta = $this->db->prepare($sqla);
			$stmta->execute();
			$resulta = $stmta->fetch();
			$struka = $resulta['id_rektor'];

			$sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) 
			VALUES (NULL, '$id', '$hari', '$jam', '$absn', '0', '$struka')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			
		}elseif($jur == "Teknik Informatika"){
			$sqli = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-INF' AND `id_hidden`='1' ";
			$stmti = $this->db->prepare($sqli);
			$stmti->execute();
			$resulti = $stmti->fetch();
			$struki = $resulti['id_rektor'];

			$sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) 
			VALUES (NULL, '$id', '$hari', '$jam', '$absn', '0', '$struki')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}elseif($jur == "DKV"){
			$sqld = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-DKV' AND `id_hidden`='1' ";
			$stmtd = $this->db->prepare($sqld);
			$stmtd->execute();
			$resultd = $stmtd->fetch();
			$strukd = $resultd['id_rektor'];

			$sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) 
			VALUES (NULL, '$id', '$hari', '$jam', '$absn', '0', '$strukd')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}else{
			$sqls = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-SK' AND `id_hidden`='1' ";
			$stmts = $this->db->prepare($sqls);
			$stmts->execute();
			$results = $stmts->fetch();
			$struks = $results['id_rektor'];

			$sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) 
			VALUES (NULL, '$id', '$hari', '$jam', '$absn', '0', '$struks')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}

		// $sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`) 
		// VALUES (NULL, '$id', '$hari', '$jam', '$absn', '0')";
		// $stmt = $this->db->prepare($sql);
		// $stmt->execute();

		if($stmt){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/ajukan/jadwal/dosen/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql2 = "SELECT * FROM `user_entity`  WHERE `id` = '$id' ";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();
		$jur = $result2['jurusan_dosen'];

		if($jur == "Manajemen"){

			$sqlm = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-PMB' AND `id_hidden`='1' ";
			$stmtm = $this->db->prepare($sqlm);
			$stmtm->execute();
			$resultm = $stmtm->fetch();
			$strukm = $resultm['id_rektor'];

			$sql = "INSERT INTO `jadwal_hrd` (`id_jadwal`, `id_user`, `hari`, `jam`, `absen_tempat`, `status_jadwal`, `id_struktural`) 
			VALUES (NULL, '$id', '$hari', '$jam', '$absn', '0', '$strukm')";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}elseif($jur == "Akuntansi"){
			$sqla = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-AK' AND `id_hidden`='1' ";
			$stmta = $this->db->prepare($sqla);
			$stmta->execute();
			$resulta = $stmta->fetch();
			$struka = $resulta['id_rektor'];

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '1', `id_struktural`= '$struka' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			
		}elseif($jur == "Teknik Informatika"){
			$sqli = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-INF' AND `id_hidden`='1' ";
			$stmti = $this->db->prepare($sqli);
			$stmti->execute();
			$resulti = $stmti->fetch();
			$struki = $resulti['id_rektor'];

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '1', `id_struktural`= '$struki' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}elseif($jur == "DKV"){
			$sqld = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-DKV' AND `id_hidden`='1' ";
			$stmtd = $this->db->prepare($sqld);
			$stmtd->execute();
			$resultd = $stmtd->fetch();
			$strukd = $resultd['id_rektor'];

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '1', `id_struktural`= '$strukd' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}else{
			$sqls = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'KP-SK' AND `id_hidden`='1' ";
			$stmts = $this->db->prepare($sqls);
			$stmts->execute();
			$results = $stmts->fetch();
			$struks = $results['id_rektor'];

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '1', `id_struktural`= '$struks' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}
			
		// $sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '1' WHERE `id_user` = '$id' ";
		// $stmt = $this->db->prepare($sql);
		// $stmt->execute();

		if($stmt){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/ajukan/jdwl/kaprodi/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql2 = "SELECT * FROM `user_entity`  WHERE `id` = '$id' ";
		$stmt2 = $this->db->prepare($sql2);
		$stmt2->execute();
		$result2 = $stmt2->fetch();
		$jur = $result2['jurusan_dosen'];

		if($jur == "Manajemen" OR $jur=="Akuntansi"){
			$sqlm = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FEB' AND `id_hidden`='1' ";
			$stmtm = $this->db->prepare($sqlm);
			$stmtm->execute();
			$resultm = $stmtm->fetch();
			$strukm = $resultm['id_rektor'];

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '2', `id_struktural`='$strukm' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();

		}else{
			$sqld = "SELECT * FROM `struktural`  WHERE `rektor_id` = 'FTD' AND `id_hidden`='1' ";
			$stmtd = $this->db->prepare($sqld);
			$stmtd->execute();
			$resultd = $stmtd->fetch();
			$strukd = $resultd['id_rektor'];

			$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '2', `id_struktural`='$strukd' WHERE `id_user` = '$id' ";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		}
			

		if($stmt){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/tidak/setuju/jadwal/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
		$_POST = json_decode(file_get_contents("php://input"), true);

		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		// $sql = "SELECT * FROM `jadwal_hrd` WHERE `id_jadwal` = '$idj' ";
		// $stmt = $this->db->prepare($sql);
		// $stmt->execute();
		// $result = $stmt->fetch();
			
		$sql = "UPDATE `jadwal_hrd` SET `status_jadwal` = '0' WHERE `id_user` = '$id' ";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if($stmt){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->post("/updet/jdw/dekan/{add}", function (Request $request, Response $response, $args) {
		// require 'link/surat/link_surat.php';
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

		if($stmt){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$vcode = array([
			"filedatas" => $cek
		]);

		return $response->withJson($vcode, 200);
	});

	$app->delete("/hps/jdw/dosen/{add}", function (Request $request, Response $response, $args) {
		// require 'link/hrd/linkAbsen.php';
		$id = $_GET['id_jadwal'];
		
		$sql = "DELETE FROM `jadwal_hrd` WHERE `id_jadwal` = '$id' ";
		$imsgs = $this->db->prepare($sql);
		$imsgs->execute();
		
		if($imsgs){
			$cek = 1;
		}else{
			$cek = 0;
		}

		$validasi = array([
			"validasi" => $cek
		]);
		return $response->withJson($validasi, 200);
	});

	// ===================-----------APLIKASI SIMAKA FO ASIA-----------====================
	
	// ======LOGIN=====
		$app->post("/login/simaka/fo/{ul}", function (Request $request, Response $response, $args) {
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
	
		$app->get("/simaka/login/search/{inview}", function (Request $request, Response $response, $args) {
			$idus = $_GET['uid'];
			// id AS nd, level_id AS nl, id_urt AS nr, grub_id AS ng, id_hidden AS nh
			$sql = "SELECT id AS nd, level_id AS nl, id_urt AS nr, grub_id AS ng, id_hidden AS nh FROM `level_detail` where id='$idus' AND level_id='23'";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
	
			// $dataready = $result ;
			// require 'fuction/encript.php';
			// $resulten = $ciphertext_base64;
	
			$sql2a = "SELECT * FROM `level_detail` where id='$idus' AND level_id='23'";
			$stmt2a = $this->db->prepare($sql2a);
			$stmt2a->execute();
			$rstmt2a = $stmt2a->fetch();
			$nstmt2a = $stmt2a->rowCount();
	
			if ($nstmt2a == "") {
				$ak = 0;
			} else {
				if ($rstmt2a['level_id'] == 23) {
					$ak = 23;
				} else {
					$ak = 0;
				}
			}
	
			$dataready = $ak;
			require 'fuction/encript.php';
			$acc = $ciphertext_base64;
	
			$sql2 = "SELECT * FROM `user_entity` where id='$idus'";
			//$sql="SELECT * FROM sent_letter where id_hidden=1";
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
				'lv' => $result,
				'aks' => $acc,
				'user_id' => $usid,
				'user_nama' => $result2['user_name'],
				'usid' => $usid2id
			]);
	
			return $response->withJson($vcode, 200);
		});
	
		$app->get("/mencari/aks/fo/log/{vvv}", function (Request $request, Response $response) {
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
	
	//========MENU============
	$app->get("/fo/cari/sign/{cari}", function (Request $request, Response $response){
		include 'link/surat/link_surat.php';
		$postencript = $_GET['id'];
		include 'fuction/decript.php';
		$id = trim($plaintext_dec);

		$sql = "SELECT id AS sp, user_id AS ui FROM `user_entity` WHERE id='$id' ORDER BY `id` DESC LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		return $response->withJson($res, 200);
	}); 

	$app->get("/aks/cari/fo/{vvv}", function (Request $request, Response $response) {
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

	// =======VIEW=======
	$app->get("/tampil/admin/fo/{v}", function (Request $request, Response $response, $args) {
		// $postencript = $_GET['id'];
		// include 'fuction/decript.php';
		// $idus = trim($plaintext_dec);

		$sql = "SELECT * FROM `user_entity`";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = array();

		while ($result = $stmt->fetch()) {

			// $dataready = $result['id'];
			// require 'fuction/encript.php';
			// $ids = $ciphertext_base64;
			$h['ids'] = $result['id'];
			$h['nm'] = $result['user_name'];

			$a = array_push($res, $h);
		}

		return $response->withJson($res, 200);
	});

	// APP FO Ok Ok .......... 

	$app->get("/menu/fo/list/{ck}", function (Request $request, Response $response, $args){
		
		// $postencript = $_GET['ids'];
		// include 'fuction/decript.php';
		// $idus = $plaintext_dec;
		// $apps = $_GET['apps'];
		$idus = $_GET['id'];
		// $postencript = $_GET['ak'];
		// include 'fuction/decript.php';
		// $ak=$plaintext_dec;
		$ak=$_GET['ak'];
		// $sql1 = "SELECT * FROM `user_entity` WHERE `id` = '$ids'";
		$sql1 = "SELECT user_entity.id, level_detail.grub_id, user_grub.nama_grup, rule2.id_rule2, rule2.menu_id, menu.menu_name AS mgname, menu.link AS mslink, menu.idm AS ckstm, menu.sub_menu_id, menu.aplikasi_id, aplikasi.nama_aplikasi, aplikasi.id_hidden FROM user_entity JOIN level_detail ON user_entity.id=level_detail.id JOIN user_grub ON level_detail.grub_id=user_grub.grub_id JOIN rule2 ON level_detail.grub_id=rule2.grub_id JOIN menu ON rule2.menu_id=menu.menu_id JOIN aplikasi ON menu.aplikasi_id=aplikasi.aplikasi_id where level_detail.level_id='$ak' AND user_entity.id='$idus' AND aplikasi.id_hidden='1' AND `idm` = 'grup'";
		$stmt1 = $this->db->prepare($sql1);
		$stmt1->execute();
		
		// $res2 = array();
		// $n2=1;
		// while ($rstmt1 = $stmt1->fetch()) {
		// 	$menuid = $rstmt1['menu_id'];
		// 	$sql2 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$menuid' AND `aplikasi_id` = 11 AND `idm` = 'sub' AND `id_hidden` = 1";
		// 	$stmt2 = $this->db->prepare($sql2);
		// 	$stmt2->execute();

		// 	$arr = array();
		// 	while ($rstmt2 = $stmt2->fetch()) {
		// 		$h2['mslink']= $rstmt2['menu_name'];

		// 		$a = array_push($arr, $h2);
		// 	}
		// }

		$res = array();
		$n=1;
		while ($rstmt1 = $stmt1->fetch()) {
			$menuid = $rstmt1['menu_id'];
			$sql2 = "SELECT * FROM `menu` WHERE `sub_menu_id` = '$menuid' AND `aplikasi_id` = 11 AND `idm` = 'sub' AND `id_hidden` = 1";
			$stmt2 = $this->db->prepare($sql2);
			$stmt2->execute();

			$arr = array();
			$nosub = 1;
			while ($rstmt2 = $stmt2->fetch()) {
				// $h2['nosub']= $nosub++;
				$h2['nosub']= $rstmt2['menu_id'];
				$h2['mslink']= $rstmt2['menu_name'];
				$h2['linknya']= $rstmt2['link'];

				$a = array_push($arr, $h2);
			}

			$h['n']= $n++;
			$h['gmenu']= $rstmt1['mgname'];
			$h['smenu']= $arr;

			// $h['ckstm']= $rstmt1['ckstm'];
			// $h['mslink']= $rstmt1['mslink'];

			$a = array_push($res, $h);
		}
	
		return $response->withJson($res, 200);
	});

$app->get("/daftar/pg/list/view", function (Request $request, Response $response){
		include 'link/surat/link_surat.php';

			$sql = "SELECT id, user_name FROM `user_entity`";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			// $result = $stmt->fetchAll();
			$res = array();
			while ($result = $stmt->fetch()) {
				$h['nomer'] = $result['id'];
				// $h['user_id'] = $result['user_id'];
				$h['label'] = $result['user_name'];
				// $h['nidn'] = $result['nidn'];
				// $h['id_hidden'] = $result['id_hidden'];
				// $h['id'] = $result['id'];
				$a = array_push($res, $h);
			}

		return $response->withJson($res, 200);
	});

	
};

};
