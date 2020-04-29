<?php
/**
 *  @file user.php
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
$pageinfo['title'] = "User Home - ".$sitesettings['meta']['og:title'];
$pageinfo['description'] = "User homepage";
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
	$(document).ready ( function () {
        //-------ticket list-----------
		$.getJSON( "ajax/ajax_user_listtickets.php", function( rtndata ) {
			if ( rtndata.action == 1)
			{
				if (rtndata.data.count > 0)
				{
					$.each(rtndata.data.ticket, function(idx,value) {
						$('#user_tickettable > tbody:last-child').append('<tr id="ticket' + value.ticket_id + '">'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.ticket_id+'</a></td>'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.ticket_date+'</a></td>'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.category_name+'</a></td>'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.status_name+'</a></td>'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.ticket_title+'</a></td>'+
														'</tr>');
					});//each
				}
				else
				{
					$('#user_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td colspan="5" class="tdcenter">No Data</td>'+
														'</tr>');
				}
			}//if
			else
			{
				console.error("getJSON returned not 1, returned: " + rtndata.action);
				$('#user_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td colspan="5" class="tdcenter">Error retrieving data</td>'+
														'</tr>');
			}
		}).fail( function(rtndata, textStatus, error) {
			console.error("getJSON failed, status: " + textStatus + ", error: "+error);
			$('#user_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td colspan="5" class="tdcenter">Connection Error</td>'+
														'</tr>');
		});//getJSON - ajax_user_listtickets.php
    });
</script>
	<?php require($INCLUDE.'/links.php'); ?>
<div id="main" class="container-fluid">
	<h1><strong>User home Page</strong></h1>
	<div id="mainwell" class="well">
    <a href="user_submit.php" class="btn btn-primary" role="button">Submit Ticket</a>
    <hr>
    <table class="table table-hover table-condensed" id="user_tickettable">
    <thead><tr>
        <th>ID</th>
        <th>Date</th>
        <th>Category</th>
        <th>Status</th>
        <th>Title</th>
    </tr></thead>
    <tbody id="user_ticketbody">
    
    </tbody>
    </table>
	</div><!--mainwell-->
</div><!--main-->
<?php require($INCLUDE.'/copy.php'); ?>
</body>
</html>
