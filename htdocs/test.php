<?php
//phpinfo();

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
	