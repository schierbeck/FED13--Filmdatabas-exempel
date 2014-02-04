<?php session_start(); ?>
<?php require 'connect.php'; ?>
<?php require 'header.php'; ?>

<?php

$movie_id = $_GET['movie_id'];

$sql = "DELETE FROM movie WHERE id = ?";

if( $stmt = $mysqli->prepare($sql) ) {
	$stmt->bind_param('i', $movie_id);
	$stmt->execute();

	$stmt -> close();
	echo 'Film raderad.';
}
$mysqli -> close();

require 'footer.php';
?>