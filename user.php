<?php
/**
 *  @file template_page.php
 *  @brief template page. intended to be placed in root
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
					$.each(rtndata.data, function(idx,value) {
						$('#user_tickettable > tbody:last-child').append('<tr id="ticket' + value.ticket_id + '">'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.ticket_id+'</a></td>'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.date+'</a></td>'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.category+'</a></td>'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.status+'</a></td>'+
															'<td><a href="user_ticketview.php?ticket_id='+value.ticket_id+'">'+value.title+'</a></td>'+
														'</tr>');
					});//each
				}
				else
				{
					$('#user_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td></td>'+
															'<td></td>'+
															'<td></td>'+
															'<td></td>'+
															'<td>No Data</td>'+
														'</tr>');
				}
			}//if
			else
			{
				console.error("getJSON returned not 1, returned: " + rtndata.action);
				$('#user_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td></td>'+
															'<td></td>'+
															'<td></td>'+
															'<td></td>'+
															'<td>Error retrieving data</td>'+
														'</tr>');
			}
		}).fail( function(rtndata, textStatus, error) {
			console.error("getJSON failed, status: " + textStatus + ", error: "+error);
			$('#user_tickettable > tbody:last-child').append('<tr id="ticket0">'+
															'<td></td>'+
															'<td></td>'+
															'<td></td>'+
															'<td></td>'+
															'<td>Error retrieving data</td>'+
														'</tr>');
		});//getJSON - ajax_user_listtickets.php
    });
</script>
	<nav id="sitenav" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="header-img" class="navbar-left"  href="<?php echo $sitesettings['address']?>"><img style="max-width:50px" alt="<?php echo $sitesettings['title'] ?>" src="<?php echo $sitesettings['address'];?>images/logo.png"></a>
				<a class="navbar-brand" href="<?php echo $sitesettings['address']?>"><?php echo $sitesettings['title'] ?></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li id="sitenav-userhome"><a href="<?php echo $sitesettings['address']?>/user.php">User Home</a></li>
					<li id="sitenav-agenthome"><a href="<?php echo $sitesettings['address']?>/agent.php">Agent Home</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li id="sitenav-userview">View</li>
					<li id="sitenav-usersubmit">Submit</li>
				</ul>
			</div>
		</div>
	</nav>
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
