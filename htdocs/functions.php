<?php

function out($string)
{
	return htmlentities($string, ENT_QUOTES, "UTF-8");
}

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
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$db->query("SET NAMES 'utf8';");
				
			}
			catch (PDOException $e)
			{
				header('Location: index.php?notice=fatal_error');
			}
		}
		return self::$db;
	}
	
	public static function auth($action, $userid = null)
	{
		if($userid == null)
		{
			if(!self::ingelogd())
			{
				return false;
			}
			$userid = $_SESSION['userid'];
		}
		
		try
		{
			$db = self::getDB();
			
			$sql = "SELECT count(*) AS aantal FROM users_permissions JOIN permissions ON permission_id = permissions.id WHERE user_id = :id AND permissions.permission = :action;";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $userid, PDO::PARAM_INT);
			$stmt->bindParam(':action', $action, PDO::PARAM_STR);
			$stmt->execute();
			
			$row = $stmt->fetch();
			if($row['aantal'] == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	public static function info_evenement($id)
	{
		$database = self::getDB();
	
		$sql = 'SELECT events.*, users.name FROM events INNER JOIN users ON users.id=events.create_id WHERE events.id=:id';
		$sql_klant = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=1';
		$sql_keuken = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=2';
		$sql_afwas = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=3';	
		$sql_bar = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=4';
			
		// dit bereidt de queries voor
		$stmt = $database->prepare($sql);
		$stmt_klant = $database->prepare($sql_klant);
		$stmt_keuken = $database->prepare($sql_keuken);
		$stmt_afwas = $database->prepare($sql_afwas);
		$stmt_bar = $database->prepare($sql_bar);
		
		// nu wordt id overal gebind
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt_klant->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt_keuken->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt_afwas->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt_bar->bindParam(":id", $id, PDO::PARAM_INT);
		
		// de queries worden uitgevoerd
		$stmt->execute();
		$stmt_klant->execute();
		$stmt_keuken->execute();
		$stmt_afwas->execute();
		$stmt_bar->execute();
		
		// info wordt in info gestopt
		$info=$stmt->fetch();
		
		// bij de anderen moet alleen de rijen geteld worden
		$klant = $stmt_klant->rowCount();
		$keuken = $stmt_keuken->rowCount();
		$afwas = $stmt_afwas->rowCount();
		$bar = $stmt_bar->rowCount();
	}
	
	//valideert of een String (input) geldig is ingevuld
	public static function validateString($string, $type, $length)
	{
		$type='is_'.$type;
		
		if(!$type($string))
		{
			return FALSE;
		}
		elseif(empty($string))
		{
			return FALSE;
		}
		elseif(strlen($string)>$length)
		{
			return	FALSE;
		}
		else
		{
			return TRUE;
		}	
	}
	
	//valideert of minstens één checkbox is ingevuld
	public static function validateCheckbox($array)
	{
		$length = count($array);
		
		if($length<1)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	//valideert of twee wachtwoorden hetzelfde zijn
	public static function validatePwd($ww1, $ww2)
	{
		if($ww1 != $ww2)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}