<?php
$layout = array();

$layout['header-begin'] = 
(
<<<EOD
		<!DOCTYPE html>
		<html><head>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
			<title>%s</title>
			<link rel="stylesheet" type="text/css" href="/include/style/%s/style.css">
			<link rel="stylesheet" type="text/css" href="/include/style/%s/template.css">
			<script type="text/javascript" src="/include/scripts/js/ed.js"></script> 
			<script src="/include/style/%s/jquery.js"></script>
			<script src="/include/style/%s/bootstrap.js"></script>
			<script src="/include/scripts/js/iframeResizer.contentWindow.min.js"></script>
			<script src="/include/scripts/js/iframeResizer.min.js"></script>
			<script language="javascript" type="text/javascript" src="/include/scripts/codeEdit/edit_area_full.js"></script>
			<script language="javascript" type="text/javascript">
			editAreaLoader.init({
				id : "codeEdit"		// textarea id
				,syntax: "php"			// syntax to be uses for highgliting
				,start_highlight: true		// to display with highlight mode on start-up
		                ,toolbar: "search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help"
			        ,syntax_selection_allow: "css,html,js,php,python,vb,xml,c,cpp,sql,basic,pas,brainfuck"
			});
			</script>
			<script>
			
			function Redirect()
		{
			window.location="index.php";
		}
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
                <li><a href="/index.php">Home</a></li>
EOD
);									

$layout['header-end'] = 
(
<<<EOD
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
				<div class="col-md-1"></div>
			</div>
			<div class="row content">	
EOD
);

$layout['blogViewFormat'] = 
(
<<<EOD
		<div class="shadowbar">
		<h3>%s</h3>
		<div class="row">
		<div class="col-md-12">
		<img style="max-height:100px;" class="img-square" src="/include/images/profile/%s" /> By <a href="/ucp/uid/%s">%s</a> On <a href="">%s</a>
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
EOD
);

$layout['blogPostFormat'] = 
(
<<<EOD
		<form enctype="multipart/form-data" method="post" action="/Blog/mode/postblog"> 
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
			Cheesecake CMS Version: %s
			</div>
		</div>
	</div>
EOD
);

$layout['login'] = 
(
<<<EOD
	<div class="shadowbar"><form method="post" action="/doLogin">

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

	</form></div>
EOD
);	

$layout['adminPostLayout'] = 
(
<<<EOD
		  <table class="table">
			<tr><td>Title: %s<a class="Link LButton" href="/markAs/p/%s">Mark As...</a></td></tr>
		  <tr><td><div class="col-md-8"><pre>Post:<br/><br />%s</pre></div></td></tr>
			<tr><td>Post ID: %s<a class="Link LButton" href="/%s/mode/%s/del/%s">Delete Post</a></td></tr>
			<tr><td>Display Status: %s<a class="Link LButton" href="/%s/mode/hide/del/%s">Hide Post</a><a class="Link LButton" href="index.php?action=%s&mode=unhide&del=%s">Unhide Post</a></td></tr>
		  <tr><td>UserName: %s</td></tr>
		  <tr><td>Rank: %s</td></tr>
		</table>
EOD
);

$layout['adminReplyLayout'] = 
(
<<<EOD
		  <table class="table">
			<tr><td>Title: %s</td></tr>
		  <tr><td><div class="col-md-8"><pre>Post:<br/><br />%s</pre></div></td></tr>
			<tr><td>Post ID: %s<a class="Link LButton" href="/%s/mode/%s/del/%s">Delete Post</a></td></tr>
			<tr><td>Display Status: %s<a class="Link LButton" href="/%s/mode/hide/del/%s">Hide Post</a><a class="Link LButton" href="index.php?action=%s&mode=unhide&del=%s">Unhide Post</a></td></tr>
		  <tr><td>UserName: %s</td></tr>
		  <tr><td>Rank: %s</td></tr>
		</table>
EOD
);

$layout['adminPageAddLayout'] = 
(
<<<EOD

<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="/pages/mode/addpage"> 
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
EOD
);

$layout['adminDeleteLayout'] = 
(
<<<EOD

	<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="/Blog/mode/%s">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>
		<input type="hidden" name="postid" value="%s">
		</fieldset>
		<input type="submit" value="Yes" name="submit" />   <a class="button" href="/Blog/mode/admin">Cancel</a> 
	</form>
	</div>
EOD
);

$layout['adminUserLayout'] = 
(
<<<EOD

		  <table class="table">
			<tr><td>Username: %s<td></tr>
			<tr><td>User ID: %s<a class="Link LButton" href="/acp/mode/deleteuser/del/%s"> Delete User</a></td></tr>
		  <tr><td>Activation Status: %s<a href="/verifyaccount/hash/%s"> Activate User</a></td></tr>
		  <tr><td>Admin Level: %s<a href="/acp/mode/editperms/r/%s"> Edit Perms</a></td></tr>
		</table><hr> 
EOD
);

$layout['pollChoices'] = 
(
<<<EOD

		<li class="list-group-item"><a href="/pollvote/poll/%s/choice/%s">%s</a></li>
EOD
);

$layout['sidebarBegin'] = 
(
<<<EOD
<div class="col-md-3">
	<div class="shadowbar">
EOD
);

$layout['sidebar-core'] = 
(
<<<EOD
<h3>%s</h3>
<img style="max-height:120px;" class="postedBy" src="/include/images/profile/%s">
<div class="btn-group-vertical width100">
	<a class="btn btn-default width100" href="/ucp">View Profile</a>
	<a class="btn btn-default width100" href="/messages">Messages</a>
	<a class="btn btn-default width100" href="/sendmessage">Send Message</a>
	<a class="btn btn-default width100" href="/logout">Log Out (%s)</a>
EOD
);

$layout['sidebarLink'] = 
(
<<<EOD
<a class="btn btn-default width100" href="%s">%s</a>
EOD
);

$layout['sidebarMid'] = 
(
<<<EOD
</div>
<div class="shadowbar">
EOD
);

$layout['onlineUsersPanel'] = 
(
<<<EOD
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
				  <div class="panel-body">
EOD
);

$layout['onlineUsersEnd'] = 
(
<<<EOD
<br /><small>This list updates every five minutes</small>
			</div>
			</div>
			</div>
			</div>

EOD
);

$layout['sidebarNotif'] = 
(
<<<EOD
<div class="panel-group" id="notifAccordion" role="tablist" aria-multiselectable="true">
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
    <div role="tabpanel" class="tab-pane active" id="unread">
EOD
);

$layout['notifEnd'] = 
(
<<<EOD
</div></div></div></div></div>
			</div>
			</div>
			</div>
			</div>
EOD
);

$layout['sidebarEnd'] = 
(
<<<EOD
</div>
</div>
<div class="col-md-6">
EOD
);

$layout['footer'] = 
(
<<<EOD
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
			Cheesecake CMS Version: %s
			</div>
		</div>
	</div>
EOD
);

$layout['adminBar'] = 
(
<<<EOD
	<div class="shadowbar">
		<a class="text-center" href="%s">%s Admin</a>
	</div>
EOD
);

$layout['adminPageEditLayout'] = 
(
<<<EOD
	<form enctype="multipart/form-data" method="post" action="/pages/mode/edit"> 
		<fieldset>
		<legend>Edit Page</legend>
		<label type="hidden" for="post1">Page Body:</label><br />
		<textarea rows="8"  name="content" id="post1" cols="100">%s</textarea><br />
		<input type="hidden" value="%s" name="page" />
		<input type="submit" value="Save Post" name="submit" />
		</fieldset>     
		</form>
EOD
);
?> 