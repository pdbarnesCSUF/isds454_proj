<?php
/*
 * @file ajax_user_listtickets.php
 * @desc list all tickets for user
 */
 
$responsearr['action'] = 00; //unknown error
$responsearr['data'] = false;
$responsearr['message'] = array();
$responsearr['debug'] = array();
header('Content-Type: application/json');

if (include_once('../include/include.php'))
{
	site_verbose('PAGE:ajax/ajax_user_listtickets.php');
	//site_init();
	//do something
    
    //when sign in implemented, only get tickets that user submitted
    //for now its just user 1
	$stmt = $sitedbPDO->query("	SELECT  ticket_id,
                                        ticket_date,
                                        category_name,
                                        status_name,
                                        ticket_title
                                FROM    ticket
                                LEFT OUTER JOIN    category ON ticket.category_id = category.category_id
                                LEFT OUTER JOIN    status ON ticket.status_id = status.status_id
                                WHERE   user_id = 1
                                ;",
                                PDO::FETCH_ASSOC);
    if ($stmt)
	{
        $responsearr['data']['ticket'] = $stmt->fetchall();
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
