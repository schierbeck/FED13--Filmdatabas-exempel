<?php session_start(); ?>
<?php require 'connect.php'; ?>
<?php require 'header.php'; ?>
<?php require 'login_form.php'; ?>

<?php

// Plockar ut från tabellerna user, movie, category och actor
// AS står för alias och gör att vi inom queryn kan döpa om tabellen för att skriva mindre kod.
// Nedan så döper jag exempelvis om user till u. Därför kan jag kalla på kolumnen user.id genom att skriva u.id.
$sql = "SELECT
u.id, u.fname, u.lname,
m.id, m.title, m.description,
c.id, c.name,
a.fname, a.lname
FROM user AS u
LEFT JOIN movie AS m ON u.id = m.user_id
LEFT JOIN category AS c ON c.id = m.category_id
LEFT JOIN actor AS a ON m.id = a.movie_id
WHERE u.id = ?
ORDER BY m.title
";

// Förbereder queryn samtidigt som vi tilldeler funktionen till variabeln $stmt
// Som om det inte vore nog så iffar vi det för att kolla om så att det funkar. 3 in 1. Sweet.
if( $stmt = $mysqli->prepare($sql) ) {
	// $_SESSION['user_id'] har vi med sedan vi loggade in (glöm inte session_start() i början av dokumentet!)
	// Här sparar vi ner den i variabeln $user_id
	$user_id = $_SESSION['user_id'];
	// Vi binder $user_id till frågetecknet i queryn. 'i' då det i detta fall är en INT
	$stmt->bind_param('i', $user_id);
	// Vi verkställer (exekverar) queryn
	$stmt->execute();
	// Vi hämtar information från de valda kolumnerna från queryn.
	// Märk väl att antalet kolumner mellan SELECT och FROM överensstämmer med antalet variabler vi binder.
	$stmt->bind_result($u_id, $u_fname, $u_lname, $m_id, $m_title, $m_description, $c_id, $c_name, $a_fname, $a_lname);

	// Så länge $stmt->fetch körs, dvs så många rader som queryn hämtar ut
	while( $stmt->fetch() ) {
		// Vi sparar ner allt vi hämtar i en array.
		// Anledningen är att vi sedan kan välja vad av arrayen vi vill loopa ut, och när vi vill loppa ut detta.
		// $m_id är filmens id och blir den första underarrayen i arrayen movies. Under denna följer flera andra
		// arrayer. Kör man print_r($movies); så kommer man se att strukturen blir följande:
		/*Array
			(
			    [11] => Array
			        (
			            [id] => 11
			            [title] => North by Nortwest
			            [description] => A hapless New York advertising executive is mistaken for a government agent by a group of foreign spies, and is pursued across the country while he looks for a way to survive.
			            [category] => Trhiller
			            [cat_id] => 2
			            [actors] => Array
	                		(
	                    		[Cary Grant] => Cary Grant
	                    		[Eva Marie Saint] => Eva Marie Saint
	                		)
			        )
			    [4] => Array
			    	(
			    		// osv...
			    	)*/

		$movies[$m_id]['id'] = $m_id;
		$movies[$m_id]['title'] = $m_title;
		$movies[$m_id]['description'] = $m_description;
		$movies[$m_id]['category'] = $c_name;
		$movies[$m_id]['cat_id'] = $c_id;
		$movies[$m_id]['actors'][$a_fname . ' ' . $a_lname] = $a_fname . ' ' . $a_lname;
	}
	?>

	<!-- Exempel: Johans filmer -->
	<h1> <?php echo $u_fname; ?>s filmer</h1>

	<!-- LOOPAR UT ALLA FILMER SOM QUERYN HÄMTAR -->
	<?php foreach( $movies as $movie ):
		// Här sparar vi ner allt från arrayen som kommer loopas ut inom denna loop.
		// Anledningen är bara att det ska vara lättare att läsa koden.
		$id = $movie['id'];
		$title = $movie['title'];
		$description = $movie['description'];
		$category = $movie['category'];
		$cat_id = $movie['cat_id'];
		$actors = $movie['actors'];
	?>
		<hr>
		<h2><?php echo $title; ?></h2>
		<small><?php echo $category; ?></small>
		<p><?php echo $description; ?></p>

		<h3>Skådespelare</h3>

		<!-- LOOPAR UT ALLA SKÅDESPELARE TILLHÖRANDE FILMEN SOM LOOPAS -->
		<?php foreach( $actors as $actor ): ?>

			<?php if( strlen($actor) < 2 ): ?>
				Inga skådespelare inlagda.
			<?php endif; ?>

			<?php echo $actor; ?><br>

		<?php endforeach; ?>

		<br>
		<!-- Lägg märke till att jag skickar med en variabel i länkadressen. Detta för att sidan länken leder till ska kunna fånga upp värdet med $_GET['movie_id']; -->
		<a href="update_form.php?movie_id=<?php echo $id; ?>&cat_id=<?php echo $cat_id; ?>">Uppdatera info</a><br>
		<a href="delete.php?movie_id=<?php echo $id; ?>">Radera</a>

	<?php endforeach; ?>

	<?php
	$stmt -> close();
}
$mysqli -> close();

require 'footer.php';
?>