<?php
/*
 * @file ajax_get_userinfo.php
 * @desc get all logged in user info
 */

$responsearr['action'] = 00; //unknown error
$responsearr['data'] = false;
$responsearr['message'] = array();
$responsearr['debug'] = array();
header('Content-Type: application/json');

if (include_once('../include/include.php'))
{
	site_verbose('PAGE:ajax/ajax_get_userinfo.php');
	//site_init();
	//do something
    if(isset($_GET['user_id']))
    {
        $responsearr['data'] = get_userinfo($_GET['user_id']);
        if ($responsearr['data'])
            $responsearr['action'] = 01; //no error
        else
            $responsearr['action'] = 00; //error
	}
    else
    {
        $responsearr['action'] = 07; // bad/no input
        $responsearr['data'] = false;
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
