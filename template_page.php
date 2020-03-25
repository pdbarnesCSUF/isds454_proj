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
$pageinfo['title'] = "TEMPLATEPAGE - ".$sitesettings['meta']['og:title'];
$pageinfo['description'] = "change me plz T_T";
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

			</div>
		</div>
	</nav>
<div id="main" class="container-fluid">
	<h1><strong>TEMPLATE Page</strong></h1>
	<div id="mainwell" class="well">
	<!-- CONTENT HERE -->
	</div><!--mainwell-->
</div><!--main-->
<?php require($INCLUDE.'/copy.php'); ?>
</body>
</html>
