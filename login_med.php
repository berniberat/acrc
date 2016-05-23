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
	$pagina_osp = "login-form-card.php";
	
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
        readfile("login_med.html");
	}
?>