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
$pageinfo['title'] = "Login - ".$sitesettings['meta']['og:title'];
$pageinfo['description'] = "Login";
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
	<?php require($INCLUDE.'/links.php'); ?>
<div id="main" class="container-fluid">
	<h1><strong>Login Page</strong></h1>
	<div id="mainwell" class="well">
	Ticketing system login page. Organization specific SSO login would be here.
	<br>
	<a href="user.php">--- i am a user ---</a>
	<br>
	<a href="agent.php">--- i am an agent --- </a>
	</div><!--mainwell-->
</div><!--main-->
<?php require($INCLUDE.'/copy.php'); ?>
</body>
</html>
