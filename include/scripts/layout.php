<?php
$layout = array(
	'header-begin'=>'
		<!DOCTYPE html>
		<html><head>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
			<title>%s</title>
			<link rel="stylesheet" type="text/css" href="include/style/%s/style.css">
			<link rel="stylesheet" type="text/css" href="include/style/%s/template.css">
			<script type="text/javascript" src="include/scripts/js/ed.js"></script> 
			<script src="include/style/%s/jquery.js"></script>
			<script src="include/style/%s/bootstrap.js"></script>
			<script src="include/scripts/js/iframeResizer.contentWindow.min.js"></script>
			<script src="include/scripts/js/iframeResizer.min.js"></script>
			<script>
			
			function Redirect()
		{
			window.location="index.php";
		}
			</script>
			<script>
			iFrameResize({
				log                     : true,                  // Enable console logging
				enablePublicMethods     : true,                  // Enable methods within iframe hosted page
				resizedCallback         : function(messageData){ // Callback fn when resize is received
					$(\'p#callback\').html(
						\'<b>Frame ID:</b> \'    + messageData.iframe.id +
						\' <b>Height:</b> \'     + messageData.height +
						\' <b>Width:</b> \'      + messageData.width + 
						\' <b>Event type:</b> \' + messageData.type
					);
				}
			});
			</script>

		</head>
		<body>
			<div class="row header">
				<div class="col-md-1"></div>
   <div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">%s</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
										
		',
	'header-end'=>'
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
				<div class="col-md-1"></div>
			</div>
			<div class="row content">	
			',
	'blogViewFormat'=>'
		<div class="shadowbar">
		<h3>%s</h3>
		<div class="row">
		<div class="col-md-12">
		<img style="max-height:100px;" class="img-square" src="include/images/profile/%s" /> By <a href="index.php?action=ucp&uid=%s">%s</a> On <a href="">%s</a>
		<hr />
		</div>
		<div class="col-md-10">
		%s
		</div>
		<div class="col-md-10" style="font-size:7pt;">
		<hr />
		%s
		</div>
		</div>
		</div>
		',
	'postBlogFormat'=>'
		<form enctype="multipart/form-data" method="post" action="index.php?action=Blog&mode=postblog"> 
		<fieldset>
		<legend>Blog Article:</legend>
			<label type="hidden" for="title">Title:</label><br />
			<input type="text" name="title"><br /><br />
			<label type="hidden" for="post1">Blog Content:</label><br />
		<script>edToolbar(\'bbcodeEditor\'); </script>
		<textarea name="post1" id="bbcodeEditor" style="height:300px;width:100%;"></textarea><br />
		<label type="hidden" for="id">Display</label>
		<select id="display" name="display">
			<option value="0">Hidden</option>
			<option value="1">Displayed</option>
		</select>
		</fieldset>
		<input type="submit" value="Save Post" name="submit" />     
		</form>
		',
	'footer'=>'
		</div>
	</div>
	<div class="row footer">
		<div class="col-md-12">
			<div class="bottom-right">
				Template designed by <a href="http://cheesecakebb.org/">Cheesecake Productions</a>
			</div>
			<div class="col-md-5">
			Copyright <a href="http://%s">%s</a> - All Rights Reserved<br>
			</div>
			<div class="col-md-4">
			Cheesecake Core Version: %s
			</div>
		</div>
	</div>
	',
	'login'=>'
	<div class="shadowbar"><form method="post" action="index.php?action=login">

    <fieldset>

     <legend>Log In</legend>
	<div class="input-group">
      <span class="input-group-addon">E-Mail</span>

      <input type="text" class="form-control" name="email" value="" /><br />
	</div>
	<div class="input-group">
      <span class="input-group-addon">Password</span>

      <input type="password" class="form-control" name="password" />
	  </div>

    </fieldset>

    <input type="submit"  class="btn btn-primary" value="Log In" name="submit" />

	</form></div>',
	
	'adminPostLayout'=>'
		  <table class="table">
			<tr><td>Title: %s<a class="Link LButton" href="index.php?action=markAs&p=%s">Mark As...</a></td></tr>
		  <tr><td><div class="col-md-8"><pre>Post:<br/><br />%s</pre></div></td></tr>
			<tr><td>Post ID: %s<a class="Link LButton" href="index.php?action=%s&mode=%s&del=%s">Delete Post</a></td></tr>
			<tr><td>Display Status: %s<a class="Link LButton" href="index.php?action=%s&mode=hide&del=%s">Hide Post</a><a class="Link LButton" href="index.php?action=%s&mode=unhide&del=%s">Unhide Post</a></td></tr>
		  <tr><td>UserName: %s</td></tr>
		  <tr><td>Rank: %s</td></tr>
		</table>
	',
	'adminReplyLayout'=>'
		  <table class="table">
			<tr><td>Title: %s</td></tr>
		  <tr><td><div class="col-md-8"><pre>Post:<br/><br />%s</pre></div></td></tr>
			<tr><td>Post ID: %s<a class="Link LButton" href="index.php?action=%s&mode=%s&del=%s">Delete Post</a></td></tr>
			<tr><td>Display Status: %s<a class="Link LButton" href="index.php?action=%s&mode=hide&del=%s">Hide Post</a><a class="Link LButton" href="index.php?action=%s&mode=unhide&del=%s">Unhide Post</a></td></tr>
		  <tr><td>UserName: %s</td></tr>
		  <tr><td>Rank: %s</td></tr>
		</table>
	',
	'adminBar'=>'
	<div class="shadowbar">
		<a class="text-center" href="%s">%s Admin</a>
	</div>
	',
	'adminPageEditLayout'=>'
	<form enctype="multipart/form-data" method="post" action="index.php?action=pages&mode=edit"> 
		<fieldset>
		<legend>Edit Page</legend>
		<label type="hidden" for="post1">Page Body:</label><br />
		<textarea rows="8"  name="content" id="post1" cols="100">%s</textarea><br />
		<input type="hidden" value="%s" name="page" />
		<input type="submit" value="Save Post" name="submit" />
		</fieldset>     
		</form>
	',
	'adminPageAddLayout'=>'
<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=pages&mode=addpage"> 
		<fieldset>
		<legend>New Page</legend>
			<label type="hidden" for="title">Title:</label><br />
			<input type="text" name="title"><br /><br />
		<label type="hidden" for="post1">Page Body:</label><br />
		<script>edToolbar(\'bbcodeEditor\'); </script>
		<textarea name="page" id="bbcodeEditor" style="height:300px;width:100%;"></textarea><br />
		</fieldset>
		<input type="submit" value="Save Post" name="submit" />     
		</form>
		</div>
	',
	'adminDeleteLayout'=>'
	<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=Blog&mode=%s">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>
		<input type="hidden" name="postid" value="%s">
		</fieldset>
		<input type="submit" value="Yes" name="submit" />   <a class="button" href="index.php?action=Blog&mode=admin">Cancel</a> 
	</form>
	</div>
	',
	'adminUserLayout'=>'
		  <table class="table">
			<tr><td>Username: %s<td></tr>
			<tr><td>User ID: %s<a class="Link LButton" href="index.php?action=acp&mode=deleteuser&del=%s"> Delete User</a></td></tr>
		  <tr><td>Activation Status: %s<a href="index.php?action=verifyaccount&hash=%s"> Activate User</a></td></tr>
		  <tr><td>Admin Level: %s<a href="index.php?action=acp&mode=editperms&r=%s"> Edit Perms</a></td></tr>
		</table><hr> 
	',
	'pollChoices' =>'
		<li class="list-group-item"><a href="index.php?action=pollvote&poll=%s&choice=%s">%s</a></li>
	'
);



$postBlogFormat = 
'
		<form enctype="multipart/form-data" method="post" action="index.php?action=pb"> 
		<fieldset>
		<legend>Blog Article:</legend>
			<label type="hidden" for="title">Title:</label><br />
			<input type="text" name="title"><br /><br />
			<label type="hidden" for="post1">News Content:</label><br />
		<textarea rows="4"  name="post1" id="post1" cols="50"></textarea><br />
		<label type="hidden" for="id">Display</label>
		<select id="display" name="display">
			<option value="0">Hidden</option>
			<option value="1">Displayed</option>
		</select>
		</fieldset>
		<input type="submit" value="Save Post" name="submit" />     
		</form>
';
function sidebar() {
global $dbc, $core;
	echo '
		<div class="col-md-3">
			<div class="shadowbar">';
				// Generate the navigation menu
				if (isset($_SESSION['uid'])) {
				$query = "SELECT * FROM users WHERE `uid` = ".$_SESSION['uid']."";
				$data = mysqli_query($dbc, $query);
				$row = mysqli_fetch_array($data);
				echo '
				
				<h3>'.$row['username'].'</h3>
				<img style="max-height:120px;" class="postedBy" src="'.MM_UPLOADPATH.''.$row['picture'].'">
				<div class="btn-group-vertical width100">';
				$uid = $_SESSION['uid'];
					echo ' <a class="btn btn-default width100" href="index.php?action=ucp">View Profile</a>';
					echo ' <a class="btn btn-default width100" href="index.php?action=messages">Messages</a>';
					echo ' <a class="btn btn-default width100" href="index.php?action=sendmessage">Send Message</a>';
					echo ' <a class="btn btn-default width100" href="index.php?action=logout">Log Out (' . $row['username'] . ')</a> ';
					$core->loadModule("sidebar");


					if($core->verify("4")){
						echo '<a class="btn btn-default width100" href="index.php?action=acp">Admin Panel</a>';
						}

					if($core->verify("4") || $core->verify("2")){
						//echo '<a class="btn btn-default width100" href="index.php?action=mcp">Blog Entry</a>';
						$core->loadModule("acp");
					}
					echo '</div>';
				}
				else {
					echo ' <a class="btn btn-default width100" href="index.php?action=login">Log In</a> ';
					echo ' <a class="btn btn-default width100" href="index.php?action=signup">Signup</a> ';
				}
				echo'
			</div>
			<div class="shadowbar">';
			if(isset($_SESSION['uid'])){
				$time = time();
				$query = "UPDATE users SET `active` = '$time' WHERE `uid` = ".$_SESSION['uid']."";
				mysqli_query($dbc, $query);	
				}
				echo '
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
				  <h4 class="panel-title">
				  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
				  Online Users
				  </a>
				  </h4>
				  </div>
				      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">';
				$query = "SELECT * FROM users";
				$data = mysqli_query($dbc, $query);
				while ($row = mysqli_fetch_array($data)){
				if(time() - 300 < $row['active']){
				echo '<a href="index.php?action=ucp&uid='.$row['uid'].'">'.$row['username'].'</a>, ';
				}
				}
				echo '<br /><small>This list updates every five minutes</small>';
			echo'
			</div>
			</div>
			</div>
			
		</div>
		</div>';
		if(isset($_SESSION['uid'])){
		echo'<div class="shadowbar">';
			if(isset($_GET['mode']) && ($_GET['mode'] == 'markasread')){
				$query = "UPDATE notifications SET `read` = '1' WHERE `user` = ".$_SESSION['uid']." ";
				$data = mysqli_query($dbc, $query);
				echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>Marked as read</div>';
				}
			if(isset($_GET['mode']) && ($_GET['mode'] == 'markasunread')){
				$query = "UPDATE notifications SET `read` = '0' WHERE `user` = ".$_SESSION['uid']." ";
				$data = mysqli_query($dbc, $query);
				echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>Marked as unread</div>';
				}
			echo '			<div class="panel-group" id="notifAccordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="notifOne">
				  <h4 class="panel-title">
				  <a data-toggle="collapse" data-parent="#notifAccordion" href="#notifCollapse" aria-expanded="false" aria-controls="notifCollapse">
				  Notifications
				  </a>
				  </h4>
				  </div>
				      <div id="notifCollapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="notifOne">
      <div class="panel-body"><div role="tabpanel">

  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#unread" aria-controls="home" role="tab" data-toggle="tab">Unread</a></li>
    <li role="presentation"><a href="#read" aria-controls="profile" role="tab" data-toggle="tab">Read</a></li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="unread">';
				$query = "SELECT * FROM notifications WHERE `user` = '" .$_SESSION['uid']. "' AND `read` = 0";
				$data = mysqli_query($dbc, $query);
				if(mysqli_num_rows($data) > 0){
				echo '<a href="index.php?mode=markasread">Mark all as read</a><br />';
				echo '<ul class="list-group">';
				while($row = mysqli_fetch_array($data)){
					echo '
					<li class="list-group-item"><a href="'.$row['link'].'">'.$row['description'].'</a></li>
					';
				}
				echo '</ul>';
				} else {
				echo 'No new notifications.';
				}
			
			echo'</div>  <div role="tabpanel" class="tab-pane" id="read">';
				$query = "SELECT * FROM notifications WHERE `user` = '" .$_SESSION['uid']. "' AND `read`= 1";
				$data = mysqli_query($dbc, $query);
				if(mysqli_num_rows($data) > 0){
				echo '<a href="index.php?mode=markasunread">Mark all as unread</a>';
				echo '<ul class="list-group">';
				while($row = mysqli_fetch_array($data)){
					echo '
					<li class="list-group-item"><a href="'.$row['link'].'">'.$row['description'].'</a></li>
					';
				}
				echo '</ul>';
				} else {
				echo 'No new notifications.';
				}
			echo'</div></div></div></div></div>
			</div>
			</div></div>';		
		}
		echo '</div>
		<div class="col-md-7">';
}


?> 