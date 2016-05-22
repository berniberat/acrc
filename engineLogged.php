<?php
	class engineLogged {
		
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
		
		public function setDataUser($id, $nick, $email, $phone, $fname, $lname, $desc, $cat, $time){
			$this->id_user = $id;
			$this->nick_user = $nick;
			$this->e_mail_user = $email;
			$this->phone_user = $phone;
			$this->first_nam_user = $fname;
			$this->last_nam_user = $lname;
			$this->desc_user = $desc;
			$this->cat_user = $cat;
			$this->timestamp_reg_user = $time;
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
}
?>