<?php
	session_start();
	include ('engine.php');
	if(isset($_SESSION["id_session"])) {
		if(isset($_POST["title"])) {
			if(trim($_POST["title"]) <> "") {
					/////////////////////////////////////////////////
					$nomeFile=$_SESSION["nFL"];
					$s = implode("", file("tempFile/".$nomeFile));
					$rifUtente = unserialize($s);
					/////////////////////////////////////////////////
					$risConnessione = $rifUtente->connessioneDB();
					if($risConnessione){
						echo json_encode($rifUtente->findSimilarRequests($_POST["title"]));
					}
			}
		}
	}
?>