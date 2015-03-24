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
			<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?autoload=true&skin=sunburst"></script>			
			<script src="/include/style/%s/jquery.js"></script>
			<script src="/include/style/%s/bootstrap.js"></script>
			<script src="/include/scripts/js/iframeResizer.contentWindow.min.js"></script>
			<script src="/include/scripts/js/iframeResizer.min.js"></script>
			<script language="javascript" type="text/javascript" src="/include/scripts/codeEdit/edit_area_full.js"></script>
			<script src="/include/scripts/js/jquery.form.js"></script>
			<script src="/include/scripts/js/jquery.validate.js"></script>
<!-- Load WysiBB JS and Theme -->
<script src="http://cdn.wysibb.com/js/jquery.wysibb.min.js"></script>
<link rel="stylesheet" href="http://cdn.wysibb.com/css/default/wbbtheme.css" />

<!-- Init WysiBB BBCode editor -->
<script>
$(function() {
  $("#editor").wysibb();
})
</script>
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
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
			function Redirect()
		{
			window.location="index.php";
		}
			</script>
<style type="text/css">
#rs {
    border: 0 none white;
    overflow: hidden;
    padding: 0;
    outline: none;
    resize: none;
}
</style>
<script type="text/javascript">
var observe;
if (window.attachEvent) {
    observe = function (element, event, handler) {
        element.attachEvent('on'+event, handler);
    };
}
else {
    observe = function (element, event, handler) {
        element.addEventListener(event, handler, false);
    };
}
function init () {
    var text = document.getElementById('rs');
    function resize () {
        text.style.height = 'auto';
        text.style.height = text.scrollHeight+'px';
    }
    /* 0-timeout to get the already changed text */
    function delayedResize () {
        window.setTimeout(resize, 0);
    }
    observe(text, 'change',  resize);
    observe(text, 'cut',     delayedResize);
    observe(text, 'paste',   delayedResize);
    observe(text, 'drop',    delayedResize);
    observe(text, 'keydown', delayedResize);

    text.focus();
    text.select();
    resize();
}
</script>
		</head>
<noscript>
    <style type="text/css">
        .pagecontainer {display:none;}
    </style>
    <div class="noscriptmsg">
    Javascript is required for this site to work properly.
    </div>
</noscript>
		<body onload="init();">
		<div class="pagecontainer">
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
		<textarea name="post1" id="editor" style="height:300px;width:100%;"></textarea><br />
		<label type="hidden" for="id">Display</label>
		<select id="display" name="display">
			<option value="0">Hidden</option>
			<option value="1">Displayed</option>
		</select>
		</fieldset>
		<input type="submit" value="Save Post" name="submit" />     
		</form>
EOD
);

$layout['newsPostFormat'] = 
(
<<<EOD
		<form enctype="multipart/form-data" method="post" action="/postNews"> 
		<fieldset>
		<legend>News Article:</legend>
			<label type="hidden" for="title">Title:</label><br />
			<input type="text" name="title"><br /><br />
			<label type="hidden" for="blogPost">News Content:</label><br />
		<textarea rows="10" name="blogPost" id="editor" style="width:100%;"></textarea><br />
		<label type="hidden" for="id">Display</label>
		<select id="display" name="display">
			<option value="0">Hidden</option>
			<option value="1">Displayed</option>
		</select>
		</fieldset>
		<input type="submit" value="Save Post" name="submit" />     
		</form>
EOD
);

$layout['login'] = 
(
<<<'EOD'
	<div class="shadowbar"><form id="login" method="post" action="/doLogin">
	<div id="alert"></div>
    <fieldset>

     <legend>Log In</legend>
	<div class="input-group">
      <span class="input-group-addon">E-Mail</span>

      <input type="email" class="form-control" name="email" value="" /><br />
	</div>
	<div class="input-group">
      <span class="input-group-addon">Password</span>

      <input type="password" class="form-control" name="password" />
	  </div>

    </fieldset>

    <input type="submit"  class="btn btn-primary" value="Log In" name="submit" />

	</form></div>
	<script>
    $(function login() {
    $("#login").validate({ // initialize the plugin
        // any other options,
        onkeyup: false,
        rules: {
            email: {
                required: true,
                email: true
            },
			password: {
				required: true
			}
        }
    });

    $('#login').ajaxForm({
        beforeSend: function() {
			return $("#login").valid();
        },
				success : function(result) {
					var res = $.trim(result);
					console.log(res);
					if(res == "success"){
						window.location = "/index.php";
					}else if(res == "failure"){
						$("#alert").html("<div class='alert alert-warning'>Either you're username or password are incorrect, or you've not activated your account.</div>");
						//$("#alert").show();
					}else if(res == "banned"){
						$("#alert").html("<div class='alert alert-warning'>You are banned from this website.</div>");						
					}
			   }
    });
    }); 
</script>
EOD
);	

