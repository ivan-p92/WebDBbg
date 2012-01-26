<?php
session_start();
//na uitloggen wordt de session geleegd 
//deze eerste comments staan op een rare plek, want voor session start mogen er geen comments van Freek
//webdb1235, goodbye.php

//leeg array
$_SESSION = array();
unset($_SESSION);

//door naar de homepage
header("Location: index.php");
?>