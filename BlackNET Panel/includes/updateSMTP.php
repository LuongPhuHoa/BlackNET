<?php 
require '../classes/Database.php';
require '../classes/Mailer.php';
include '../session.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$smtp = new Mailer;
	if ($csrf != $_POST['csrf']) {
		$smtp->redirect("../settings.php?msg=csrf");
	} else {
	  $status = isset($_POST['smtp-state']) ? $_POST['smtp-state'] : '';
	  $msg = $smtp->setSMTP($_POST['id'],$_POST['SMTPHost'],$_POST['SMTPUser'],$_POST['SMTPPassword'],$_POST['SMTPPort'],$_POST['security'],$status);
	  $smtp->redirect("../settings.php?msg=yes");
	}
}
?>
