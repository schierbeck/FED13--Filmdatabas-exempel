<?php session_start(); ?>
<?php require 'connect.php'; ?>
<?php require 'header.php'; ?>

<?php

if( isset($_POST['add']) ) {

	$title = $_POST['title'];
	$description = $_POST['description'];
	$user_id = $_SESSION['user_id'];
	$category_id = $_POST['category'];

	$sql = "INSERT INTO movie (title, description, user_id, category_id) VALUES (?, ?, ?, ?)";

	if( $stmt = $mysqli->prepare($sql) ) {
		$stmt->bind_param('ssii', $title, $description, $user_id, $category_id);
		$stmt->execute();

		$stmt -> close();
		echo 'Film sparad.';
	}

}
$mysqli -> close();

require 'footer.php';
?>