<?php
	session_start();
	include ('engine.php');
	if(isset($_SESSION["id_session"])) {
		if(isset($_POST["codice"])) {
			if(trim($_POST["codice"]) <> "") {
				if(isset($_POST["logType"])) {
					if(trim($_POST["logType"]) <> "") {
						/////////////////////////////////////////////////
						$nomeFile=$_SESSION["nFL"];
						$s = implode("", file("tempFile/".$nomeFile));
						$rifUtente = unserialize($s);
						/////////////////////////////////////////////////
						$risConnessione = $rifUtente->connessioneDB();
						if($risConnessione){
							echo json_encode($rifUtente->login($_POST["codice"], $_POST["logType"], $_POST["pass"]));
						}
					}
				}
			}
		}
	}
?>