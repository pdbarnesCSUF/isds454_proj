<?php
/*
 * @file ajax_get_formfields.php
 * @desc get all data needed to fill out forms (dropdowns)
 */
 
$responsearr['action'] = 00; //unknown error
$responsearr['data'] = false;
$responsearr['message'] = array();
$responsearr['debug'] = array();
header('Content-Type: application/json');

if (include_once('../include/include.php'))
{
	site_verbose('PAGE:ajax/ajax_get_formfields.php');
	//site_init();
	//do something
    $responsearr['data']['priority'] = get_all_priority();
    $responsearr['data']['urgency'] = get_all_urgency();
    $responsearr['data']['impact'] = get_all_impact();
    $responsearr['data']['category'] = get_all_category();
    $responsearr['data']['status'] = get_all_status();
    $responsearr['data']['tier'] = get_all_tier();
	
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
