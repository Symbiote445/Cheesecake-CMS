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
			<script src="include/style/%s/jquery.js"></script>
			<script src="include/style/%s/bootstrap.js"></script>
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
				<div class="col-md-3 logo">
					<img src="include/images/logo.png">
				</div>
				<div class="col-md-7">
					<div class="navbar-start">
						<div class="navbar-container">
							<nav class="navbar-inverse pad5" role="navigation">
								<div class="navbar-header">
									 <a href="index.php" class="navbar-brand">%s</a>
									</div>
								  <ul class="nav navbar-nav">
										<li><a href="index.php">Home</a></li>
										
		',
	'header-end'=>'
								  </ul>
							</nav>
						</div>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>
			<div class="grayout" style="display:none;"></div>
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
		<textarea rows="4"  name="post1" id="post1" cols="50"></textarea><br />
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
		<textarea rows="8"  name="page" id="post1" cols="100"></textarea><br />
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
		</div>
		<div class="col-md-7">';
}


?>