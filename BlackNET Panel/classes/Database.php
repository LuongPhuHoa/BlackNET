<?php
class Database{
	private $username = "root";
	private $password = "";
	private $host = "localhost";
	private $db_name = "blacknet";
	private $charset = "utf8mb4";
	public  $salt = "Yi89TTJ3bSxIcGxyVURhIzltXTdJcGtnJVdTdjNpU3BNSF9vU1BXe1N5JkoxP00pSC50MkY2TVdCdDZuNg==";
	public $admin_email = "admin@localhost";

	public function Connect(){

    try{
		$dsn = "mysql:host=".$this->host.";dbname=".$this->db_name.";charset=".$this->charset;
		$pdo = new PDO($dsn, $this->username, $this->password);	
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	}
	  catch(PDOException $err){
      	die('Unable to connect: '.$err->getMessage());
	}
	return $pdo;
	}

	public function dataExist(){
		$pdo = $this->Connect();
		$sql = $pdo->prepare("SHOW TABLES LIKE 'clients'");
		$sql -> execute();
		if ($sql->rowCount()) {
			
		} else {
			die("<h1 style='text-align:center; color:#c0392b; font-family:arial;'>Please Go To <a href='install.php' style='color:#CF000F;'>install.php</a></h1>
				<footer style='text-align:center; color:#c0392b; font-family:arial;'>Coded by: Black.Hacker</footer>");
		}
		
	}

	public function redirect($url){
		header('Location: ' . $url);
		exit;
	}
}
?>