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
	<?php require($INCLUDE.'/links.php'); ?>
<div id="main" class="container-fluid">
	<h1><strong>TEMPLATE Page</strong></h1>
	<div id="mainwell" class="well">
	<!-- CONTENT HERE -->
	</div><!--mainwell-->
</div><!--main-->
<?php require($INCLUDE.'/copy.php'); ?>
</body>
</html>
