<?php
session_start();
$_SESSION = array(); //leeg array
unset($_SESSION);
header("Location: index.php");