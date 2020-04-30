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
<script>
	$(document).ready ( function () {
        var current_user_id = 1; //user id of who we are simulating
        //-------set date time-----------
        var dt = new Date();
        var now_timestamp = dt.getFullYear() + "-" + (dt.getMonth()+1) + "-" + dt.getDate();
        $('#user_submit_date').val(now_timestamp);
        //-------populate dropdowns-----------
		$.getJSON( "ajax/ajax_get_formfields.php", function( rtndata ) {
			if ( rtndata.action == 1)
			{
                //---Category---
                $.each(rtndata.data.category, function(idx,value) {
                    $('#user_submit_category').append('<option id="category' + value.category_id + '">'+
                                                        value.category_name+
                                                    '</option>');
                });//each category
			}//if
            else
            {
                console.error ("rtndata action not 1");
            }
		}).fail( function(rtndata, textStatus, error) {
			console.error("getJSON failed, status: " + textStatus + ", error: "+error);
			$('#user_submit_category').append('<option id="categoryE">'+
                                                        'Error Getting Data'+
                                                    '</option>');
		});//getJSON - ajax_get_formfields.php
        //-------populate userinfo-----------
		$.getJSON( "ajax/ajax_get_userinfo.php?user_id="+current_user_id, function( rtndata ) {
			if ( rtndata.action == 1)
			{
                    $('#user_submit_user').val(rtndata.data.user_firstname + ' ' + rtndata.data.user_lastname);
                    $('#user_submit_email').val(rtndata.data.user_email);
			}//if
            else
            {
                console.error ("rtndata action not 1");
            }
		}).fail( function(rtndata, textStatus, error) {
			console.error("getJSON failed, status: " + textStatus + ", error: "+error);
			$('#user_submit_category').append('<option id="categoryE">'+
                                                        'Error Getting Data'+
                                                    '</option>');
		});//getJSON - ajax_get_userinfo.php
    });
</script>
	<?php require($INCLUDE.'/links.php'); ?>
<div id="main" class="container">
	<h1><strong>Submit Ticket</strong></h1>
	<div id="mainwell" class="well">
		<div class="form-horizontal">
			<form id="user_submit_form">
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_user">User</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_submit_user" name="username" value="sso username" DISABLED READONLY>
						<div class="ajax-response" id="user_submit_user_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_email">Email</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_submit_email" name="email" value="sso.email@organization.com" DISABLED READONLY>
						<div class="ajax-response" id="user_submit_email_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_date">Date</label>
					<div class="col-sm-10">
						<input class="form-control" id="user_submit_date" name="date" value="<?php echo date('Y-m-d') ?>" DISABLED READONLY>
						<div class="ajax-response" id="user_submit_date_status"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_submit_category">Category</label>
					<div class="col-sm-10">
                        <select class="form-control" id="user_submit_category">
                        </select>
						<div class="ajax-response" id="user_submit_category_status"></div>
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
						<div class="ajax-response" id="user_submit_comment_status"></div>
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
