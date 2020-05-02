<?php
/*
 * @file ajax_agent_listusers.php
 * @desc list all users for agents
 */
 
$responsearr['action'] = 00; //unknown error
$responsearr['data'] = false;
$responsearr['message'] = array();
$responsearr['debug'] = array();
header('Content-Type: application/json');

if (include_once('../include/include.php'))
{
	site_verbose('PAGE:ajax/ajax_agent_listusers.php');
	//site_init();
	//do something
	$stmt = $sitedbPDO->query("	SELECT  *
                                FROM    users
                                ;",
                                PDO::FETCH_ASSOC);
    if ($stmt)
	{
        $responsearr['data']['user'] = $stmt->fetchall();
        $responsearr['data']['count'] = $stmt->rowCount();
        $responsearr['action'] = 1; //ok
	}
	else
    {
        $responsearr['data']['count'] = 0;
        $responsearr['action'] = 0; //error
    }
	//-----end-----
	$responsearr['message'] = $SITEmessage;
	$responsearr['debug'] = $SITEdebug;
}
else
{
	$responsearr['action'] = 02; //include error
	$responsearr['message'][] = "Server Error";
	$responsearr['debug'][] = "Include error";
}

echo json_encode($responsearr);
?>
