<?php
$INCLUDE = __DIR__;
$ROOT = $INCLUDE.'/..';
$VENDOR = $ROOT.'/vendor';
$SITEstatus = 0;
$SITEmessage = array();
$SITEdebug = array();
$INCLUDEmessages['site'] = array();
require_once($INCLUDE.'/common.php');
//page info defaults
$pageinfo['title'] = "pagetitle";
$pageinfo['description'] = "pagedesc";
$pageinfo['type'] = "website";
$pageinfo['url'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$pageinfo['image'] = "favicon.png";

/*
 * step pre-init = 0 - 100 = ready
 * 0	pre-init, nothing
 * 5	site settings loading
 * 6	debug set
 * 7	tracy found
 * 8	tracy included
 * 9	tracy enabled
 * 10	site settings loaded
 */
//check if settings exists
if (file_exists($ROOT.'/config/settings.php'))
{
	$SITEstatus = 5; //site settings loading
	require_once ($ROOT.'/config/settings.php');
	if (isset($sitesettings['debug']))
	{
		$SITEstatus = 6; //debug mode set
	}
	$SITEstatus = 10; //site settings loaded
}
else
	$INCLUDEmessages['site'][] = 'missing settings.php';


if ($SITEstatus == 10)
	$SITEstatus = 100;
site_debug("SITEstatus:".$SITEstatus);

if ($SITEstatus >= 100)
{
	//setup page info defaults
	$pageinfo['title'] = $sitesettings['meta']['og:title'];
	$pageinfo['description'] = $sitesettings['meta']['og:description'];
	$pageinfo['type'] = $sitesettings['meta']['og:type'];
	$pageinfo['url'] = $sitesettings['meta']['og:url'];
	$pageinfo['image'] = $sitesettings['meta']['og:image'];
}
//----------database
//load database
if ($SITEstatus >= 10)
{
	# Type="POSTGRES"
	//KEEP SEPERATED
	try
	{
		$sitedbPDO = new PDO(	'pgsql:dbname='.$sitesettings['db_database'].
								';host='.$sitesettings['db_hostname'].
								';user='.$sitesettings['db_username'].
								';password='.$sitesettings['db_password']
								);
		$SITEstatus = 11;
		$sitedbPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$SITEstatus = 12;
		//$sitedbPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sitedbPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		//echo "PDO connection object created";
		$SITEstatus = 30;
	}
	catch (Exception $e)
	{
		error_log($e->getMessage());
		$INCLUDEmessages['site'][] = "DB_Error";
	}
}

switch ($sitesettings['debug'])
{
	case 2:
		site_verbose("verbose enabled");
	case 1:
		site_debug("debug enabled");
		break;
}
//=========================== END OF SETUP
//=========================== FUNCTION DEFINITION
/**
 * @brief Puts message into $SITEmessage
 * 
 * @param [in] string message
 */
 //think i dont want to use this
 /*
function site_message($msg)
{
	global $SITEmessage;
	$SITEmessage[] = $msg;
}*/

/**
 * @brief Puts message into $SITEdebug if debug mode
 * 
 * @param [in] string message
 * @param [in] boolean force regardless of settings
 */
function site_debug($msg, $forced = false)
{
	global $sitesettings, $SITEdebug;
	if (($sitesettings['debug'] >= 1) || $forced)
		$SITEdebug[] = $msg;
}

/**
 * @brief Puts message into $SITEdebug if verbose
 * 
 * @param [in] string message
 */
function site_verbose($msg)
{
	global $sitesettings, $SITEdebug;
	if ($sitesettings['debug'] >= 2)
		$SITEdebug[] = $msg;
}

function get_userinfo($user_id)
{
    global $sitedbPDO;
	site_verbose("(".__FUNCTION__.")");
	//============================
    //prepare first, prevents injection
	$stmt = $sitedbPDO->prepare("SELECT * FROM users WHERE user_id=:st_user_id;");
	$stmt->bindParam(':st_user_id',$user_id);
	if ($stmt->execute())
	{
		if ($stmt->rowCount() == 1)
		{
			$userArr = $stmt->fetch(PDO::FETCH_ASSOC);
			return $userArr;
		}
	}
	return false;
}

function get_all_priority()
{
	global $sitedbPDO;
	site_verbose("(".__FUNCTION__.")");
	//============================
	$stmt = $sitedbPDO->query("	SELECT *
                                FROM priority;",
                                PDO::FETCH_ASSOC);
	if ($stmt)
	{
		return $stmt->fetchall();
	}
	else
		return false;
}
function get_all_urgency()
{
	global $sitedbPDO;
	site_verbose("(".__FUNCTION__.")");
	//============================
	$stmt = $sitedbPDO->query("	SELECT *
                                FROM urgency;",
                                PDO::FETCH_ASSOC);
	if ($stmt)
	{
		return $stmt->fetchall();
	}
	else
		return false;
}
function get_all_impact()
{
	global $sitedbPDO;
	site_verbose("(".__FUNCTION__.")");
	//============================
	$stmt = $sitedbPDO->query("	SELECT *
                                FROM impact;",
                                PDO::FETCH_ASSOC);
	if ($stmt)
	{
		return $stmt->fetchall();
	}
	else
		return false;
}
function get_all_category()
{
	global $sitedbPDO;
	site_verbose("(".__FUNCTION__.")");
	//============================
	$stmt = $sitedbPDO->query("	SELECT *
                                FROM category;",
                                PDO::FETCH_ASSOC);
	if ($stmt)
	{
		return $stmt->fetchall();
	}
	else
		return false;
}
function get_all_status()
{
	global $sitedbPDO;
	site_verbose("(".__FUNCTION__.")");
	//============================
	$stmt = $sitedbPDO->query("	SELECT *
                                FROM status;",
                                PDO::FETCH_ASSOC);
	if ($stmt)
	{
		return $stmt->fetchall();
	}
	else
		return false;
}
function get_all_tier()
{
	global $sitedbPDO;
	site_verbose("(".__FUNCTION__.")");
	//============================
	$stmt = $sitedbPDO->query("	SELECT *
                                FROM tier;",
                                PDO::FETCH_ASSOC);
	if ($stmt)
	{
		return $stmt->fetchall();
	}
	else
		return false;
}
?>
