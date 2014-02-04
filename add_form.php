<?php session_start(); ?>
<?php require 'connect.php'; ?>
<?php require 'header.php'; ?>

<?php
$sql = "SELECT * FROM category";

if( $stmt = $mysqli->prepare($sql) ):
	$stmt->execute();
	$stmt -> bind_result($c_id, $c_name);
?>
	<form action="add.php" method="post">
		<input type="text" name="title" placeholder="Titel">
		<select name="category">
			<?php while( $stmt->fetch() ): ?>
				<option value="<?php echo $c_id; ?>"><?php echo $c_name; ?></option>
			<?php endwhile; ?>
		</select><br>
		<textarea name="description" placeholder="Beskrivning"></textarea><br>
		<input type="submit" name="add" value="Spara">
	</form>

<?php
	$stmt->close();

endif;

$mysqli->close();
?>

<?php require 'footer.php'; ?>