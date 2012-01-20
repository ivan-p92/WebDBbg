<?php
//phpinfo();
/*
mysql_connect('localhost', 'webdb1235', 'sadru2ew');
mysql_select_db('webdb1235');

$res = mysql_query("SELECT NOW()");
if(!$res)
{
	echo'foutmelding';
}
else
{
	$la = mysql_fetch_assoc($res);
	var_dump($la);
}
	
	

$db = new mysqli('localhost', 'webdb1235', 'sadru2ew', 'webdb1235');
$res = $db->query("SELECT NOW();");
var_dump($res);*/

$dsn = 'mysql:dbname=webdb1235;host=localhost';
$user = 'webdb1235';
$password = 'sadru2ew';

try
{
	$db = new PDO($dsn, $user, $password);
}
catch (PDOException $e)
{
	echo 'Connection failed: ' . $e->getMessage();
}

$res = $db->query("SELECT NOW();")->fetchAll();
var_dump($res);