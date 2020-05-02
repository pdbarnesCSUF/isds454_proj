<?php
/*
 * @file ajax_user_submit.php
 * @desc user submits ticket
 */
 
$responsearr['action'] = 00; //unknown error
$responsearr['data'] = array(
    'userid' => array(
		'valid' => false,
		'reason' => ''
	),
	'title' => array(
		'valid' => false,
		'reason' => ''
	),
	'category' => array(
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
	site_verbose('PAGE:ajax/ajax_user_submit.php');
	//site_init();
	//do something
    $responsearr['action'] = 1; //no problem start, set 7 if bad input
	//=====quick validation===== TODO full validation later
    //-----userid-----
    $user_id = 1; //normally handled by SSO
    /*
    if (isset($_POST['userid']))
    {
        //stricter validation here
        $responsearr['data']['userid']['valid'] = true;
    }
    else
    {
        $responsearr['data']['userid']['valid'] = false;
        $responsearr['data']['userid']['reason'] = 'User Missing';
        $responsearr['action'] = 07; //bad / missing input
    }
    */
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
        $stmt = $sitedbPDO->prepare("   INSERT INTO ticket (user_id, ticket_title, category_id, ticket_comment, status_id, tier_id)
                                        VALUES (:st_user_id,:st_ticket_title,:st_category,:st_ticket_comment,1,2);");
        $stmt->bindParam(':st_user_id',$user_id);
        $stmt->bindParam(':st_ticket_title',$_POST['title']);
        $stmt->bindParam(':st_category',$_POST['category']);
        $stmt->bindParam(':st_ticket_comment',$_POST['comment']);
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
