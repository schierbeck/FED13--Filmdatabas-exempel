<?php session_start();
session_destroy();
header('Refresh: 3; url=index.php');
echo 'Du har blivit utloggad och skickas strax till startsidan.';
?>