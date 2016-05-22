<?php
	session_start();
	include ('engine.php');
	if(isset($_SESSION["id_session"])) {
		if(isset($_POST["title"]) && isset($_POST["request"])) {
			if(trim($_POST["title"]) <> "" && trim($_POST["request"]) <> "") {
					/////////////////////////////////////////////////
					$nomeFile=$_SESSION["nFL"];
					$s = implode("", file("tempFile/".$nomeFile));
					$rifUtente = unserialize($s);
					/////////////////////////////////////////////////
					$risConnessione = $rifUtente->connessioneDB();
					if($risConnessione){
						echo $rifUtente->insertRequest($_POST["title"],$_POST["request"]);
					}
			}
		}
	}
?>