<?php
/*
 * @file ajax_get_ticketinfo.php
 * @desc list all info for a ticket
 */
 
$responsearr['action'] = 00; //unknown error
$responsearr['data'] = false;
$responsearr['message'] = array();
$responsearr['debug'] = array();
header('Content-Type: application/json');

if (include_once('../include/include.php'))
{
	site_verbose('PAGE:ajax/ajax_get_ticketinfo.php');
	//site_init();
	//do something
    if(isset($_GET['ticket_id']))
    {
        site_verbose('ticketid:'.$_GET['ticket_id']);
        $stmt = $sitedbPDO->prepare("   SELECT  ticket_id,
                                                ticket_date,
                                                ticket_title,
                                                ticket.user_id,
                                                user_firstname,
                                                user_lastname,
                                                user_email,
                                                user_department,
                                                ticket.status_id,
                                                status_name,
                                                ticket.category_id,
                                                category_name,
                                                ticket.tier_id,
                                                tier_name,
                                                ticket.priority_id,
                                                priority_name,
                                                ticket.urgency_id,
                                                urgency_name,
                                                ticket.impact_id,
                                                impact_name,
                                                ticket.agent_id,
                                                agent_firstname,
                                                agent_lastname,
                                                ticket_attachment,
                                                ticket_comment
                                        FROM    ticket
                                        LEFT OUTER JOIN    category ON ticket.category_id = category.category_id
                                        LEFT OUTER JOIN    status ON ticket.status_id = status.status_id
                                        LEFT OUTER JOIN    tier ON ticket.tier_id = tier.tier_id
                                        LEFT OUTER JOIN    priority ON ticket.priority_id = priority.priority_id
                                        LEFT OUTER JOIN    urgency ON ticket.urgency_id = urgency.urgency_id
                                        LEFT OUTER JOIN    impact ON ticket.impact_id = impact.impact_id
                                        LEFT OUTER JOIN    support_agent ON ticket.agent_id = support_agent.agent_id
                                        LEFT OUTER JOIN    users ON ticket.user_id = users.user_id
                                        WHERE ticket_id=:st_ticket_id
                                        ;");
        $stmt->bindParam(':st_ticket_id',$_GET['ticket_id']);
        if ($stmt->execute())
        {
            site_verbose("executed successfully");
            if ($stmt->rowCount() == 1)
            {
                site_verbose("rowCount 1");
                $responsearr['action'] = 1; //no error
                $responsearr['data'] = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                $responsearr['action'] = 0; //error
                site_debug("no rows");
            }
        }
        else
        {
            $responsearr['data']['count'] = 0;
            $responsearr['action'] = 0; //error
        }
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
