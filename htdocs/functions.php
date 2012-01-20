<?php

class Functions
{
	private static $db = null;
	
	public static function ingelogd()
	{
		if(isset($_SESSION['userid']) && ctype_digit((string)$_SESSION['userid']))
		{
			return true;
		}
		return false;
	}

	public static function hashPass($pwd)
	{
		$SALT = 'D#%fFLKJ@#JO:%#  >?ASDA?:"@$%n asfd ;ae;é"FJ# #%b tq34"sa vf325yiougvrio*(&^$53vh(^)FDs';
		return strrev(sha1($SALT.$pwd));
	}
	
	public static function getDB()
	{
		if(self::$db === null)
		{
			$dsn = 'mysql:dbname=webdb1235;host=localhost';
			$user = 'webdb1235';
			$password = 'sadru2ew';

			try
			{
				self::$db = new PDO($dsn, $user, $password);
				self::$db->query("SET NAMES 'utf8';");
			}
			catch (PDOException $e)
			{
				header('Location: index.php?notice=fatal_error');
			}
		}
		return self::$db;
	}
}