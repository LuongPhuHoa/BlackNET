<?php

class Auth extends User{

	function generateString($length,$pattern) {
	    $characters = $pattern;
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function updateCode($username,$code,$secret){
		$pdo = $this->Connect();
        $sql = "UPDATE auth SET code = :code, secret = :secret WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username'=>$username,'code'=>hash("sha256", $secret.$code),'secret'=>$secret]);
	}

	public function newCode($username,$code){
		try {
			$pdo = $this->Connect();
			$secret = $this->generateString(63,"0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
			if ($this->isExist($username) == true) {
				$this->updateCode($username,$code,$secret);
			} else {
				$pdo = $this->Connect();
				$sql = "INSERT INTO auth(username,code,secret) VALUES (:username,:code,:secret)";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(['username'=>$username,'code'=>hash("sha256", $secret.$code),'secret'=>$secret]);
				return 'Code Created';
			}
			if ($this->sendEmail($username,$code)) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			
		}
	}

	public function isExist($username){
		$pdo = $this->Connect();
		$sql = $pdo->prepare("SELECT * FROM auth WHERE username = ?");
		$sql -> execute([$username]);
		if ($sql->rowCount()) {
			return true;
		} else {
			return false;
		}
	}

	public function sendEmail($username,$code){
		$smtp = new Mailer;
        $pdo = $this->Connect();
        $data = $this->getUserData($username);
        $email = $data->email;
        if ($smtp->sendmail($email,"Your BlackNET verification code",
        	"<p>Welcome $username
        	 <br />
        	 Your verification code: $code
        	 <br />
        	 Here is your verification code.
        	 <br />
        	 It will expire in 10 minutes
        	 <br />
        	 If you didn't try to sign in just now, please change your password to protect your account.
        	 </p>")) {
        	return true;
        } else {
        	return false;
        }
	}

	public function getCode($username){
        $pdo = $this->Connect();
        $sql = "SELECT code,secret,created_at FROM auth WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $data = $stmt->fetch();
        return $data;
	}

	public function newLogin($username,$password){
     $logme = $this->check_credentials($username,$password);
     $row = $logme->fetch();
     $userCount = $logme->rowCount();
    if($userCount  == 1) {
      if($row->role == "administrator"){
      	return 200;
        } else {
          return 403;
        }
      } else {
          return 500;
      }
	}

    public function check_credentials($username,$password){
      $pdo = $this->Connect();
      $sql = "SELECT * FROM admin WHERE username = :username AND password = :password limit 1";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['username'=>$username,'password'=>hash("sha256",$this->salt.$password)]);
      return $stmt;
    }

  public function recaptchaResponse($privatekey,$recaptcha_response_field){
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$privatekey.'&response='.$recaptcha_response_field);
    $responseData = json_decode($verifyResponse);
    return $responseData;
  }

  public function isTwoFAEnabled($username){
      $pdo = $this->Connect();
      $sql = "SELECT s2fa FROM admin WHERE username = :username limit 1";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['username'=>$username]);
      $data = $stmt->fetch();
      return $data->s2fa;
  }
}

?>