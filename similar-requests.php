<?php
	session_start();
	include ('engine.php');
	if(isset($_SESSION["id_session"])) {
		if(isset($_GET["title"])) {
			if(trim($_GET["title"]) <> "") {
					/////////////////////////////////////////////////
					$nomeFile=$_SESSION["nFL"];
					$s = implode("", file("tempFile/".$nomeFile));
					$rifUtente = unserialize($s);
					/////////////////////////////////////////////////
					$risConnessione = $rifUtente->connessioneDB();
					if($risConnessione){
						//echo $_POST["title"];
						$title = $rifUtente->cleanInput($_GET["title"]);
?>
						<html>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<head>
								<title></title>
								<link rel="stylesheet" type="text/css" href="stili.css">
    							<script type="text/javascript" src="jquery-2.2.3.min.js"></script>
    							<script src='loadingBar/nprogress.js'></script>
								<link rel='stylesheet' href='loadingBar/nprogress.css'/>
								
    							<script type="text/javascript">
    								$(document).ready(function(){
    									var title = "<?php echo $title; ?>";
    									$.ajax({
            								type: 'POST',
            								url: 'send_similar-requests.php',
            								data: 'title='+ title,
            								dataType: 'json',
            								cache: false,
           							   	success: function(result) {
														var arrayLength = result.length;
														for (var i = 0; i < arrayLength; i++) {
    															var arrRes = result[i].split("-");	
    															var idReq = arrRes[0];
    															var titleReq = arrRes[1];
    															var request = arrRes[2];
    															var date = arrRes[3];
																var time = arrRes[4];
    															var NumOcc = arrRes[5];
 																
    															$("#master_container").append('<div id="similarRequestChild" class="'+idReq+'"><div id="similarRequestChild_inside_top">'+titleReq+'</div><font style="color:#999;font-size:12px;">Pubblicato il: '+date+' alle: '+time+'</font></div>');
    													}
            								},
            								error: function(e, xhr){
   												console.log(e + "-" + xhr)
  												}
       								 });
    								});
    								
    								$(document).ready(function(){
    									 $("#master_container").on('click', "#sendEmailContact", function(e) {
   											$('#sendEmailContact').prop('disabled',true);
   											NProgress.start();
   											var error = "";
   											var email = $.trim($("#similarRequestEmailField").val());
   											
   											if (email.length < 0 || email == ""){
   												error = "Inserisci un contatto e-mail!"
   											}
   											
   											if (error == "") {
   												//DA SVILUPPARE
   												//DA SVILUPPARE 
   												//DA SVILUPPARE
   											}else {
   												if ($('#messageAlert').length) {
	     												NProgress.done();
	     												$('#sendEmailContact').prop('disabled',false);
													}else{
   													$("#master_container").append('<div id="messageAlert">'+error+'</div>');
   													setTimeout('$("#messageAlert").remove()',2000); 
   													$('#sendEmailContact').prop('disabled',false);
   													NProgress.done();
   												}
   											} 	
   									 });
    								});
    							</script>
    							
    							<script type="text/javascript">
    								$(document).ready(function(){
    									$("#master_container").on('click', "#similarRequestChild", function(e) {
    										var id = $(this).attr("class");
    										window.location.href = "domanda.php?id="+id;
    									});
    								});
    							</script>
							</head>
							<body>
			 					<div id="master_container">
			 						<div id="similarRequestInfo">
			 							<center><h2><font color="#006F37">Congratulazioni, ce l'hai fatta!</font></h2></center>
			 							La tua <b>domanda</b> è stata <b>inoltrata</b> ai nostri <b>Specialisti</b> e presto riceverai una <b>risposta</b>!
			 							<b>Controlla</b> periodicamente la <b>bacheca delle ultime domande</b> per visualizzare la risposta dello Specialista.<br><br>
			 							Altrimenti <b>inserisci</b> <b>qui sotto</b> il tuo <b>contatto e-mail</b> e, appena la tua domanda riceverà una risposta, ti <b>aggiorneremo</b> spedendoti una mail!<br><br>
			 							In <b>attesa</b> della risposta, ti proponiamo di <b>leggere</b> alcune delle <b>domande</b> formulate da altri utenti che <b>affrontano un caso simile al tuo</b>: 
			 						</div>
			 						<div id="similarRequestEmail">
			 							 <input type="text" id="similarRequestEmailField" name="similarRequestEmailField" placeholder="Inserisci un contatto e-mail valido..."/>
			 							 <input type="submit" id="sendEmailContact" value="Invia Contatto"/>
			 						</div>
			 					</div>
			 				</body>
						</html>
<?php 
					}
			}
		}
	}
?>