<?php
	class engine {
		private   $ip_ute;
		private   $browser_ute;
		private   $ora_accesso;
		private   $data_accesso;
		private   $pagina_ute;
		private   $db;
		
		private $id_user;
		private $nick_user;
		private $e_mail_user;
		private $phone_user;
		private $first_nam_user;
		private $last_nam_user;
		private $desc_user;
		private $cat_user;
		private $timestamp_reg_user;
		
		public function __construct($ip, $brs, $ora, $dat, $pag){
			$this->ip_ute = $ip;
			$this->browser_ute = $brs;
			$this->ora_accesso = $ora;
			$this->data_accesso = $dat;
			$this->pagina_ute = $pag;
		}	
		
		public function connessioneDB(){
			//$col = 'mysql:host=db627649300.db.1and1.com;dbname=db627649300';
			$col = 'mysql:host=localhost;dbname=prototype';
			try {
  				//$this->db = new PDO($col , 'dbo627649300', 'MisterRobot123!');
  				$this->db = new PDO($col , 'root', '');
				return true;
			}
			catch(PDOException $e) {
  				return false;
			}
		}
		
		private function checkEmail($email){
				// elimino spazi, "a capo" e altro alle estremità della stringa
				$email = trim($email);
				// se la stringa è vuota sicuramente non è una mail
				if(!$email) {
					return false;
				}
				// controllo che ci sia una sola @ nella stringa
				$num_at = count(explode( '@', $email )) - 1;
				if($num_at != 1) {
					return false;
				}
				// controllo la presenza di ulteriori caratteri "pericolosi":
				if(strpos($email,';') || strpos($email,',') || strpos($email,' ')) {
					return false;
				}
				// la stringa rispetta il formato classico di una mail?
				if(!preg_match( '/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}$/', $email)) {
					return false;
				}
				return true;
		}	
	
		public function cleanInput($input) {
  			$search = array(
    			'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  			);
   		$output = preg_replace($search, '', $input);
    		return $output;
  	   }
  	   
  	   public function random_string($length) {
			$string = "";
			for ($i = 0; $i <= ($length/32); $i++)
			$string .= md5(time()+rand(0,99));
			$max_start_index = (32*$i)-$length;
			$random_string = substr($string, rand(0, $max_start_index), $length);
			return $random_string.time();
		}
		
		public function insertOspite(){
			$sql = $this->db->prepare('INSERT INTO osp_accessi VALUES (:idSession,:ip,:brs,:data,:ora,:pgn,:time)');
			$time = time();
			$idSession = $this->random_string(30);
			$sql->bindParam(':idSession', $idSession);
			$sql->bindParam(':ip', $this->ip_ute);
			$sql->bindParam(':brs', $this->browser_ute);
			$sql->bindParam(':ora', $this->ora_accesso);
			$sql->bindParam(':data', $this->data_accesso);
			$sql->bindParam(':pgn', $this->pagina_ute);
			$sql->bindParam(':time', $time);
			if($sql->execute()){
				$_SESSION["id_session"] = $idSession;
				return true;
			}else{
				return false;
			}
		}
		
		public function login($cod, $type, $pass) {
			$cod = $this->cleanInput(strtolower($cod));
			$type = $this->cleanInput(strtolower($type));
			$pass = $this->cleanInput($pass);
			
			//---------------CONTROL IF IS BLOCKED 4 LOGIN FAILED-----------------------------------------------
				/*$sql = $this->db->prepare("Select * From tentativi_accessi WHERE ip_ute = :ip AND browser_ute =:brs");
				$sql->bindParam(':ip', $this->ip_osp);
				$sql->bindParam(':brs', $this->browser_osp);
				if($sql->execute()){
					$row = $sql->fetch(PDO::FETCH_ASSOC);
					$num_rows = $sql->rowCount();
					if($num_rows > 0){
						if($row["tentativi"] >= 3){
							$timeB = $row["timestamp"]+600;
  							if(time() > $timeB ){
								$sql = $this->db->prepare("DELETE From tentativi_accessi WHERE ip_ute =:ip AND browser_ute =:brs");
								$sql->bindParam(':ip', $this->ip_osp);
								$sql->bindParam(':brs', $this->browser_osp);
								$sql->execute();
							}else{
								die("Hai provato ad accedere per più di tre volte, riprova tra 1 minuto!");
							}
						}
					}
				}*/
			//-------------------------------------------------------------------------------------------------
				
			/*----------------------------------------------------------------------------------------------*/
			$sql = $this->db->prepare('SELECT * FROM users WHERE cat_user = :id AND nick_user = :cod' );
			/*----------------------------------------------------------------------------------------------*/
			
			if($type == "cardiochirurghi") {
				if (strlen($cod) > 100) {
					return ("Il codice inserito risulta essere troppo lungo!");
				}
				if (strlen($cod) <= 0) {
					return ("Inserisci il codice di identificazione!");
				}
				/*----------------------------------------------------------------------------------------------*/
					$id = "00001";
				/*----------------------------------------------------------------------------------------------*/
			}else{
				if($type == "medici"){
					if (strlen($cod) > 100) {
						return ("Il codice inserito risulta essere troppo lungo!");
					}
					if (strlen($cod) <= 0) {
						return ("Inserisci il codice di identificazione!");
					}
					/*----------------------------------------------------------------------------------------------*/
						$id = "00002";
					/*----------------------------------------------------------------------------------------------*/
				}else{
					if($type == "ospiti") {
						if (strlen($cod) > 100) {
							return ("Il nick-name inserito risulta essere troppo lungo!");
						}
						if (strlen($cod) <= 0) {
							return ("Inserisci il nick-name di identificazione!");
						}
						if (strlen($pass) > 25) {
							return ("La password inserita risulta essere troppo lungo!");
						}
						if (strlen($pass) <= 0) {
							return ("Inserisci il nick-name di identificazione!");
						}
						/*----------------------------------------------------------------------------------------------*/
							$sql = $this->db->prepare('SELECT * FROM users WHERE cat_user = :id AND nick_user = :cod AND pass_user = :pass' );
							$id = "00003";
						/*----------------------------------------------------------------------------------------------*/
					}else {
						/*-------NO CAT---------------------------------------------------------------------------------*/
							$id = "0000000000000000000000000000";
						/*----------------------------------------------------------------------------------------------*/
					}
				}
			}
			
			if($type == "medici" || $type == "cardiochirurghi" || $type == "ospiti" ) {
				$sql->bindParam(':id', $id);
				$sql->bindParam(':cod', $cod);
				if($type == "ospiti") {
					$sql->bindParam(':pass', $pass);
				}	
				if($sql->execute()){	
					$num_rows = $sql->rowCount();
					if($num_rows > 0){
						$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
						$_SESSION["logghed"] = true;
						foreach ($rows as $row){
							$nick_user = htmlentities($row["nick_user"]);
						}
						$_SESSION["nick_user"] = $nick_user;
							
						//---------SEND MAIL-----------------------------------------------------------
						//-----------------------------------------------------------------------------
						return "Login effettuato con successo!";
					}else {
						return "notfinded";
						//-----------INSERT +1 ATEMPT FAILED----------------------------------------
						//--------------------------------------------------------------------------
						//-----------IF ATEMPT > 4 (SO.. 5 in total!) BLOCK FOR 1 MINUTE------------
					}
				}else {
					return "notexecuted";
				}
			}else { 
				return "categorynotexists";
			}
				
		}	
	}		
?>