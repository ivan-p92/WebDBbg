<?php
// bestand met bonte verzameling functies die veel gebruikt worden

// functie om veilig iets op het scherm te kunnen tonen
function out($string)
{
	return htmlentities($string, ENT_QUOTES, "UTF-8");
}

class Functions
{
	private static $db = null; // de database connectie

	// geeft true terug als gebruiker is ingelogd (session bestaat
	// en bevat een integer) anders false
	public static function ingelogd()
	{
		if(isset($_SESSION['userid']) && ctype_digit((string)$_SESSION['userid']))
		{
			return true;
		}
		return false;
	}
	
	// verhaspel het wachtwoord
	public static function hashPass($pwd)
	{
		// we gebruiker een salt om de wachtwoorden veiliger op te kunnen slaan
		$SALT = 'D#%fFLKJ@#JO:%#  >?ASDA?:"@$%n asfd ;ae;é"FJ# #%b tq34"sa vf325yiougvrio*(&^$53vh(^)FDs';
		return strrev(sha1($SALT.$pwd)); // bovendien zetten we de sha1 string in omgekeerde volgorde in de database
	}
	
	// functie die een databaseconnectie teruggeeft
	// Er zit een check in die er voor zorgt dat er maar 1 connectie 
	// kan bestaan
	public static function getDB()
	{
		if(self::$db === null) // er is nog geen verbinding in dit object?
		{	// nee dus maak een verbinding
			
			$dsn = 'mysql:dbname=webdb1235;host=localhost';
			$user = 'webdb1235';
			$password = 'sadru2ew';

			try
			{
				// stel ook gelijk wat standaardinstellingen in
				// bewaar deze verbinding in het object
				self::$db = new PDO($dsn, $user, $password);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$db->query("SET NAMES 'utf8';");
				self::$db->query("SET lc_time_names = 'nl_NL';");
				
			}
			catch (PDOException $e)
			{
				// zonder database kunnen we niets meer
				die('FATAL ERROR');
			}
		}
		// er bestaat al een verbinding
		// geef deze dan terug
		return self::$db;
	}
	
	// een functie die kijkt of een recht en een gebruiker wel bij elkaar horen
	// indien geen tweede parameter (userid) wordt meegegeven, dan wordt
	// het userid van de ingelogde gebruiker gebruikt.
	public static function auth($action, $userid = null)
	{
		if($userid == null)	// geen useride meegegeven
		{
			if(!self::ingelogd())	// is er iemand ingelogd?
			{	// nee, return false want nu kunnen we niets meer
				// omdat we niet weten voor welke gebruiker we moeten checken
				return false;
			}
			// er is wel iemand ingelogd, gebruik dit userid
			$userid = $_SESSION['userid'];
		}
		
		try
		{
			// vraag om connectie
			$db = self::getDB();
			
			// voer een query uit die checked of
			// er een record bestaat dat een gebruiker
			// en een recht koppelt.
			$sql = "SELECT
						count(*) AS	aantal
					FROM
						users_permissions
					JOIN
						permissions
					ON
						permission_id = permissions.id
					WHERE
						user_id = :id
					AND
						permissions.permission = :action;";
						
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id', $userid, PDO::PARAM_INT);
			$stmt->bindParam(':action', $action, PDO::PARAM_STR);
			$stmt->execute();
			
			$row = $stmt->fetch();
			if($row['aantal'] == 1) // er is 1 rij gevonden, dus dan heeft de user de rechten
			{
				return true;
			}
			else // niet gevonden, geen rechten
			{
				return false;
			}
		}
		catch(Exception $e)
		{
			// er is iets misgegaan, we kunnen nu niet zeker weten of een user de juiste rechten heeft
			// dus we geven false terug
			return false;
		}
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
	
	//kijkt of er een geldige datum is ingevuld
	public static function validateDate($date, $maand, $jaar)
	{
		if($dag>31)
		{
			return FALSE;
		}	
		elseif($maand=="februari" && date==29 && (($jaar%4)!=0 || ($jaar%100)==0))
		{
			return FALSE;
		}
		elseif($maand=="februari" && date>29)
		{
			return FALSE;
		}
		elseif(($maand=="april" || $maand=="juni" || $maand=="oktober" || $maand=="november") && $dag>=31)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}	
	}
	
	//kijkt of einddatum, na begintijd is
	public static function validatStartEnd($startDate, $endDate)
	{
	}
}// end Functions