$layout['adminPostLayout'] = 
(
<<<EOD
		  <table class="table">
			<tr><td>Title: %s<a class="Link LButton" href="/markAs/p/%s">Mark As...</a></td></tr>
		  <tr><td><div class="col-md-8"><pre>Post:<br/><br />%s</pre></div></td></tr>
			<tr><td>Post ID: %s<a class="Link LButton" href="/%s/mode/%s/del/%s">Delete Post</a></td></tr>
			<tr><td>Display Status: %s<a class="Link LButton" href="/%s/del/%s">Hide Post</a><a class="Link LButton" href="/%s/del/%s">Unhide Post</a></td></tr>
		  <tr><td>UserName: %s</td></tr>
		  <tr><td>Rank: %s</td></tr>
		</table>
EOD
);

$layout['adminBlogPostLayout'] = 
(
<<<EOD
		  <table class="table">
		  <tr><td><div class="col-md-8"><pre>Post:<br/><br />%s</pre></div></td></tr>
			<tr><td>Post ID: %s<a class="Link LButton" href="/%s/mode/%s/del/%s">Delete Post</a></td></tr>
			<tr><td>Hidden Status: %s<a class="Link LButton" href="/%s/mode/hide/del/%s">Hide Post</a><a class="Link LButton" href="/%s/mode/unhide/del/%s">Unhide Post</a></td></tr>
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
$layout['userGroupsAdmin'] = 
(
<<<EOD
<div class="shadowbar">
		  <table class="table">
			<tr><td>Group Name: %s</td></tr>
			<tr><td>Group Perms: %s</td></tr>
			<tr><td>Group ID: %s</td></tr>
			<tr><td>Options: <a class="Link LButton" href="/acp/mode/deleteGroup/g/%s">Delete Group</a><a class="Link LButton" href="/acp/mode/editGroupInfo/g/%s">Edit Group</a></td></tr>
		</table>
	</div>
EOD
);
$layout['addGroup'] = 
(
<<<EOD
<div class="shadowbar">
<form method="post" action="/acp/mode/groups">
<label>Group Name</label>
<input type="text" name="groupName">
<label>Group Perms</label>
<input type="text" name="groupPerms">
<input class="Link LButton" type="submit" name="submit" value="Save Group">
</form>
</div>
EOD
);

$layout['groupEditLayout'] = 
(
<<<EOD
<div class="shadowbar">
<form method="post" action="/acp/mode/editGroupInfo">
<label>Group Name</label>
<input type="text" name="gName" value="%s">
<label>Group Perms</label>
<input type="text" name="perms" value="%s">
<input type="hidden" name="gID" value="%s">
<input class="Link LButton" type="submit" name="submit" value="Save Group">
</form>
</div>
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
		<textarea name="page" id="editor" style="height:300px;width:100%;"></textarea><br />
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

$layout['adminNewsDeleteLayout'] = 
(
<<<EOD

	<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="/news/mode/%s">
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
		  <tr><td>Group: %s<a href="/acp/mode/editgroup/r/%s"> Edit Group</a></td></tr>
		  <tr><td><a class="Link LButton" href="/acp/mode/banaccount/u/%s">Ban User's Account</a><a class="Link LButton" href="/acp/mode/banip/u/%s">Ban User by IP</a></td></tr>
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
		<textarea rows="8"  name="content" id="editor" cols="100">%s</textarea><br />
		<input type="hidden" value="%s" name="page" />
		<input type="submit" value="Save Post" name="submit" />
		</fieldset>     
		</form>
EOD
);
$layout['dlListBegin'] = 
(
<<<EOD
<div class="shadowbar">
	<table class="table table-bordered">
		<thead>
			<th>File</th>
			<th>Description</th>
		</thead>
		<tbody>
EOD
);
$layout['dlListEnd'] = 
(
<<<EOD
		</tbody>
	</table>
</div>
EOD
);

$layout['dlListMid'] = 
(
<<<EOD
			<tr>
			<td><a href="include/files/%s"><span class="glyphicon glyphicon-file"></span>%s</a></td>
			<td>%s</td>
			</tr>
EOD
);

$layout['signupEmail'] = 
(
<<<EOD
Thanks for signing up at %s
Your account has been created, however you must activate your account. Your username and password are below, and the link you need to click is below that.
------------------------
Username: %s
Password: %s
------------------------
Please click this link to activate your account:
http://%s/verifyaccount/hash/%s
EOD
);

$layout['moduleTemplate'] = 
(
<<<'EOD'
<?php
//Module Name
//Author: Your Name
//Dist: Cheesecake CMS

$myClass = new myClass;

if(isset($_GET['action'])){
	if($_GET['action'] == 'something'){
		$myClass->func("I'm a module created with the built-in module creator. The second argument value is:");
	} 
}

class myClass {
	public function func($arg1, $arg2 = NULL){
		echo '<div class="shadowbar">' . $arg1 . $arg2 . '</div>';
	}
}
?>
EOD
);

$layout['moduleAddForm'] = 
(
<<<EOD
<div class="shadowbar">
<form method="post" action="/acp/mode/addmodule">
<label>Module Name</label><br />
<input type="text" name="mName">
<label>Module File</label>
<input type=text" name="mFile">
<input class="Link LButton" name="submit" type="submit" value="Create Module">
</form>
</div>
EOD
);
?> 