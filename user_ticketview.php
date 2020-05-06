<?php
/**
 *  @file user_ticketview.php
 *  @brief user side ticket view
 *  
 */
use Tracy\Debugger;
require_once ('vendor/tracy.php');
require_once('include/include.php');
if ($sitesettings['debug'])
	Debugger::enable(Debugger::DEVELOPMENT);

//comment to use defaults
//opengraph and twitter meta info
$pageinfo['title'] = "View Ticket - ".$sitesettings['meta']['og:title'];
$pageinfo['description'] = "View Ticket";
//$pageinfo['type'] = $sitesettings['meta']['og:type'];
//$pageinfo['url'] = $sitesettings['meta']['og:url'];
//$pageinfo['image'] = $sitesettings['meta']['og:image'];
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
        <?php include($INCLUDE.'/head.php'); ?>
        <title><?php echo $pageinfo['title']?></title>
</head>
<body>
<script>
//https://stackoverflow.com/a/21903119/1573939
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};
function labelajax(selector,state_class,message){
	if (state_class == 'hide')
	{
		$(selector).hide();
	}
	else {
		$(selector).show();
		$(selector).removeClass();
		$(selector).addClass("label " + state_class);
		$(selector).text(message);
	}
}//func labelajax
	$(document).ready ( function () {
        var current_user_id = 1; //user id of who we are simulating
        var current_ticket_id = (getUrlParameter('ticket_id')); //ticket id
        console.log ("cur ticket id:"+current_ticket_id);
        if (current_ticket_id != undefined)
        {
            $('#user_view_ticketid').val(current_ticket_id);
            //-------populate ticket info-----------
            $.getJSON( "ajax/ajax_get_ticketinfo.php?ticket_id="+current_ticket_id, function( rtndata ) {
                if ( rtndata.action == 1)
                {
                    $('#user_view_user').val(rtndata.data.user_firstname + ' ' + rtndata.data.user_lastname);
                    $('#user_view_email').val(rtndata.data.user_email);
                    $('#user_view_department').val(rtndata.data.user_department);
                    $('#user_view_date').val(rtndata.data.ticket_date);
                    
                    $('#user_view_title').val(rtndata.data.ticket_title);
                    $('#user_view_category').val(rtndata.data.category_name);
                    $('#user_view_status').val(rtndata.data.status_name);
                    $('#user_view_tier').val(rtndata.data.tier_name);
                    
                    //$('#user_view_attachment').val(rtndata.data.ticket_attachment);
                    $('#user_view_comment').val(rtndata.data.ticket_comment);
                }//if
                else
                {
                    console.error ("rtndata action not 1");
                    console.error ("ticketinfo fail");
                    $("#user_view_submitbtn").prop("disabled", true);
                    labelajax("#user_view_user_status" ,"label-danger" ,'Error Getting Data');
                    labelajax("#user_view_email_status","label-danger" ,'Error Getting Data');
                    labelajax("#user_view_department_status","label-danger" ,'Error Getting Data');
                    labelajax("#user_view_date_status","label-danger" ,'Error Getting Data');
                    labelajax("#user_view_title_status","label-danger" ,'Error Getting Data');
                    labelajax("#user_view_category_status","label-danger" ,'Error Getting Data');
                    labelajax("#user_view_status_status","label-danger" ,'Error Getting Data');
                    labelajax("#user_view_tier_status","label-danger" ,'Error Getting Data');
                    labelajax("#user_view_attachment_status","label-danger" ,'Error Getting Data');
                    labelajax("#user_view_comment_status","label-danger" ,'Error Getting Data');
                }
            }).fail( function(rtndata, textStatus, error) {
                console.error("getJSON failed, status: " + textStatus + ", error: "+error);
                console.error ("ticketinfo fail");
                $("#user_view_submitbtn").prop("disabled", true);
                labelajax("#user_view_category_status","label-danger" ,'Error Getting Data');
            });//getJSON - ajax_get_userinfo.php
        }//if ticket id defined
        else
        {
            $('#agent_submit_ticketid').val("MISSING TICKET ID");
            $("#agent_submit_submitbtn").prop("disabled", true);
        }
    });
</script>
	<?php require($INCLUDE.'/links.php'); ?>
<div id="main" class="container">
	<h1><strong>Edit Ticket</strong></h1>
	<div id="mainwell" class="well">
		<div class="form-horizontal">
			<form id="user_view_form">
                <div class="form-group">
					<label class="control-label col-sm-2" for="user_view_ticketid">Ticket ID</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_view_ticketid" name="ticket_id" value="ticket id" READONLY>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_view_user">User</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_view_user" value="sso username" READONLY>
						<div class="ajax-response" id="user_view_user_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_view_email">Email</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_view_email" value="sso.email@organization.com" READONLY>
						<div class="ajax-response" id="user_view_email_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="user_view_department">Department</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_view_department" value="sso department" READONLY>
						<div class="ajax-response" id="user_view_department_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_view_date">Date</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_view_date" name="date" value="" READONLY>
						<div class="ajax-response" id="user_view_date_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="user_view_title">Title</label>
					<div class="col-sm-10">
                        <input class="form-control" id="user_view_title" name="title" READONLY>
						<div class="ajax-response" id="user_view_title_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_view_category">Category</label>
					<div class="col-sm-10">
                        <input class="form-control" id="user_view_category" name="category" READONLY>
						<div class="ajax-response" id="user_view_category_status"></div>
					</div>
				</div>
                <hr><!-----------------agent stuff------------------------>
                <div class="form-group">
					<label class="control-label col-sm-2" for="user_view_status">Status</label>
					<div class="col-sm-10">
                        <input class="form-control" id="user_view_status" name="status" READONLY>
						<div class="ajax-response" id="user_view_status_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="user_view_tier">Tier</label>
					<div class="col-sm-10">
                        <input class="form-control" id="user_view_tier" name="tier" READONLY>
						<div class="ajax-response" id="user_view_tier_status"></div>
					</div>
				</div>
                <hr>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_view_attachment">Attachment</label>
					<div class="col-sm-10">
						<!-- no attachment -->
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_view_comment">Comment</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="user_view_comment" name="comment" rows="5" placeholder="State Problem" READONLY></textarea>
						<div class="ajax-response" id="user_view_comment_status"></div>
					</div>
				</div>
		</div><!--form-horizontal-->
	</div><!--mainwell-->
</div><!--main-->
<?php require($INCLUDE.'/copy.php'); ?>
</body>
</html>
