<?php
/**
 *  @file agent_ticketedit.php
 *  @brief agent side ticket edit
 *  
 */
use Tracy\Debugger;
require_once ('vendor/tracy.php');
require_once('include/include.php');
if ($sitesettings['debug'])
	Debugger::enable(Debugger::DEVELOPMENT);

//comment to use defaults
//opengraph and twitter meta info
$pageinfo['title'] = "Edit Ticket - ".$sitesettings['meta']['og:title'];
$pageinfo['description'] = "Agent Edit Ticket";
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
        var current_agent_id = 1; //agent id of who we are simulating
        var current_ticket_id = (getUrlParameter('ticket_id')); //ticket id
        console.log ("cur ticket id:"+current_ticket_id);
        if (current_ticket_id != undefined)
        {
            $('#agent_submit_ticketid').val(current_ticket_id);
            //-------populate agentlist-----------
            $.getJSON( "ajax/ajax_agent_listagents.php", function( rtndata ) {
                if ( rtndata.action == 1)
                {
                    console.log("1");
                    //---agent---
                    $.each(rtndata.data.agent, function(idx,value) {
                        $('#agent_submit_agent').append('<option id="agent' + value.agent_id + '" value="' + value.agent_id + '">'+
                                                            value.agent_firstname+ ' ' + value.agent_lastname + 
                                                        '</option>');
                    });//each agent
                }//if
                else
                {
                    $("#agent_submit_submitbtn").prop("disabled", true);
                    console.error ("agentlist fail");
                    console.error ("rtndata action not 1");
                    labelajax("#agent_submit_agent_status","label-danger" ,'Error Getting Data');
                }
            }).fail( function(rtndata, textStatus, error) {
                console.error("getJSON failed, status: " + textStatus + ", error: "+error);
                $("#agent_submit_submitbtn").prop("disabled", true);
                console.error ("agentlist fail");
                labelajax("#agent_submit_agent_status","label-danger" ,'Error Getting Data');
            });//getJSON - ajax_agent_listagents.php
            //-------populate dropdowns-----------
            $.getJSON( "ajax/ajax_get_formfields.php", function( rtndata ) {
                if ( rtndata.action == 1)
                {
                    //---Category---
                    $.each(rtndata.data.category, function(idx,value) {
                        $('#agent_submit_category').append('<option id="category' + value.category_id + '" value="' + value.category_id + '">'+
                                                            value.category_name+
                                                        '</option>');
                    });//each category
                    //---Status---
                    $.each(rtndata.data.status, function(idx,value) {
                        $('#agent_submit_status').append('<option id="status' + value.status_id + '" value="' + value.status_id + '">'+
                                                            value.status_name+
                                                        '</option>');
                    });//each status
                    //---Tier---
                    $.each(rtndata.data.tier, function(idx,value) {
                        $('#agent_submit_tier').append('<option id="tier' + value.tier_id + '" value="' + value.tier_id + '">'+
                                                            value.tier_name+
                                                        '</option>');
                    });//each tier
                    //---priority---
                    $.each(rtndata.data.priority, function(idx,value) {
                        $('#agent_submit_priority').append('<option id="priority' + value.priority_id + '" value="' + value.priority_id + '">'+
                                                            value.priority_name+
                                                        '</option>');
                    });//each priority
                    //---urgency---
                    $.each(rtndata.data.urgency, function(idx,value) {
                        $('#agent_submit_urgency').append('<option id="urgency' + value.urgency_id + '" value="' + value.urgency_id + '">'+
                                                            value.urgency_name+
                                                        '</option>');
                    });//each urgency
                    //---impact---
                    $.each(rtndata.data.impact, function(idx,value) {
                        $('#agent_submit_impact').append('<option id="impact' + value.impact_id + '" value="' + value.impact_id + '">'+
                                                            value.impact_name+
                                                        '</option>');
                    });//each impact
                }//if
                else
                {
                    $("#agent_submit_submitbtn").prop("disabled", true);
                    console.error ("dropdowns fail");
                    console.error ("rtndata action not 1");
                    labelajax("#agent_submit_category_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_status_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_tier_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_priority_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_urgency_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_impact_status","label-danger" ,'Error Getting Data');
                }
            }).fail( function(rtndata, textStatus, error) {
                console.error("getJSON failed, status: " + textStatus + ", error: "+error);
                $("#agent_submit_submitbtn").prop("disabled", true);
                console.error ("dropdowns fail");
                labelajax("#agent_submit_category_status","label-danger" ,'Error Getting Data');
                labelajax("#agent_submit_status_status","label-danger" ,'Error Getting Data');
                labelajax("#agent_submit_tier_status","label-danger" ,'Error Getting Data');
                labelajax("#agent_submit_priority_status","label-danger" ,'Error Getting Data');
                labelajax("#agent_submit_urgency_status","label-danger" ,'Error Getting Data');
                labelajax("#agent_submit_impact_status","label-danger" ,'Error Getting Data');
            });//getJSON - ajax_get_formfields.php
            //-------populate ticket info-----------
            $.getJSON( "ajax/ajax_get_ticketinfo.php?ticket_id="+current_ticket_id, function( rtndata ) {
                if ( rtndata.action == 1)
                {
                    $('#agent_submit_userid').val(rtndata.data.user_id);
                    $('#agent_submit_user').val(rtndata.data.user_firstname + ' ' + rtndata.data.user_lastname);
                    $('#agent_submit_email').val(rtndata.data.user_email);
                    $('#agent_submit_department').val(rtndata.data.user_department);
                    $('#agent_submit_date').val(rtndata.data.ticket_date);
                    
                    $('#agent_submit_title').val(rtndata.data.ticket_title);
                    $('#agent_submit_category').val(rtndata.data.category_id);
                    $('#agent_submit_status').val(rtndata.data.status_id);
                    $('#agent_submit_tier').val(rtndata.data.tier_id);
                    $('#agent_submit_priority').val(rtndata.data.priority_id);
                    $('#agent_submit_urgency').val(rtndata.data.urgency_id);
                    $('#agent_submit_impact').val(rtndata.data.impact_id);
                    $('#agent_submit_agent').val(rtndata.data.agent_id);
                    
                    //$('#agent_submit_attachment').val(rtndata.data.ticket_attachment);
                    $('#agent_submit_comment').val(rtndata.data.ticket_comment);
                }//if
                else
                {
                    console.error ("rtndata action not 1");
                    console.error ("ticketinfo fail");
                    $("#agent_submit_submitbtn").prop("disabled", true);
                    labelajax("#agent_submit_user_status" ,"label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_email_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_department_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_date_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_title_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_category_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_status_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_tier_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_priority_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_urgency_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_impact_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_agent_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_attachment_status","label-danger" ,'Error Getting Data');
                    labelajax("#agent_submit_comment_status","label-danger" ,'Error Getting Data');
                }
            }).fail( function(rtndata, textStatus, error) {
                console.error("getJSON failed, status: " + textStatus + ", error: "+error);
                console.error ("ticketinfo fail");
                $("#agent_submit_submitbtn").prop("disabled", true);
                labelajax("#agent_submit_category_status","label-danger" ,'Error Getting Data');
            });//getJSON - ajax_get_userinfo.php
            //submit
            $("#agent_submit_submitbtn").click(function(e) {
                $("#agent_submit_submitbtn").prop('value',"Submitting...");
                $("#agent_submit_submitbtn").prop('disabled',true);
                $.ajax({
                    type: "POST",
                    url: "ajax/ajax_agent_ticketedit.php",
                    data: $("#agent_submit_form").serialize(),
                    xhrFields: { withCredentials: true },
                    success: function (rtndata) {
                        if (rtndata.action == 1)
                        {
                            $("#agent_submit_submitbtn_status").text('Success. Submitted.');
                            //window.location.href = "<?php echo $sitesettings['address'];?>/agent.php";
                        }//if (rtndata.action == 1)
                        else
                        {
                            if (rtndata.data.userid.valid)
                                labelajax("#agent_submit_userid_status","label-success",rtndata.data.userid.reason);
                            else
                                labelajax("#agent_submit_userid_status","label-danger" ,rtndata.data.userid.reason);
                            if (rtndata.data.title.valid)
                                labelajax("#agent_submit_title_status","label-success",rtndata.data.title.reason);
                            else
                                labelajax("#agent_submit_title_status","label-danger" ,rtndata.data.title.reason);
                            if (rtndata.data.category.valid)
                                labelajax("#agent_submit_category_status","label-success",rtndata.data.category.reason);
                            else
                                labelajax("#agent_submit_category_status","label-danger" ,rtndata.data.category.reason);
                            //-------------
                            if (rtndata.data.status.valid)
                                labelajax("#agent_submit_status_status","label-success",rtndata.data.status.reason);
                            else
                                labelajax("#agent_submit_status_status","label-danger" ,rtndata.data.status.reason);
                            if (rtndata.data.tier.valid)
                                labelajax("#agent_submit_tier_status","label-success",rtndata.data.tier.reason);
                            else
                                labelajax("#agent_submit_tier_status","label-danger" ,rtndata.data.tier.reason);
                            if (rtndata.data.priority.valid)
                                labelajax("#agent_submit_priority_status","label-success",rtndata.data.priority.reason);
                            else
                                labelajax("#agent_submit_priority_status","label-danger" ,rtndata.data.priority.reason);
                            if (rtndata.data.urgency.valid)
                                labelajax("#agent_submit_urgency_status","label-success",rtndata.data.urgency.reason);
                            else
                                labelajax("#agent_submit_urgency_status","label-danger" ,rtndata.data.urgency.reason);
                            if (rtndata.data.impact.valid)
                                labelajax("#agent_submit_impact_status","label-success",rtndata.data.impact.reason);
                            else
                                labelajax("#agent_submit_impact_status","label-danger" ,rtndata.data.impact.reason);
                            if (rtndata.data.agentid.valid)
                                labelajax("#agent_submit_agent_status","label-success",rtndata.data.agentid.reason);
                            else
                                labelajax("#agent_submit_agent_status","label-danger" ,rtndata.data.agentid.reason);
                            //-------------
                            if (rtndata.data.attachment.valid)
                                labelajax("#agent_submit_attachment_status","label-success",rtndata.data.attachment.reason);
                            else
                                labelajax("#agent_submit_attachment_status","label-danger" ,rtndata.data.attachment.reason);
                            if (rtndata.data.comment.valid)
                                labelajax("#agent_submit_comment_status","label-success",rtndata.data.comment.reason);
                            else
                                labelajax("#agent_submit_comment_status","label-danger" ,rtndata.data.comment.reason);
                        }//else of (rtndata.action == 1)
                    },
                    fail: function (rtndata) {
                        labelajax("#agent_submit_submitbtn_status","label-danger" ,'Connection Error');
                    }
                });//ajax
                $("#agent_submit_submitbtn").prop('value',"Submit");
                $("#agent_submit_submitbtn").prop('disabled',false);
            });
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
			<form id="agent_submit_form">
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_ticketid">Ticket ID</label>
					<div class="col-sm-10">
						<input class="form-control" id="agent_submit_ticketid" name="ticket_id" value="ticket id" READONLY>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_userid">User ID</label>
					<div class="col-sm-10">
						<input class="form-control" id="agent_submit_userid" name="userid" value="user id" READONLY>
						<div class="ajax-response" id="agent_submit_userid_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_user">User</label>
					<div class="col-sm-10">
						<input class="form-control" id="agent_submit_user" value="sso username" READONLY>
						<div class="ajax-response" id="agent_submit_user_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_email">Email</label>
					<div class="col-sm-10">
						<input class="form-control" id="agent_submit_email" value="sso.email@organization.com" READONLY>
						<div class="ajax-response" id="agent_submit_email_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_department">Department</label>
					<div class="col-sm-10">
						<input class="form-control" id="agent_submit_department" value="sso department" READONLY>
						<div class="ajax-response" id="agent_submit_department_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_date">Date</label>
					<div class="col-sm-10">
						<input class="form-control" id="agent_submit_date" name="date" value="<?php echo date('Y-m-d') ?>" READONLY>
						<div class="ajax-response" id="agent_submit_date_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_title">Title</label>
					<div class="col-sm-10">
                        <input class="form-control" id="agent_submit_title" name="title">
						<div class="ajax-response" id="agent_submit_title_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_category">Category</label>
					<div class="col-sm-10">
                        <select class="form-control" id="agent_submit_category" name="category">
                        </select>
						<div class="ajax-response" id="agent_submit_category_status"></div>
					</div>
				</div>
                <hr><!-----------------agent stuff------------------------>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_status">Status</label>
					<div class="col-sm-10">
                        <select class="form-control" id="agent_submit_status" name="status">
                        </select>
						<div class="ajax-response" id="agent_submit_status_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_tier">Tier</label>
					<div class="col-sm-10">
                        <select class="form-control" id="agent_submit_tier" name="tier">
                        </select>
						<div class="ajax-response" id="agent_submit_tier_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_priority">Priority</label>
					<div class="col-sm-10">
                        <select class="form-control" id="agent_submit_priority" name="priority">
                        </select>
						<div class="ajax-response" id="agent_submit_priority_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_urgency">Urgency</label>
					<div class="col-sm-10">
                        <select class="form-control" id="agent_submit_urgency" name="urgency">
                        </select>
						<div class="ajax-response" id="agent_submit_urgency_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_impact">Impact</label>
					<div class="col-sm-10">
                        <select class="form-control" id="agent_submit_impact" name="impact">
                        </select>
						<div class="ajax-response" id="agent_submit_impact_status"></div>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_agent">Agent</label>
					<div class="col-sm-10">
                        <select class="form-control" id="agent_submit_agent" name="agentid">
                        </select>
						<div class="ajax-response" id="agent_submit_agent_status"></div>
					</div>
				</div>
                <hr>
				<div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_attachment">Attachment</label>
					<div class="col-sm-10">
						<!-- no attachment -->
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="agent_submit_comment">Comment</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="agent_submit_comment" name="comment" rows="5" placeholder="State Problem"></textarea>
						<div class="ajax-response" id="agent_submit_comment_status"></div>
					</div>
				</div>
			</form><!-- agent_submit form -->
            <div class="form-group">
                <button class="btn btn-primary" id="agent_submit_submitbtn">Submit</button>
                <div class="ajax-response" id="agent_submit_submitbtn_status"></div>
            </div>
		</div><!--form-horizontal-->
	</div><!--mainwell-->
</div><!--main-->
<?php require($INCLUDE.'/copy.php'); ?>
</body>
</html>
