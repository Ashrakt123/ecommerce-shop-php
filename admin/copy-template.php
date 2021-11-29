<?php
	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = '';

	if (isset($_SESSION['Username'])) {

		include 'ini.php';

		$action = isset($_GET['action']) ? $_GET['action'] : 'manage';

		if ($action == 'manage') {
 echo "welcome items";

		} elseif ($action == 'add') {


		} elseif ($action == 'insert') {


		} elseif ($action == 'edit') {


		} elseif ($action == 'update') {


		} elseif ($action == 'delete') {


		} elseif ($action == 'approve') {


		}

        include $tmp.'footer.php'; 

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>