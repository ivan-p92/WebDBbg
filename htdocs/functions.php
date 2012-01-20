<?php

class Functions
{
	private static $db = null;
	
	public static ingelogd()
	{
		if(isset($_SESSION['userid']) && ctype_digit((string)$_SESSION['userid']))
		{
			return true;
		}
		return false;
	}

	public static hashPass($pwd)
	{
		$SALT = 'D#%fFLKJ@#JO:%#  >?ASDA?:"@$%n asfd ;ae;é"FJ# #%b tq34"sa vf325yiougvrio*(&^$53vh(^)FDs';
		return strrev(sha1($SALT.$pwd));
	}
	
	public static getDB()
	{
		if(self::db === null)
		{
			self::db = new mysqli('websec.science.uva.nl', 'webdb1235', 'sadru2ew', 'webdb1235');
			if(self::db->connect_error)
			{
				self::db = null;
				header('Location: index.php');
			}
		}
		return self::db;
	}
}