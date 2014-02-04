<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Filmer</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
	<nav>
		<ul>
			<li><a href="index.php">Start</a></li>
			<?php if( isset($_SESSION['username']) ): ?>
				<li><a href="add_form.php">Lägg till film</a></li>
				<li><a href="logout.php">Logga ut</a></li>
			<?php endif; ?>
		</ul>
	</nav>
</header>