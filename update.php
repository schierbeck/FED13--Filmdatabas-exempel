<?php session_start(); ?>
<?php require 'connect.php'; ?>
<?php require 'header.php'; ?>

<?php

if( isset($_POST['update']) ) {

	$title = $_POST['title'];
	$description = $_POST['description'];
	$category_id = $_POST['category'];
	$movie_id = $_GET['movie_id'];

	$sql = "UPDATE movie SET title = ?, description = ?, category_id = ? WHERE id = ?";

	if( $stmt = $mysqli->prepare($sql) ) {
		$stmt->bind_param('ssii', $title, $description, $category_id, $movie_id);
		$stmt->execute();

		$stmt -> close();
		echo 'Film uppdaterad.';
	}

}
$mysqli -> close();

require 'footer.php';
?>