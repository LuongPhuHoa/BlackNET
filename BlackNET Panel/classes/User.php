<?php
class User extends Database{
    public function getUserData($username){
        $pdo = $this->Connect();
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $data = $stmt->fetch();
        return $data;
    }

    public function numUsers(){
        $pdo = $this->Connect();
        $sql = "SELECT COUNT(*) FROM admin";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchColumn();
        return $data;
    }

    public function checkUser($username){
    	$pdo = $this->Connect();
		$sql = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
		$sql -> execute([$username]);
		if ($sql->rowCount()) {
			return 'User Exist';
		} else {
			return 'Premission Denied';
		}
    }

    public function updateUser($id,$oldusername,$username,$email,$password,$auth,$question,$answer,$sqenable){
        $pdo = $this->Connect();
        $user = $this->getUserData($oldusername);

        if ($user->username != $username) {
        } else {
            $username = $user->username;
        }

        if ($password == "No change") {
            $password = $user->password;
        } else {
            $password = hash("sha256" , $this->salt.$password);
        }

        if ($user->email != $email) {
        } else {
            $email = $user->email;
        }

        if($auth == "") {
            $auth = "off";
        } else {
             $auth = "on";
        }

        if ($sqenable == "") {
            $sqenable = "off";
        } else {
            $sqenable = "on";
        }

        if ($user->question != $question) {
        } else {
            $question = $user->question;
        }

        if ($user->answer != $answer) {
        } else {
            $answer = $user->answer;
        }
        $sql = "UPDATE admin SET 
        username = :username,
        email = :email,
        password = :password,
        s2fa = :auth,
        sqenable = :sqenable,
        question = :question,
        answer = :answer
        WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username'=>$username,'email'=>$email,'password'=>$password,'auth'=>$auth,'sqenable'=>$sqenable,'question'=>$question,'answer'=>$answer,'id'=>$id]);
        return 'Username Updated';
    }

    public function getQuestionByUser($username){
        $pdo = $this->Connect();
        $sql = "SELECT question,answer,sqenable FROM admin WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $data = $stmt->fetch();
        return $data;
    }

    public function isQExist($username){
        try {
            $pdo = $this->Connect();
            $sql = "SELECT sqenable FROM admin WHERE username = :user";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user'=>$username]);
            $data = $stmt->fetch();
            if ($data->sqenable == "off"){
                return null;
            } else {
                return true;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

    }
}
?>