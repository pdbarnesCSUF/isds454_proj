<?php
/**
 *  @file links.php
 *  @brief Included - Links on the top of the page for all pages
 */
?>

<nav id="sitenav" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="header-img" class="navbar-left"  href="<?php echo $sitesettings['address']?>"><img style="max-width:50px" alt="<?php echo $sitesettings['title'] ?>" src="<?php echo $sitesettings['address'];?>/images/logo.png"></a>
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