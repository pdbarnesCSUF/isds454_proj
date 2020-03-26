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
$pageinfo['title'] = "Submit Ticket - ".$sitesettings['meta']['og:title'];
$pageinfo['description'] = "User Submit Ticket";
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
<div id="main" class="container">
	<h1><strong>Submit Ticket</strong></h1>
	<div id="mainwell" class="well">
		<div class="form-horizontal">
			<form id="user_submit_form">
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_user">User</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_submit_user" name="username" value="sse username" DISABLED READONLY>
						<div class="ajax-response" id="user_submit_user"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_email">Email</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_submit_email" name="email" value="sso.email@organization.com" DISABLED READONLY>
						<div class="ajax-response" id="user_submit_email"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_date">Date</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_submit_date" name="date" value="<?php echo date('Y-m-d') ?>" DISABLED READONLY>
						<div class="ajax-response" id="user_submit_date"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_category">Category</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_submit_category" name="category" placeholder="Software/hardware/etc" value="">
						<div class="ajax-response" id="user_submit_category"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_attachment">Attachment</label>
					<div class="col-sm-10">
						<div class="col-sm-8">
							<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo return_bytes($sitesettings['attachment_max_s']);?>" />
							<input class="btn btn-default" id="user_submit_attachment" name="user_submit_attachment" type="file" >
							<div class="help-block">
								Max file size:<?php echo $sitesettings['attachment_max_s'];?>.
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_comment">Comment</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="user_submit_comment" name="comment" rows="5" placeholder="State Problem"></textarea>
						<div class="ajax-response" id="user_submit_comment"></div>
					</div>
				</div>
				<div class="form-group">
					<button class="btn btn-primary" id="user_submit_submitbtn">Submit</button>
					<div class="ajax-response" id="user_submit_submitbtn"></div>
				</div>
			</form><!-- user_submit form -->
		</div><!--form-horizontal-->
	</div><!--mainwell-->
</div><!--main-->
<?php require($INCLUDE.'/copy.php'); ?>
</body>
</html>
