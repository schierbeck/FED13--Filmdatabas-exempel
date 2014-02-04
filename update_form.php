<?php session_start(); ?>
<?php require 'connect.php'; ?>
<?php require 'header.php'; ?>

<?php
$sql = "SELECT
m.id, m.title, m.description,
c.id, c.name
FROM movie AS m
JOIN category AS c
WHERE m.id = ?";

if( $stmt = $mysqli->prepare($sql) ):

	$stmt->bind_param('i', $_GET['movie_id']);
	$stmt->execute();
	$stmt->bind_result($m_id, $m_title, $m_description, $c_id, $c_name);
	$stmt->fetch();

?>
	<form action="update.php?movie_id=<?php echo $_GET['movie_id']; ?>" method="post">
		<input type="text" name="title" value="<?php echo $m_title; ?>">
		<select name="category">
			<option value="1">Ingen kategori</option>
			<?php while( $stmt->fetch() ): ?>
				<option value="<?php echo $c_id; ?>" <?php if($c_id == $_GET['cat_id']) { echo 'selected';} ?>><?php echo $c_name; ?></option>
			<?php endwhile; ?>
		</select><br>
		<textarea name="description"><?php echo $m_description; ?></textarea><br>
		<input type="submit" name="update" value="Uppdatera">
	</form>

<?php
	$stmt->close();

endif;

$mysqli->close();
?>

<?php require 'footer.php'; ?>