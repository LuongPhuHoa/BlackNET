<?php
include 'classes/User.php';

$user = new User;
$user_check = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : null;
$password_check = isset($_SESSION['login_password']) ? $_SESSION['login_password'] : null;

if(isset($_SESSION['login_user']) && $user_check != null){
    $data = $user->getUserData($user_check);    
}

if(empty($_SESSION['key'])){
  $_SESSION['key'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['current_ip'])) {
  $_SESSION['current_ip'] = $_SERVER["REMOTE_ADDR"];
}
    
if (!isset($csrf)) {
  $csrf = hash_hmac('sha256', 'Jyp9OENwQGVGM1NgUzoyTzBCLHs', $_SESSION['key'].session_id().$_SESSION["current_ip"]);
}

if(!isset($_SESSION['login_user']) || !isset($_SESSION['login_password']) || !isset($_SESSION["current_ip"]) || !isset($_SESSION['key'])){
  $user->redirect("login.php");
}

$expireAfter = 60;
if(isset($_SESSION['last_action'])){
  $secondsInactive = time() - $_SESSION['last_action'];
  $expireAfterSeconds = $expireAfter * 60;

  if($secondsInactive >= $expireAfterSeconds){
    session_unset();
    session_destroy();
    $user->redirect("login.php");
  }
}

$database = new Database;
$database->dataExist();
?>