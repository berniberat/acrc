<?php
	session_start();
	if($_SERVER["HTTPS"] != "on"){
    	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
   	 exit();
	}
	include ('engine.php');
	$ip_osp = $_SERVER['REMOTE_ADDR'];
	$browser_osp = $_SERVER['HTTP_USER_AGENT'];
	$ora_accesso = date('H:i:s');
	$dat_accesso = date('d-m-Y');
	$pagina_osp = "index.php";
	
	$rifOspite = new engine($ip_osp,$browser_osp,$ora_accesso,$dat_accesso,$pagina_osp);
	/////////////////////////////////////
	$s = serialize($rifOspite);
	$nomeFile =$rifOspite->random_string("20");
	$_SESSION["nFL"]=$nomeFile;
  	$fp = fopen("tempFile/".$nomeFile, "w");
  	fputs($fp, $s);
  	fclose($fp);
	/////////////////////////////////////
	$risConnessione = $rifOspite->connessioneDB();
	if($risConnessione){
		$rifOspite->insertOspite();
?>
		<html>			
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0" />
				<title></title>
				<link rel="stylesheet" type="text/css" href="stili.css">
    			<script type="text/javascript" src="jquery-2.2.3.min.js"></script>
    			<script type="text/javascript" src="jq_index.js"></script>
    			<script src='loadingBar/nprogress.js'></script>
				<link rel='stylesheet' href='loadingBar/nprogress.css'/>
			</head>
			<body>
			 	<main>
			 	 	<header id="img_logo">
			 	 	</header>
			 	 	<a href="#">
			 	 		<section id="btn_about_us" class="btn_menu_index">
			 	 			Chi siamo?
			 	 		</section>
			 	 	</a>
			 	 	<a href="login-form-card.php">
			 	 		<section id="btn_log_card" class="btn_menu_index">
			 	 			Sono un cardiologo!
			 	 		</section>
			 	 	</a>
			 	 	<a href="login-form-med.php">
			 	 		<section id="btn_log_med" class="btn_menu_index">
			 	 			Sono un medico!
			 	 		</section>
			 	 	</a>
			 	 	<a href="#">
			 	 		<section id="btn_log_osp" class="btn_menu_index">
			 	 			Sono un ospite!
			 	 		</section>
			 	 	</a>
			 	</main>
			</body>
		</html>
<?php 
	}
?>