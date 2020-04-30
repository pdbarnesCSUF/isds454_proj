<?php
/*
 * @file ajax_agent_submit.php
 * @desc agent edits ticket
 */
 
$responsearr['action'] = 00; //unknown error
$responsearr['data'] = array(
	'title' => array(
		'valid' => false,
		'reason' => ''
	),
	'category' => array(
		'valid' => false,
		'reason' => ''
	),
    'user' => array(
		'valid' => false,
		'reason' => ''
	),
    'status' => array(
		'valid' => false,
		'reason' => ''
	),
    'tier' => array(
		'valid' => false,
		'reason' => ''
	),
    'priority' => array(
		'valid' => false,
		'reason' => ''
	),
    'urgency' => array(
		'valid' => false,
		'reason' => ''
	),
    'impact' => array(
		'valid' => false,
		'reason' => ''
	),
    'agent' => array(
		'valid' => false,
		'reason' => ''
	),
    //not checking for now
    /*
	'attachment' => array(
		'valid' => false,
		'reason' => ''
	),*/
	'comment' => array(
		'valid' => false,
		'reason' => ''
	)
);
$responsearr['message'] = array();
$responsearr['debug'] = array();
header('Content-Type: application/json');

if (include_once('../include/include.php'))
{
	site_verbose('PAGE:ajax/ajax_agent_submit.php');
	//site_init();
	//do something
    $responsearr['action'] = 1; //no problem start, set 7 if bad input
	//=====quick validation===== TODO full validation later
    //-----user-----
    //check logged in
    $agent_id = 1; //bypass for testing
    //-----ticket_id-----
    if (isset($_POST['ticket_id']))
    {
        //stricter validation here
        $responsearr['data']['ticket_id']['valid'] = true;
    }
    else
    {
        $responsearr['data']['ticket_id']['valid'] = false;
        $responsearr['data']['ticket_id']['reason'] = 'Ticket ID Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----title-----
    if (isset($_POST['title']))
    {
        //stricter validation here
        $responsearr['data']['title']['valid'] = true;
    }
    else
    {
        $responsearr['data']['title']['valid'] = false;
        $responsearr['data']['title']['reason'] = 'Title Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----Category-----
    if (isset($_POST['category']))
    {
        //stricter validation here
        $responsearr['data']['category']['valid'] = true;
    }
    else
    {
        $responsearr['data']['category']['valid'] = false;
        $responsearr['data']['category']['reason'] = 'Category Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----User-----
    if (isset($_POST['user']))
    {
        //stricter validation here
        $responsearr['data']['user']['valid'] = true;
    }
    else
    {
        $responsearr['data']['user']['valid'] = false;
        $responsearr['data']['user']['reason'] = 'User Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----Status-----
    if (isset($_POST['status']))
    {
        //stricter validation here
        $responsearr['data']['status']['valid'] = true;
    }
    else
    {
        $responsearr['data']['status']['valid'] = false;
        $responsearr['data']['status']['reason'] = 'Status Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----Tier-----
    if (isset($_POST['tier']))
    {
        //stricter validation here
        $responsearr['data']['tier']['valid'] = true;
    }
    else
    {
        $responsearr['data']['tier']['valid'] = false;
        $responsearr['data']['tier']['reason'] = 'Tier Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----Priority-----
    if (isset($_POST['priority']))
    {
        //stricter validation here
        $responsearr['data']['priority']['valid'] = true;
    }
    else
    {
        $responsearr['data']['priority']['valid'] = false;
        $responsearr['data']['priority']['reason'] = 'Priority Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----Urgency-----
    if (isset($_POST['urgency']))
    {
        //stricter validation here
        $responsearr['data']['urgency']['valid'] = true;
    }
    else
    {
        $responsearr['data']['urgency']['valid'] = false;
        $responsearr['data']['urgency']['reason'] = 'Urgency Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----Impact-----
    if (isset($_POST['impact']))
    {
        //stricter validation here
        $responsearr['data']['impact']['valid'] = true;
    }
    else
    {
        $responsearr['data']['impact']['valid'] = false;
        $responsearr['data']['impact']['reason'] = 'Impact Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----Agent-----
    if (isset($_POST['agent']))
    {
        //stricter validation here
        $responsearr['data']['agent']['valid'] = true;
    }
    else
    {
        $responsearr['data']['agent']['valid'] = false;
        $responsearr['data']['agent']['reason'] = 'Agent Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    //-----attachment-----
    /*
    if (isset($_POST['comment']))
    {
        //stricter validation here
        $responsearr['data']['comment']['valid'] = true;
    }
    else
    {
        $responsearr['data']['comment']['valid'] = false;
        $responsearr['data']['comment']['reason'] = 'Comment Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    */
    //-----comment-----
    if (isset($_POST['comment']))
    {
        //stricter validation here
        $responsearr['data']['comment']['valid'] = true;
    }
    else
    {
        $responsearr['data']['comment']['valid'] = false;
        $responsearr['data']['comment']['reason'] = 'Comment Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    site_verbose("validation complete");
    //=====data input=====
	if ($responsearr['action'] == 1) //if any error
    {
        site_verbose("no error, preparing");
        $stmt = $sitedbPDO->prepare("   UPDATE ticket 
                                        SET ticket_title=:st_ticket_title,
                                            category_id=:st_category_id,
                                            user_id=:st_user_id,
                                            status_id=:st_status_id,
                                            tier_id=:st_tier_id,
                                            priority_id=:st_priority_id,
                                            urgency_id=:st_urgency_id,
                                            impact_id=:st_impact_id,
                                            agent_id=:st_agent_id,
                                            attachment=:st_attachment,
                                            ticket_comment=:st_ticket_comment,
                                        WHERE ticket_id=:st_ticket_id
                                        ;");
        $stmt->bindParam(':st_ticket_title',$_POST['title']);
        $stmt->bindParam(':st_category',$_POST['category']);
        $stmt->bindParam(':st_user_id',$_POST['user_id']);
        $stmt->bindParam(':st_status_id',$_POST['status']);
        $stmt->bindParam(':st_tier_id',$_POST['tier']);
        $stmt->bindParam(':st_priority_id',$_POST['priority']);
        $stmt->bindParam(':st_urgency_id',$_POST['urgency']);
        $stmt->bindParam(':st_impact_id',$_POST['impact']);
        $stmt->bindParam(':st_agent_id',$_POST['agent']);
        $stmt->bindParam(':st_ticket_comment',$_POST['comment']);
        $stmt->bindParam(':st_ticket_id',$ticket_id);
        site_verbose("prepared");
        if ($stmt->execute())
        {
            site_verbose("executed successfully");
            if ($stmt->rowCount() == 1)
            {
                site_verbose("rowCount 1");
                //$responsearr['action'] = 1; //no error, redundant
                site_verbose("Submitted");
            }
            else
            {
                $responsearr['action'] = 0; //error
                site_debug("no rows affected");
            }
        }
        else
        {
            $responsearr['action'] = 0; //error
            site_debug("execution error");
        }
    }
    //else, not doing data input, return now to report errors
	//=====end=====
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
