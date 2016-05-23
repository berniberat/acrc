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
		
?>
		<html>			
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0" />
				<title></title>
				<link rel="stylesheet" type="text/css" href="stili.css">
    			<script type="text/javascript" src="jquery-2.2.3.min.js"></script>
    			<script src='loadingBar/nprogress.js'></script>
				<link rel='stylesheet' href='loadingBar/nprogress.css'/>
				<script type="text/javascript">
    			$(document).ready(function(){
    				$("main").on('click', "#sendCod", function(e) {
    					$('#codice').prop('disabled',true);
    					error = "";
    					NProgress.start();
    					var codice = $.trim($("#codice").val());
    					var logType = "cardiochirurghi";
    					var pass = "no";
    					if (codice.length < 0 || codice == ""){
   						error = "Inserisci il codice personale!";
   					}
   					if (error == "") {
    						$.ajax({
            				type: 'POST',
            				url: 'login-redirect.php',
            				data: '&codice='+ codice + '&logType='+ logType + '&pass='+ pass,
            				dataType: 'json',
            				cache: false,
           					success: function(result) {
           						if (result === "Login effettuato con successo!") {
           							NProgress.done();
           							window.location.replace("profilo-card.php");
           						}else {
           							if (result === "notfinded") {
           								result = "I dati inseriti risultano essere sbagliati!";
           							}
           							if (result === "notexecuted") {
           								result = "Errore riscontrato con il database!";
           							}
           							if (result === "categorynotexists") {
           								result = "La categoria ricercata non esiste!";
           							}
           							if ($('#messageAlert').length) {
	     									NProgress.done();
	     									$('#codice').prop('disabled',false);
										}else{
   										$("main").append('<div id="messageAlert">'+result+'</div>');
   										setTimeout('$("#messageAlert").remove()',2000); 
   										$('#codice').prop('disabled',false);
   										NProgress.done();
   		           			   }
           							
           						}			
            				},
            				error: function(e, xhr){
   								console.log(e + "-" + xhr)
  								}
       					});
       				}else {
   						if ($('#messageAlert').length) {
	     						NProgress.done();
	     						$('#codice').prop('disabled',false);
							}else{
   							$("main").append('<div id="messageAlert">'+error+'</div>');
   							setTimeout('$("#messageAlert").remove()',2000); 
   							$('#codice').prop('disabled',false);
   							NProgress.done();
   		            }
   					} 	
    				});
    			});
    			</script>
			</head>
			<body>
			 	<main>
			 		<a href="index.php">
			 	 		<header id="img_logo">
			 	 		</header>
			 	 	</a>
			 	 	<section class="input_container">
			 	 		<input type="text" id="codice" name="codice" class="inputCod" placeholder="Inserisci qui il tuo codice..."/>
			 	 		<input type="submit" id="sendCod" class="bottSend" value="Effettua Login"/>
			 	 	</section>
			 	</main>
			</body>
		</html>
<?php 
	}
?>