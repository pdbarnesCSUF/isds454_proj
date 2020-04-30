<?php
/*
 * @file ajax_agent_listtickets.php
 * @desc list all tickets for agents
 */
 
$responsearr['action'] = 00; //unknown error
$responsearr['data'] = false;
$responsearr['message'] = array();
$responsearr['debug'] = array();
header('Content-Type: application/json');

if (include_once('../include/include.php'))
{
	site_verbose('PAGE:ajax/ajax_agent_listtickets.php');
	//site_init();
	//do something
	$stmt = $sitedbPDO->query("	SELECT  ticket_id,
                                        to_char(ticket_date, 'YYYY-MM-DD HH:mm') AS ticket_date,
                                        category_name,
                                        status_name,
                                        ticket_title,
                                        user_lastname,
                                        tier_value,
                                        priority_value,
                                        urgency_value,
                                        impact_value,
                                        ticket.agent_id
                                FROM    ticket
                                LEFT OUTER JOIN    category ON ticket.category_id = category.category_id
                                LEFT OUTER JOIN    status ON ticket.status_id = status.status_id
                                LEFT OUTER JOIN    tier ON ticket.tier_id = tier.tier_id
                                LEFT OUTER JOIN    priority ON ticket.priority_id = priority.priority_id
                                LEFT OUTER JOIN    urgency ON ticket.urgency_id = urgency.urgency_id
                                LEFT OUTER JOIN    impact ON ticket.impact_id = impact.impact_id
                                LEFT OUTER JOIN    support_agent ON ticket.agent_id = support_agent.agent_id
                                LEFT OUTER JOIN    users ON ticket.user_id = users.user_id
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
