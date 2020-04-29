<?php
/**
 *  @file agent.php
 *  @brief user view of tickets
 *  
 */
use Tracy\Debugger;
require_once ('vendor/tracy.php');
require_once('include/include.php');
if ($sitesettings['debug'])
	Debugger::enable(Debugger::DEVELOPMENT);

//comment to use defaults
//opengraph and twitter meta info
$pageinfo['title'] = "Agent Home - ".$sitesettings['meta']['og:title'];
$pageinfo['description'] = "Agent homepage";
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
    function nullblank(d) {
        if (d == null) return ' ';
        else return d;
    }
	$(document).ready ( function () {
        //-------ticket list-----------
		$.getJSON( "ajax/ajax_agent_listtickets.php", function( rtndata ) {
			if ( rtndata.action == 1)
			{
				if (rtndata.data.count > 0)
				{
					$.each(rtndata.data.ticket, function(idx,value) {
						$('#agent_tickettable > tbody:last-child').append('<tr id="ticket' + value.ticket_id + '">'+
															'<td><a href="agent_ticketview.php?ticket_id='+value.ticket_id+'">'+value.ticket_id+'</a></td>'+
															'<td><a href="agent_ticketview.php?ticket_id='+value.ticket_id+'">'+value.ticket_date+'</a></td>'+
															'<td><a href="agent_ticketview.php?ticket_id='+value.ticket_id+'">'+value.category_name+'</a></td>'+
															'<td><a href="agent_ticketview.php?ticket_id='+value.ticket_id+'">'+value.status_name+'</a></td>'+
															'<td><a href="agent_ticketview.php?ticket_id='+value.ticket_id+'">'+value.ticket_title+'</a></td>'+
															//TODO - list all from one user / view user page
                                                            '<td>'+nullblank(value.user_lastname)+'</td>'+
															'<td>'+nullblank(value.tier_value)+'</td>'+
															'<td>'+nullblank(value.priority_value)+'</td>'+
															'<td>'+nullblank(value.urgency_value)+'</td>'+
															'<td>'+nullblank(value.impact_value)+'</td>'+
															'<td>'+nullblank(value.agent_id)+'</td>'+
														'</tr>');
					});//each
				}
				else
				{
					$('#agent_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td colspan="11" class="tdcenter">No Data</td>'+
														'</tr>');
				}
			}//if
			else
			{
				console.error("getJSON returned not 1, returned: " + rtndata.action);
				$('#agent_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td colspan="11">Error retrieving data</td>'+
														'</tr>');
			}
		}).fail( function(rtndata, textStatus, error) {
			console.error("getJSON failed, status: " + textStatus + ", error: "+error);
			$('#agent_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td colspan="11">Connection Error</td>'+
														'</tr>');
		});//getJSON - ajax_agent_listtickets.php
    });
</script>
	<?php require($INCLUDE.'/links.php'); ?>
<div id="main" class="container-fluid">
	<h1><strong>Agent home Page</strong></h1>
	<div id="mainwell" class="well">
    <!-- submit on users behalf -->
    <!--<a href="agent_submit.php" class="btn btn-primary" role="button">Submit Ticket</a>-->
    <hr>
    <table class="table table-hover table-condensed" id="agent_tickettable">
    <thead><tr>
        <th>ID</th>
        <th>Date</th>
        <th>Category</th>
        <th>Status</th>
        <th>Title</th>
        <th>User (last)</th>
        <th>Tier</th>
        <th>Priority</th>
        <th>Urgency</th>
        <th>Impact</th>
        <th>Agent</th>
    </tr></thead>
    <tbody id="agent_ticketbody">
    
    </tbody>
    </table>
	</div><!--mainwell-->
</div><!--main-->
<?php require($INCLUDE.'/copy.php'); ?>
</body>
</html>
