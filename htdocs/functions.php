<?php

function ingelogd()
{
	if(isset($_SESSION['userid']) && ctype_digit((string)$_SESSION['userid']))
	{
		return true;
	}
	return false;
}