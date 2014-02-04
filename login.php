<?php session_start(); ?>
<?
require 'connect.php';

if( !isset($_SESSION['username']) ) {

	if( isset($_POST['login']) ) {
		$username = $_POST['user'];
		$password = $_POST['pass'];
	}

	$sql = "SELECT id, username, fname, lname FROM user WHERE username = ? AND password = ?";

	if( $stmt = $mysqli->prepare($sql) ) {
		$user_id = 1;
		$stmt->bind_param('ss', $username, $password);
		$stmt->execute();
		$stmt->bind_result($id, $username, $fname, $lname);
		$stmt->fetch();

		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $id;

		header('Refresh: 3; url=index.php');
		echo 'Du har blivit inloggad och skickas strax till startsidan.';

		$stmt->close();
	}
	$mysqli->close();

} else {
	header('Refresh: 3; url=index.php');
	echo 'Du är redan inloggad och skickas strax till startsidan.';
}
?>