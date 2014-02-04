<meta charset="utf-8">

<?php
if( !isset($_SESSION['username']) ) { ?>

	<form action="login.php" method="post">

		<input type="text" name="user" placeholder="Username">
		<input type="password" name="pass" placeholder="Password">
		<input type="submit" name="login" value="Logga in">

	</form>

<?php
	exit();
}

require 'footer.php';
?>