<?php 
include 'classes/Database.php';
include 'classes/User.php';
include 'classes/Mailer.php';
include 'classes/ResetPassword.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username =isset($_POST['username']) ? $_POST['username']: '';
    $resetPassword = new ResetPassword;
    if($resetPassword->sendEmail($username)){
      $msg = "Instructions has been send to your email";
    } else {
      $err = "Username does not exist!";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BlackNET - Forgot Password</title>

  <!-- Custom fonts for this template-->
  <link href="asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="asset/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
          <?php if(isset($msg)): ?>
            <div class="alert alert-primary" role="alert"><i class="fa fa-info-circle"></i> <?php echo $msg ?></div>
          <?php endif; ?>
          <?php if(isset($err)): ?>
            <div class="alert alert-danger" role="alert"><i class="fa fa-times-circle"></i> <?php echo $err ?></div>
          <?php endif; ?>
        <div class="text-center mb-4">
          <h4>Forgot your password?</h4>
          <p>Enter your username and we will send you instructions on how to reset your password.</p>
        </div>
        <form method="POST">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required="required" autofocus="autofocus">
              <label for="username">Enter Username</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="asset/vendor/jquery/jquery.min.js"></script>
  <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="asset/vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
