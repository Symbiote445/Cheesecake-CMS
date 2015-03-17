<?php
/*
CheesecakeCore
*/

//error_reporting(E_ALL);
if(!defined("CCore")){
	die("Access Denied.");
}
class admin {
	public function array2php($arr, $arrName){
		$out = '<?php $'.$arrName.' = array(';
		foreach( $arr as $k => $v ){
			if( is_bool($v) ){
				$v = ( $v ) ? 'true' : 'false';
			}
			else{
				$v = "\"".$v."\"";
			}
			$out .= " \"".$k."\" => ".$v.",";
		}
		$out = rtrim($out, ",");
		$out .= ' ); ?>';

		return $out;
	}
	public function counter(){
		global $dbc, $core;
		$core->isLoggedIn();
		$query = "SELECT * FROM `views`";
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);
		$C = count($row);
		$uC = array_unique($row);
		$uCL = count($uC);
		echo '
		<div class="shadowbar">
		<table class="table">
		<thead><th>View Counter</th></thead>
		<tr><td>View Count:</td><td>'.$C.'</td></tr>
		<tr><td>Unique View Count:</td><td>'.$uCL.'</td></tr>
		</table>
		</div>
		';
	}
	public function groupEdit(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		if(isset($_POST['submit'])){
			$groupID = mysqli_real_escape_string($dbc, trim($_POST['gID']));
			$perms = mysqli_real_escape_string($dbc, trim($_POST['perms']));
			$gName = mysqli_real_escape_string($dbc, trim($_POST['gName']));
			$query = "UPDATE `groups` SET `groupName` = '$gName', `groupPerms` = '$perms' WHERE `groupID` = '$groupID' ";
			mysqli_query($dbc, $query);
			echo '<div class="shadowbar">Group Updated</div>';
			exit();
		}
		$gID = mysqli_real_escape_string($dbc, trim($_GET['g']));
		$secureGroup = preg_replace("/[^0-9]/", "", $gID);
		$query = "SELECT * FROM `groups` WHERE `groupID` = '$secureGroup' ";
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);
		echo sprintf($layout['groupEditLayout'], $row['groupName'], $row['groupPerms'], $secureGroup);
	}
	public function groups(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		if(!$core->verify("core.*")){
			die('Insignificant Permission');
		}
		if(isset($_POST['submit'])){
		$gName = mysqli_real_escape_string($dbc, trim($_POST['groupName']));
		$gPerms = mysqli_real_escape_string($dbc, trim($_POST['groupPerms']));
		$query = "INSERT INTO groups (`groupName`, `groupPerms`) VALUES ('$gName', '$gPerms')";
		$data = mysqli_query($dbc, $query);
		echo '<div class="shadowbar">Group Added</div>';
		}
		if(isset($_GET['mode'])){
		if($_GET['mode'] == 'deleteGroup'){
		$gID = mysqli_real_escape_string($dbc, trim($_GET['g']));
		$query = "DELETE FROM groups WHERE groupID = '$gID' ";
		$data = mysqli_query($dbc, $query);
		}
		}
		print ($layout['addGroup']);
		$query = "SELECT * FROM groups";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)){
			echo sprintf($layout['userGroupsAdmin'], $row['groupName'], $row['groupPerms'], $row['groupID'], $row['groupID'], $row['groupID']);
		}
	}
	public function delu(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		if(!$core->verify("core.*")){
			exit();
		}
		$core->isLoggedIn();
		if (isset($_POST['submit'])) {
			$userid = mysqli_real_escape_string($dbc, trim($_POST['userid']));
			if (!empty($userid)) {
				$query = "DELETE FROM users WHERE uid = $userid";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>User has been successfully deleted. Would you like to <a href="/acp/mode/users">go back to the admin panel</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<div class="shadowbar"><p class="error">You must enter information into all of the fields.</p></div>';
			}
		} 
		
		if($_GET['del'] = $_SESSION['uid']){
			die('<div class="shadowbar">Cannot delete yourself.</div>');
		}		
		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="/acp/mode/deleteuser">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>
			<input type="hidden" name="userid" value="'.$_GET['del'].'">';
		echo 'User ID: ' . $_GET['del'] . '<br /> <br />';
		echo'</fieldset>
		<input type="submit" value="Delete User" name="submit" />    <a class="button" href="/acp">Cancel</a> 
	</form>
	</div>';
	}
	public function eur(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		$core->isLoggedIn();
		if (isset($_POST['submit'])) {
			$user = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['user'])));
			$perm = mysqli_real_escape_string($dbc, trim($_POST['perm']));
			if (!empty($perm) && !empty($user)) {
				$query = "UPDATE `users` SET `adminlevel` = '$perm' WHERE `uid` = '$user'";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>User has been successfully edited. Would you like to <a href="/acp">return to the ACP</a>?</p></a>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}

		}
		if(!$core->verify("core.*")){
			exit();

		}
		echo'<div class="shadowbar"><table class="table">
		<tr>
		<th>Perms:</th>
		<th>Description of Permission:</th>
		</tr>
		<tr>
		<td>4</td>
		<td>Global Admin.</td>
		</tr>
		<tr>
		<td>2</td>
		<td>Moderator</td>
		</tr>
		</table>
		</div>
	';
		

		

		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="/acp/mode/editperms">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
			<label type="hidden" for="perm">Permission:</label><br />
			<input type="rank" name="perm"><br /><br />
			<input type="hidden" name="user" value="'. $_GET['r'] .'">
		</fieldset>
		<input type="submit" value="Save User" name="submit" />     
	</form>
	</div>';
	}
	public function eug(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		$core->isLoggedIn();
		if (isset($_POST['submit'])) {
			$user = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['user'])));
			$perm = mysqli_real_escape_string($dbc, trim($_POST['perm']));
			if (!empty($perm) && !empty($user)) {
				$query = "UPDATE `users` SET `group` = '$perm' WHERE `uid` = '$user'";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>User has been successfully edited. Would you like to <a href="/acp">return to the ACP</a>?</p></a>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}

		}
		if(!$core->verify("core.*")){
			exit();

		}
		echo'<div class="shadowbar"><form method="post" action="/acp/mode/editgroup">
		<fieldset>
			<label type="hidden" for="perm">Group:</label><br />';
		echo'<select id="perm" name="perm">';
		$query = "SELECT * FROM groups";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			echo '<option value="'.$row['groupID'].'">'.$row['groupName'].'</option>';
		}
		echo'</select><br /><br />
			<input type="hidden" name="user" value="'. $_GET['r'] .'">
		</fieldset>
		<input type="submit" value="Save User" name="submit" />     
	</form>
	</div>';
	}
	public function usr() {
		global $settings, $version, $dbc, $layout, $core, $parser;
		echo '<div class="shadowbar">';
		if(!$core->verify("core.*")){
			exit();
		}


		// Connect to the database

		// Grab the profile data from the database
		$query = "SELECT * FROM users ORDER BY uid DESC";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			echo sprintf($layout['adminUserLayout'], $row['username'], $row['uid'], $row['uid'], $row['activated'], $row['hash'], $row['group'], $row['uid'], $row['uid'], $row['uid']);
		}
		echo '</div>';
	}
	public function acp(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		if(!$core->verify("core.*")){
			die('<div class="shadowbar">You don\'t have significant privilege</div>');
		}
		echo '<div class="shadowbar">
		<a class="Link LButton" href="/acp">Admin </a><a class="Link LButton" href="/acp/mode/users">Users </a><a class="Link LButton" href="/acp/mode/groups">Groups </a><a class="Link LButton" href="/acp/mode/banlist">Banned Users</a><a class="Link LButton" href="/acp/mode/Settings">Settings </a><a class="Link LButton" href="/acp/mode/modules">Module Settings </a><a class="Link LButton" href="/acp/mode/layout">Advanced Layout Editor</a><a class="Link LButton" href="/acp/mode/stats">Record Stats</a><a class="Link LButton" href="/acp/mode/counter">View Counter</a>';
		echo '</div>
';
		if(isset($_GET['mode'])){
			if($_GET['mode'] == 'users'){
				$this->usr();
			}
			if($_GET['mode'] == 'counter'){
				$this->counter();
			}
			if($_GET['mode'] == 'deleteuser'){
				$this->delu();
			}
			if($_GET['mode'] == 'groups'){
				$this->groups();
			}
			if($_GET['mode'] == 'deleteGroup'){
				$this->groups();
			}
			if($_GET['mode'] == 'editGroupInfo'){
				$this->groupEdit();
			}
			if($_GET['mode'] == 'editperms'){
				$this->eur();
			}
			if($_GET['mode'] == 'editgroup'){
				$this->eug();
			}
			if($_GET['mode'] == 'banaccount'){
				if(isset($_POST['submit'])){
					$core->securityAgent("banacc");
				} else {
				echo '
				<div class="shadowbar">
				<form action="/acp/mode/banaccount" method="post">
					<input type="text" name="res"  placeholder="Ban Reason"/>
					<input type="hidden" name="user" value="'.$_GET['u'].'" />
					<input type="submit" name="submit" value="Ban User" class="Link LButton" />
				</form>
				</div>
				';					
			}
			}
			if($_GET['mode'] == 'banip'){
				if(isset($_POST['submit'])){
					$core->securityAgent("banip");
				} else {
				echo '
				<div class="shadowbar">
				<form action="/acp/mode/banip" method="post">
					<input type="text" name="res"  placeholder="Ban Reason"/>
					<input type="hidden" name="user" value="'.$_GET['u'].'" />
					<input type="submit" name="submit" value="Ban User" class="Link LButton" />
				</form>
				</div>
				';					
				}
				
			}
			if($_GET['mode'] == 'unban'){
				$bID = mysqli_real_escape_string($dbc, trim($_GET['b']));
				$query = "DELETE FROM bans WHERE bID = '$bID'";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar">User Unbanned</div>';
			}
			if($_GET['mode'] == 'banlist'){
				echo '<div class="shadowbar">
				<h3>Account Bans</h3>
					<table class="table">
					<thead>
					<th>User</th>
					<th>Ban Reason</th>
					<th>Options</th>
					</thead>
					<tbody>				
				';
				$query = "SELECT users.*, bans.* FROM `bans` JOIN users on users.username = bans.user";
				$data = mysqli_query($dbc, $query);
				while($row = mysqli_fetch_array($data)){
					echo '
					<tr><td>'.$row['username'].'</td><td>'.$row['reason'].'</td><td><a href="/acp/mode/unban/b/'.$row['bID'].'">Unban User</a></td></tr>
					';
				}
				if(mysqli_num_rows($data) < 1){
					echo '<tr><td>No user accounts banned.</td></tr>';
				}
				echo '</tbody>
					</table></div>';
				echo '<div class="shadowbar">
				<h3>IP Bans</h3>
					<table class="table">
					<thead>
					<th>User</th>
					<th>Ban Reason</th>
					<th>Options</th>
					</thead>
					<tbody>				
				';
				$query = "SELECT users.*, bans.* FROM `bans` JOIN users on users.ip = bans.user";
				$data = mysqli_query($dbc, $query);
				while($row = mysqli_fetch_array($data)){
					echo '
					<tr><td>'.$row['username'].' IP: '.$row['user'].'</td><td>'.$row['reason'].'</td><td><a href="/acp/mode/unban/b/'.$row['bID'].'">Unban User</a></td></tr>
					';
				}
				if(mysqli_num_rows($data) < 1){
					echo '<tr><td>No users banned by IP.</td></tr>';
				}
				echo '</tbody>
					</table></div>';
			}
			if($_GET['mode'] == 'layout'){
				if(isset($_POST['submit'])){
					$layoutSettings = $_POST['layout'];
					file_put_contents("include/scripts/layout.php", $layoutSettings);
					echo '<div class="shadowbar">Layout file updated</div>';
				}
				$layoutFile = file_get_contents("include/scripts/layout.php");
				$layoutFile = htmlspecialchars($layoutFile);
echo (
<<<EOD
<div class="shadowbar">
		<form method="post" action="/acp/mode/layout">
		<fieldset>
		<legend>Advanced Layout Editor</legend>
		<div class="input-group" style="width:100%;">
		<textarea id="codeEdit" rows=50 placeholder="Layout File" name="layout" style="width:100%;">$layoutFile</textarea><br />
		</div>
		</fieldset>
		<input class="Link LButton" type="submit" value="Submit Edits" name="submit" />
	</form>
	</div>
EOD
);				
			}
			if($_GET['mode'] == 'modules'){
				if(isset($_POST['submit'])){
					$moduleSettings = $_POST['modules'];
					file_put_contents("modules.php", $moduleSettings);
					echo '<div class="shadowbar">Module settings updated</div>';
				}
				$moduleFile = file_get_contents("modules.php");
				echo '
<div class="shadowbar">
		<form method="post" action="/acp/mode/modules">
		<fieldset>
		<legend>Module Settings</legend>
		<div class="input-group" style="width:100%">
		<textarea style="width:100%" placeholder="Module Settings" name="modules" id="codeEdit" rows="50">'.$moduleFile.'</textarea><br />
		</div>
		</fieldset>
		<input class="Link LButton" type="submit" value="Submit Edits" name="submit" />
	</form>
	</div>
				';
			}
			if(($_GET['mode'] === 'Settings')){
				if(isset($_POST['submit'])){
					$mySettingsFile = 'include/scripts/settings.php';
					$home = $_POST['homepage'];
					$name = $_POST['name'];
					$burl = $_POST['url'];
					$bemail = $_POST['email'];
					$about = $_POST['about'];
					$signup = $_POST['signup'];
					$style = $_POST['style'];
					$db = $settings['db'];
					$pass = $settings['db_password'];
					$user = $settings['db_user'];
					$about = str_replace("'", "", $about);
					$about = str_replace('"', "", $about);
					
					$newSettings = array (         // the default settings array
					'home_display'=>''.$home.'',
					'style'=>''.$style.'',
					'db_host'=>'localhost',
					'db_user'=>''.$user.'',
					'db_password'=>''.$pass.'',
					'db'=>''.$db.'',
					'login_enabled'=>true,
					'signup_enabled'=>''.$signup.'',
					'site_name'=>''.$name.'',
					'b_url'=>''.$burl.'',
					'b_email'=>''.$bemail.'',
					'board_enabled'=>false,
					'about' => "".$about.""
					);
					$end = '<?php $dbc=mysqli_connect($settings[\'db_host\'],$settings[\'db_user\'],$settings[\'db_password\'],$settings[\'db\']); ?>';
					file_put_contents($mySettingsFile, $this->array2php($newSettings, "settings"));
					file_put_contents($mySettingsFile, $end, FILE_APPEND | LOCK_EX );

					echo '<div class="shadowbar"><div class="alert alert-success">Settings Edited</div></div>';
				}
				global $settings;
				
				echo'<div class="shadowbar"><div class="alert alert-info">Please refer to the documentation <a href="http://cheesecakebb.org/index.php?action=pages&page=Settings">Here</a> for settings</div>
		<form method="post" action="/acp/mode/Settings">
		<fieldset>
		<legend>Settings</legend>
		<div class="input-group">
		<span class="input-group-addon">Home Page Display</span>
		<input class="form-control" type="text" name="homepage" value="'.$settings['home_display'].'" />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Website Style</span>
		<input class="form-control" type="text" name="style" value="'.$settings['style'].'" />
		</div>
		<div class="input-group">
		<span class="input-group-addon">DB Host</span>
		<input class="form-control" type="text" name="dbhost" value="'.$settings['db_host'].'" disabled />
		</div>
		<div class="input-group">
		<span class="input-group-addon">DB User</span>
		<input class="form-control" type="text" name="dbuser" value="'.$settings['db_user'].'" disabled />
		</div>
		<div class="input-group">
		<span class="input-group-addon">DB Password</span>
		<input class="form-control" type="password" name="dbpass" value="passworddbdb" disabled />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Database</span>
		<input class="form-control" type="text"  name="db" value="'.$settings['db'].'" disabled />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site Name</span>
		<input class="form-control" type="text" name="name" value="'.$settings['site_name'].'" />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site URL</span>
		<input class="form-control" type="text" name="url" value="'.$settings['b_url'].'" />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site Email</span>
		<input class="form-control" type="text" name="email" value="'.$settings['b_email'].'" />
		</div>
		<div class="input-group">
		<textarea rows="8" placeholder="about" name="about" id="about" cols="100">'.$settings['about'].'</textarea><br />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Signup Settings</span>
		<select name="signup" >
		<option value="true">Enabled</option>
		<option value="false">Disabled</option>>
		</select> 
		</div>


		</fieldset>
		<input class="Link LButton" type="submit" value="Submit Edits" name="submit" />
	</form>
	</div>';
				
				
			}
			if($_GET['mode'] == 'stats'){
				$this->stats();
			}
		}

		if(!isset($_GET['mode'])){
			global $version;
			$localVersion = $version['core'];
			$remoteVersion = 'http://cheesecakebb.org/versions/core.dat';
			if(!$core->Version($localVersion, $remoteVersion)){
				echo '<div class="shadowbar">
Your Cheesecake Core version is out of date.
</div>
';
			}
			echo '
<div class="shadowbar">
<table class="table">
<thead>
<th>Setting</th>
<th>Value</th>
</thead>
<tbody>
<tr>
<td>
Home Page Display
</td>
<td>
'.$settings['home_display'].'
</td>
</tr>
<tr>
<td>
Database Host
</td>
<td>
'.$settings['db_host'].'
</td>
</tr>
<tr>
<td>
Database
</td>
<td>
'.$settings['db'].'
</td>
</tr>

</tbody>
</table>


</div>

';
echo'
<div class="shadowbar">
<table class="table table-bordered">
<thead>
<th>Stats Files</th>
</thead>';
foreach (glob('include/*.dat') as $stats) {
	$stats = preg_replace("/(include\/)/", "", $stats);
	echo '<tr><td><a href="//'.$settings['b_url'].'/include/'.$stats.'">'.$stats.'</a></td></tr>';
}
echo '</table></div>
';
		}
	}
	public function stats() {
		global $dbc, $settings;
		$query = "SELECT * FROM users";
		$data = mysqli_query($dbc, $query);
		$ucount = mysqli_num_rows($data);
		$day = date("j");
		$month = date("M");
		$year = date("Y");
		$filename = $day . $month . $year . '.dat';
		$str = "Users: $ucount \r\n";
		file_put_contents("include/".$filename, $str);
		echo '<div class="shadowbar">Stats file can be found at '. $settings['b_url'] . '/include/' . $filename.'</div>';
		echo '<div class="shadowbar">Core stats finished...</div>';
		require("modules.php");
		foreach($modules as $name => $module) if ($module['enabled'] && $module['stats'] == 'true') {
			$module['class']::stats();
		}
	}
}
 

class core {
	public function notifBar(){
		global $layout, $dbc;
		if(isset($_SESSION['uid'])){
			echo '</div><div class="col-md-3"><div class="shadowbar">';
			if(isset($_GET['action']) && ($_GET['action'] == 'markasread')){
				$query = "UPDATE notifications SET `read` = '1' WHERE `user` = ".$_SESSION['uid']." ";
				$data = mysqli_query($dbc, $query);
				echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>Marked as read</div>';
				}
			if(isset($_GET['action']) && ($_GET['action'] == 'markasunread')){
				$query = "UPDATE notifications SET `read` = '0' WHERE `user` = ".$_SESSION['uid']." ";
				$data = mysqli_query($dbc, $query);
				echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>Marked as unread</div>';
				}
			print($layout['sidebarNotif']);
				$query = "SELECT * FROM notifications WHERE `user` = '" .$_SESSION['uid']. "' AND `read` = 0";
				$data = mysqli_query($dbc, $query);
				if(mysqli_num_rows($data) > 0){
				echo '<a href="/markasread">Mark all as read</a><br />';
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
			
			echo'</div><div role="tabpanel" class="tab-pane" id="read">';
				$query = "SELECT * FROM notifications WHERE `user` = '" .$_SESSION['uid']. "' AND `read`= 1";
				$data = mysqli_query($dbc, $query);
				if(mysqli_num_rows($data) > 0){
				echo '<a href="/markasunread">Mark all as unread</a>';
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
			print($layout['notifEnd']);	
		}
	}
	public function sidebar() {
		global $dbc, $layout;
			print($layout['sidebarBegin']);
				// Generate the navigation menu
				if (isset($_SESSION['uid'])) {
				$query = "SELECT * FROM users WHERE `uid` = ".$_SESSION['uid']."";
				$data = mysqli_query($dbc, $query);
				$row = mysqli_fetch_array($data);
				$uid = $_SESSION['uid'];
				echo sprintf($layout['sidebar-core'], $row['username'], $row['picture'], $row['username']);
					$this->loadModule("sidebar");
					if($this->verify("core.*")){
						echo sprintf($layout['sidebarLink'], "/acp", "Admin Panel");
						}
					if($this->verify("core.*") || $this->verify("core.mod")){
						$this->loadModule("acp");
					}
					echo '</div>';
				}
				else {
					echo sprintf($layout['sidebarLink'], "/login", "Log In");
					echo sprintf($layout['sidebarLink'], "/signup", "Sign Up");
				}
				print($layout['sidebarMid']);
			if(isset($_SESSION['uid'])){
				$time = time();
				$query = "UPDATE users SET `active` = '$time' WHERE `uid` = ".$_SESSION['uid']."";
				mysqli_query($dbc, $query);	
				}
				print($layout['onlineUsersPanel']);
				$query = "SELECT * FROM users";
				$data = mysqli_query($dbc, $query);
				while ($row = mysqli_fetch_array($data)){
				if(time() - 300 < $row['active']){
				echo '<a href="/ucp/uid/'.$row['uid'].'">'.$row['username'].'</a>, ';
				}
				}
				print($layout['onlineUsersEnd']);
		print($layout['sidebarEnd']);
}

	public function checkLogin(){
		if(!isset($_SESSION['uid']) && isset($_COOKIE['ID'])){
			global $dbc;
			$UID = $_COOKIE['ID'];
			$query = "SELECT * FROM `loggedin` WHERE `uid` = '$UID'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			$time = $row['time'];
			if(time() - 86400 < $time){
			if($row['uid'] == $_COOKIE['ID'] && $row['hash'] == $_COOKIE['HASH'] && $row['ip'] == $_COOKIE['IP']){
			$query = "SELECT username, ip, hash FROM users WHERE uid = '" . $_COOKIE['ID'] . "'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			if($row['ip'] == $_COOKIE['IP']){
			if($row['hash'] == $_COOKIE['HASH']){
			$_SESSION['uid'] = $_COOKIE['ID'];
			$_SESSION['username'] = $row['username'];
			}
			}
		}
		}
		}
	}
	public function Version($local, $remote){
		$remoteVersion=trim(file_get_contents($remote));
		return version_compare($local, $remoteVersion, 'ge');
	}
	public function verify($permName){
		global $dbc;
		if(isset($_SESSION['uid'])){	
			$query = "SELECT `group` FROM users WHERE uid = '" . $_SESSION['uid'] . "'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			$groupID = $row['group'];
			$query = "SELECT groupPerms FROM groups WHERE groupID = '$groupID'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			$perms = $row['groupPerms'];
			$perms = explode(";", $perms);
			if(in_array($permName, $perms)){
				return true;
			} else {
				return false;
			}
		}
	}
	
	public function ifModule($moduleName){
		
		include("modules.php");
		if($modules[$moduleName]['enabled'] === '1'){
			return true;
		} else {
			return false;
		}
	}

	public function loadModule($operator){
		if(isset($operator)){
			require("modules.php");
			$option = $operator;
			if($option === 'nav'){
				foreach($modules as $name => $module) if ($module['enabled']) {
					echo '<li><a href="'.$module['href'].'">'.$module['description'].'</a></li>';
				}
			}
			if($option === 'initialLoad'){
				foreach($modules as $name => $module) if ($module['enabled']) {
					require_once('include/scripts/'.$module['link']);
				}
			}
			if($option === 'sidebar'){
				foreach($modules as $name => $module) if ($module['enabled'] && ($module['admin'] == '0')) {
					echo '<a class="btn btn-default width100" href="'.$module['sidebar'].'">'.$module['sidebarDesc'].'</a>';
				}
			}
			if($option === 'acp'){
				foreach($modules as $name => $module) if ($module['enabled'] && ($module['admin'] == '1')) {
					if($this->verify("core.*") ||  $this->verify($module['perms']))
					echo '<a class="btn btn-default width100" href="'.$module['acp'].'">'.$module['sidebarDesc'].'</a>';
				}
			}
		}
	}
	public function logout(){
	global $settings;
		session_destroy();
		unset($_COOKIE['ID']);
		setcookie('ID', "", time()-86400, "/");
		setcookie('IP', "", time()-86400, "/");
		setcookie('HASH', "", time()-86400, "/");
		//setcookie('user_id', "", time()-10, "/");
		echo '
			<script>
			
			function Redirect()
		{
			window.location="index.php";
		}
			</script>		
		<script>Redirect();</script>';
		}
	public function isLoggedIn(){
		echo '<div class="shadowbar">';
		if (!isset($_SESSION['uid'])) {
			echo '<p class="login">Please <a href="/login">log in</a> to access this page.</p>';
			exit();
		}
		else {
			echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '. <a href="/logout">Log out</a>.</p>');
		}
		echo '</div>';
	}
	public function deactivateAndReset(){
	global $dbc, $settings;
	$user = $_SESSION['uid'];
	$query = "UPDATE users SET activated = '0', passwordReset = '1' WHERE uid = '$user' ";
	mysqli_query($dbc, $query);
	echo '<div class="shadowbar">Your password has ben set the the "reset" state and your account deactivated. Once you have re-activated your account you will have to reset your password. (Check your email and be sure to check spam)</div>';
	$query = "SELECT email, hash FROM users WHERE uid = '$user' ";
	$data = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($data);
	$burl = $settings['b_url'];
	$hash = $row['hash'];
	$email = $row['email'];
	$site = $settings['site_name'];
					$to      = $email; // Send email to our user
					$subject = $settings['site_name']; // Give the email a subject
					$message = '	
			You have submitted a password reset request at '.$settings['site_name'].'
			Your account has been deactivated and you will have to reset your password upon re-activation.
			Please click this link to activate your account:
			http://'.$burl.'/verifyaccount/hash/'.$hash.'
			If you did not request this, please click here:
			http://'.$burl.'/verifyaccount/hash/'.$hash.'/fraud/true
			'; // Our message above including the link				
					$headers = 'From:'.$site.'' . "\r\n"; // Set from headers
					mail($to, $subject, $message, $headers); // Send our email	
	}
	public function addNotification($U, $L, $D){
	global $dbc, $layout;
	$user = $U;
	$link = $L;
	$description = $D;
	$query = "INSERT INTO notifications (`user`, `description`, `link`) VALUES ('$user', '$description', '$link')";
	mysqli_query($dbc, $query);
	}
	public function securityAgent($opt, $u = null){
		global $dbc, $layout, $settings, $version;
		$O = $opt;
		if($O == 'check'){
			$IP = $_SERVER['REMOTE_ADDR'];
			$query = "SELECT * FROM `bans` WHERE `user` = '$IP' ";
			$data = mysqli_query($dbc, $query);
			$c = mysqli_num_rows($data);
			$row = mysqli_fetch_array($data);
			if($c > 0){
				echo '<div class="shadowbar">You have been banned from this website for reason: '.$row['reason'].'.</div>';
				die(sprintf($layout['footer'], $settings['b_url'], $settings['site_name'], $version['core']));
			}
		} 
		if($O == 'checkacc'){
			$query = "SELECT * FROM `bans` WHERE `user` = '$u' ";
			$data = mysqli_query($dbc, $query);
			$c = mysqli_num_rows($data);
			$row = mysqli_fetch_array($data);
			if($c > 0){
				echo 'banned';
				exit();
			}
		} 
		if($O == 'banip'){
			$reason = mysqli_real_escape_string($dbc, trim($_POST['res']));
			$user = mysqli_real_escape_string($dbc, trim($_POST['user']));
			$query = "SELECT ip FROM users WHERE uid = '$user' ";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			$user = $row['ip'];
			$query = "INSERT INTO `bans` (`user`, `reason`) VALUES ('$user', '$reason')";
			mysqli_query($dbc, $query);
			echo '<div class="shadowbar">User banned.</div>';
		}
		if($O == 'banacc'){
			$reason = mysqli_real_escape_string($dbc, trim($_POST['res']));
			$user = mysqli_real_escape_string($dbc, trim($_POST['user']));
			$query = "SELECT username FROM users WHERE uid = '$user' ";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			$user = $row['username'];
			$query = "INSERT INTO `bans` (`user`, `reason`) VALUES ('$user', '$reason')";
			mysqli_query($dbc, $query);
			echo '<div class="shadowbar">User banned.</div>';
		}
	}
	public function login() {
		global $dbc, $layout;
		if(!isset($_SESSION['uid'])){
			if(isset($_POST['submit'])){
				$username = mysqli_real_escape_string($dbc, trim($_POST['email']));
				$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
				if(!empty($username) && !empty($password)){
					$query = "SELECT uid, email, username, password, hash FROM users WHERE email = '$username' AND password = SHA('$password') AND activated = '1'";
					$data = mysqli_query($dbc, $query);
					if((mysqli_num_rows($data) === 1)){
						$row = mysqli_fetch_array($data);
						$this->securityAgent("checkacc", $row['username']);
						$_SESSION['uid'] = $row['uid'];
						$_SESSION['username'] = $row['username'];
						//$_SERVER['REMOTE_ADDR'] = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"];
						$ip = $_SERVER['REMOTE_ADDR'];
						$user = $row['uid'];
						$query = "UPDATE users SET ip = '$ip' WHERE uid = '$user' ";
						mysqli_query($dbc, $query);
						setcookie("ID", $row['uid'], time()+3600*24);
						setcookie("IP", $ip, time()+3600*24);
						setcookie("HASH", $row['hash'], time()+3600*24);
						$hash = $row['hash'];
						$uid = $row['uid'];
						$time = time();
						$query = "INSERT INTO `loggedin` (`hash`, `ip`, `uid`, `time`) VALUES ('$hash', '$ip', '$uid', '$time')";
						mysqli_query($dbc, $query);
						$query = "UPDATE `users` SET `ip`='$ip' WHERE `uid` = '$user'";
						mysqli_query($dbc, $query);
						echo 'success';
						exit();
					} else {
						//$error = '<div class="shadowbar">It seems we have run into a problem... Either your username or password are incorrect or you haven\'t activated your account yet.</div>' ;
						//return $error;
					$err = 'failure';
					echo($err);
					exit();
					}
				} else {
					//$error = '<div class="shadowbar">You must enter both your username AND password.</div>';
					//return $error;
					$err = "{\"result\":\"failure\"}";
					echo json_encode($err);
					exit();
				}
			}
		} else {
			echo '{"result":"success"}';
			exit();
		}
		return $error;
	}
	public function addcomment(){
		global $dbc;
		if(isset($_POST['submit'])){
			$comment = mysqli_real_escape_string($dbc, trim($_POST['comment']));
			$user = mysqli_real_escape_string($dbc, trim($_POST['user']));
			$module = mysqli_real_escape_string($dbc, trim($_POST['module']));
			$id = mysqli_real_escape_string($dbc, trim($_POST['id']));
			$query = "INSERT INTO `comments` (`body`, `user`, `module`, `id`) VALUES ('$comment', '$user', '$module', '$id')";
			$data = mysqli_query($dbc, $query);
				echo 'success';
				exit();
			}
	}
	public function editprofile(){
		global $dbc, $parser, $layout, $main, $settings, $core; 
		$core->isLoggedIn();
		echo '<div class="shadowbar">';
		if (isset($_POST['submit'])) {
			// Grab the profile data from the POST
			$filename = mysqli_real_escape_string($dbc, trim($_FILES["new_picture"]["name"]));
			$email = mysqli_real_escape_string($dbc, trim($_POST["email"]));
			$sig = mysqli_real_escape_string($dbc, trim($_POST["sig"]));
			if (!empty($_FILES["new_picture"]["name"])) {
				$query = "SELECT * FROM users WHERE uid = ".$_SESSION['uid']."";
				$data = mysqli_query($dbc, $query);
				$row = mysqli_fetch_array($data);
				$pnum = mysqli_num_rows($data);
				$pnumu = ($row['uid'] + 1);
				$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
				$temp = explode(".", $_FILES["new_picture"]["name"]);
				$extension = end($temp);
				$pnumname = 'ccp'.$pnumu.'.'.$extension;
				$user = $_SESSION['uid'];
				if ((($_FILES["new_picture"]["type"] == "image/gif")
							|| ($_FILES["new_picture"]["type"] == "image/jpeg")
							|| ($_FILES["new_picture"]["type"] == "image/jpg")
							|| ($_FILES["new_picture"]["type"] == "image/pjpeg")
							|| ($_FILES["new_picture"]["type"] == "image/x-png")
							|| ($_FILES["new_picture"]["type"] == "image/png"))
						&& ($_FILES["new_picture"]["size"] < 5000000)
						&& in_array($extension, $allowedExts)
						&& isset($_FILES['new_picture']['type'])) {
						$query = "UPDATE users SET `picture` = '$pnumname' WHERE uid = '".$_SESSION['uid']."'";
						mysqli_query($dbc, $query);
						move_uploaded_file($_FILES["new_picture"]["tmp_name"],
						"include/images/profile/" . $pnumname);
				} else {
					echo 'Error: Invalid File.';
				}
				if(!empty($email)){
					$query = "UPDATE users SET `email` = '$email', `sig` = '$sig' WHERE uid = '".$_SESSION['uid']."'";
					mysqli_query($dbc, $query);	
					echo'Profile Updated';
					exit();
				}
			} else {
				if(!empty($email)){
					$query = "UPDATE users SET `email` = '$email', `sig` = '$sig' WHERE uid = '".$_SESSION['uid']."'";
					mysqli_query($dbc, $query);	
					echo'Profile Updated';
					exit();
				}
			}
		} // End of check for form submission
		else {  // Grab the profile data from the database
			$query = "SELECT * FROM users WHERE uid = '" . $_SESSION['uid'] . "'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			if ($row != NULL) {
				if(!isset($row[''])){
					
				}
				$email = $row['email'];
				$old_picture = $row['picture'];
				$sig = $row['sig'];
			}
			else {
				echo '<p class="error">There was a problem accessing your profile.</p>';
			}
		}
		



		echo'<form enctype="multipart/form-data" method="post" action="/editprofile">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Personal Information</legend>
		<label for="new_picture">Picture:</label>';
		if (!empty($old_picture)) {
			echo '<img style="max-height:120px;" class="profile" src="/include/images/profile/' . $old_picture . '" alt="Profile Picture" /><br /><br />';
		}
		echo'<input type="file" id="new_picture" name="new_picture" />
	<label for="email">E-Mail:</label>
	<input type="text" id="email" name="email" value="'.$email.'"/><br>
	<label for="sig">Signature:</label><br>
	<textarea style="width:100%;" rows="6" id="editor" placeholder="Signature..." name="sig">'.$sig.'</textarea>
		</fieldset>
		<input type="submit" value="Save Profile" name="submit" /> <a class="button" href="/ucp">Cancel</a>
	</form>
	</div>';
	}
	public function ucp(){
		global $dbc, $parser, $layout, $main, $settings, $core; 
		$core->isLoggedIn();
		if (!isset($_GET['uid'])) {
			$query = "SELECT * FROM users WHERE uid = '" . $_SESSION['uid'] . "'";
		}
		else {
			$secureUser = preg_replace("/[^0-9]/", "", $_GET['uid']);
			$suser = mysqli_real_escape_string($dbc, $secureUser);
			$query = "SELECT * FROM users WHERE uid = '" .$suser. "'";
		}
		$data = mysqli_query($dbc, $query);

		if (mysqli_num_rows($data) == 1) {
			$row = mysqli_fetch_array($data);
			echo '<div class="shadowbar">';
			echo '<table class="table">';
			echo '<tr><td>Username:</td><td>' . $row['username'] . '</td></tr>';
			echo '</td></tr>';
			echo '<tr><td>Email:</td><td>' . $row['email'] . '</td></tr>';
			echo '<tr><td>Picture:</td><td><img style="max-height:100px;" class="img-square" src="/include/images/profile/' . $row['picture'] .
			'" alt="Profile Picture" /></td></tr>';
			echo '<tr><td>Signature:</td><td>'.$row['sig'].'</td></tr>';
			echo '</table>';
			if (!isset($_GET['uid']) || ($_SESSION['uid'] == $_GET['uid'])) {
				echo '<p><a class="Link LButton" href="/editprofile">Edit</a><a class="Link LButton" href="/passwordReset">Reset Password</a></p>';
			}
		}
		else {
			echo '<p class="error">There was a problem accessing your profile.</p>';
		}
		echo'</div>';

	}
	public function activate() {
		global $dbc, $parser, $layout, $main, $settings, $core; 
		if(isset($_POST['submit'])) {
		$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
		$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
		$hash = mysqli_real_escape_string($dbc, trim($_POST['hash']));
		if($password1 == $password2){
		$query = "UPDATE users SET `activated` = '1', `passwordReset` = '0', `password` = SHA('$password1') WHERE hash = '$hash' ";
		$data = mysqli_query($dbc, $query);	
		echo '<div class="shadowbar">User successfully activated! You can now login!</div>';		
		}
		}
		if(isset($_GET['hash'])){
		$secureHash = $_GET['hash'];
		$hash = mysqli_real_escape_string($dbc, $secureHash);
		// Grab the profile data from the database
		$query = "SELECT passwordReset FROM users WHERE hash = '$hash' ";
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);
		if($row['passwordReset'] == '0') {
		$query = "UPDATE users SET `activated` = '1' WHERE hash = '$hash' ";
		$data = mysqli_query($dbc, $query);	
		echo '<div class="shadowbar">User successfully activated! You can now login!</div>';
		exit();
		}
		if($row['passwordReset'] == '1') {
		echo '
		<div class="shadowbar">
				<form method="post" action="/verifyaccount">
				<fieldset>
				<legend>Reset Password</legend>
				<div class="input-group">
				<span class="input-group-addon">Password</span>
				<input class="form-control" type="password" id="password" name="password1" />
				</div>
				<div class="input-group">
				<span class="input-group-addon">Retype Password</span>
				<input class="form-control" type="password" id="password" name="password2" />
				<input class="form-control" type="hidden" id="hash" name="hash" value="'.$_GET['hash'].'" />
				</div>
				</fieldset>
				<input class="Link LButton" type="submit" value="Reset" name="submit" />
			</form>
		</div>
		';
		} 
		}
		if(isset($_GET['fraud'])){
		if($_GET['fraud'] == 'true') {
		$query = "UPDATE users SET `activated` = '1', `passwordReset` = '0' WHERE hash = '$hash' ";
		$data = mysqli_query($dbc, $query);	
		echo '<div class="shadowbar">User successfully activated! You can now login!</div>';		
		}
		}
		
	}
	public function viewConvo(){
		echo '<div class="shadowbar">';
		global $dbc;
		$query = "SELECT * FROM users WHERE uid = '" . $_SESSION['uid'] . "'";
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);
		$username = $row['username'];
		$id = $row['uid'];
		$query = "SELECT * FROM convo WHERE convo.sent_to = '$username' OR convo.sent_by = '$id'";
		$data = mysqli_query($dbc, $query);
		echo '<table class="table">';
		echo '<thead>';
		echo '<th>Message Title</th>';
		echo '</thead>';
		echo '<tbody>';
		while ($row = mysqli_fetch_array($data)) {
			$query2 = "SELECT * FROM messages WHERE convo = ".$row['id']."";
			$count = mysqli_query($dbc, $query2);
			$rc = mysqli_fetch_array($count);
			if(!empty($row['title'])) {
				echo'<tr>';
				echo'<td>';
					echo'<a class="nav" href="/viewmessage/m/'.$row['id'].'">' .$row['title']. '   <span class="badge">' . mysqli_num_rows($count) . ' Messages</span></a>';  
				echo'</td>';
			}
			
		}
		echo '</tbody></table></div>';
	}
	public function viewMessage(){
		echo '<div class="shadowbar">';
		global $dbc, $parser, $layout, $main, $settings, $core;
		$secureMessage = preg_replace("/[^0-9]/", "", $_GET['m']);
		$message = mysqli_real_escape_string($dbc, $secureMessage);
		$query = "SELECT convo.*, messages.*, users.* FROM messages JOIN users ON users.uid = messages.user JOIN convo ON convo.id = messages.convo AND messages.convo = $message";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			$replyTitle = $row['title'];
				echo '<a class="Link LButton" href="/replymessage/m/'.$message.'">Reply</a>';
			$parsed = $parser->parse($row['content']);
			$sig = $parser->parse($row['sig']);
			echo sprintf($layout['blogViewFormat'], $row['title'], $row['picture'], $row['uid'], $row['username'], date('M j Y g:i A', strtotime($row['date'])), $parsed, $sig);
		}
		echo '</div>';
	}
	public function sendMessage(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
		echo '<div class="shadowbar">';
		//Grab the profile data from the database
		$query = "SELECT * FROM users WHERE uid = '" . $_SESSION['uid'] . "'";
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);
		$username = $row['uid'];
		if (isset($_POST['submit'])) {
			// Grab the profile data from the POST
			$message = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['message'])));
			$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
			$sent_to = mysqli_real_escape_string($dbc, trim($_POST['sent_to']));
			// Update the post data in the database
			if (!empty($message) && !empty($title) && !empty($sent_to)) {
				$query = "INSERT INTO convo (`sent_by`, `sent_to`, `title`) VALUES ('$username', '$sent_to', '$title')";
				mysqli_query($dbc, $query);
				$query = "SELECT * FROM convo WHERE sent_by = '$username' AND title = '$title' AND sent_to = '$sent_to' ORDER BY id DESC";
				$cquery = mysqli_query($dbc, $query);
				$convo = mysqli_fetch_array($cquery);
				$convo_id = $convo['id'];
				$query = "INSERT INTO messages (`user`, `convo`, `content`, `date`) VALUES ('$username', '$convo_id', '$message', NOW())";
				mysqli_query($dbc, $query);
				echo '<p>Your message has been successfully sent. Would you like to <a href="index.php?action=messages">view all of your messages</a>?</p>';
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} // End of check for form submission
		echo'<form enctype="multipart/form-data" method="post" action="/sendmessage">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Send Message:</legend>
			<label type="hidden" for="title">Title:</label><br />
			<input type="text" name="title"><br />
			<label type="hidden" for="title">To:</label><br />
			<input type="text" name="sent_to"><br />			
			<label type="hidden" for="message">Post Content:</label><br />
		<textarea rows="4"  name="message" id="message" cols="50"></textarea><br />
		</fieldset>
		<input type="submit" value="Send" name="submit" />     
	</form>
	</div>';	
	}
	public function invalidAction(){
	die('<div class="shadowbar">Invalid Argument.</div>');
	}
	public function sendMessageReply(){
		global $dbc, $core;
		$core->isLoggedIn();
		// Grab the profile data from the database
		$query = "SELECT uid FROM users WHERE uid = '" . $_SESSION['uid'] . "'";
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);
		$username = $row['uid'];
		if (isset($_POST['submit'])) {
			// Grab the profile data from the POST
			$reply = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['reply'])));
			$secureReply = preg_replace("/[^0-9]/", "", $_POST['replyid']);
			$replyid = mysqli_real_escape_string($dbc, $secureReply);
			// Update the post data in the database
			if (!empty($reply)) {
				// Only set the picture column if there is a new picture
				$query = "INSERT INTO messages (`user`, `convo`, `content`, `date`) VALUES ('$username', '$replyid', '$reply', NOW())";
				mysqli_query($dbc, $query) or die(mysqli_error($dbc));
				// Confirm success with the user
				echo '<div class="shadowbar"><p>You have replied successfully. Would you like to <a href="index.php?action=messages">view all of your messages</a>?</p></div>';
				exit();
			}
			else {
				echo '<div class="shadowbar"><p class="error">You must enter information into all of the fields.</p></div>';
			}
		} // End of check for form submission
		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="/replymessage">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Reply:</legend>
		<input type="hidden" name="replyid" value="'.$_GET['m'].'">
		<textarea rows="4"  name="reply" id="reply" cols="50"></textarea><br />
		</fieldset>
		<input type="submit" value="Send" name="submit" /> 
	</form>
	</div>';
	}
	public function signup(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		if(($settings['signup_enabled'] === 'false')){
			die('<div class="alert alert-warning"><strong>Registration Disabled.</strong></div>');
		}
		if(!isset($_SESSION['uid'])){
		if (isset($_POST['submit'])) {
			$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
			$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
			$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
			$email = mysqli_real_escape_string($dbc, trim($_POST['email']));			
			if (!empty($username) && !empty($password1) && !empty($password2) && !empty($email) && ($password1 == $password2)) {				
				$hash = md5(rand(0,1000));				
				$bemail = $settings['b_email'];
				$burl = $settings['b_url'];
				$query = "SELECT * FROM users WHERE email = '$email' AND `username` = '$username'";
				$data = mysqli_query($dbc, $query);
				if (mysqli_num_rows($data) == 0) {
					$to      = $email; // Send email to our user
					$subject = $settings['site_name']; // Give the email a subject
					$message = '	
			Thanks for signing up at '.$settings['site_name'].'
			Your account has been created, however you must activate your account. Your username and password are below, and the link you need to click is below that.
			------------------------
			Username: '.$username.'
			Password: '.$password1.'
			------------------------
			Please click this link to activate your account:
			http://'.$burl.'/verifyaccount/hash/'.$hash.'
			'; // Our message above including the link				
					$headers = 'From:'.$settings['site_name'].'' . "\r\n"; // Set from headers
					mail($to, $subject, $message, $headers); // Send our email								
					$uip = $_SERVER['REMOTE_ADDR'];					
					$query = "INSERT INTO users (username, password, email, hash, ip, picture) VALUES ('$username', SHA('$password1'), '$email', '$hash', '$uip', 'nopic.png')";
					mysqli_query($dbc, $query);		
					echo '<p>Your new account has been successfully created. You now need to verify your account. You signed up with this email: ' .$email . '. Please check your spam folder as there\'s a chance that the email could have ended up in there.';
					
					exit();
				}
				else {
					echo '<p class="error">An account already exists for this username. Please use a different username.</p>';
					$username = "";
				}
			}
			else {
				echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
			}
		
		}
		} else {
			echo "<div class='shadowbar'>You're Logged In!</div>";
			exit();
		}
		
		echo'<div class="shadowbar"><div class="alert alert-info"><strong>Please enter your username and desired password to sign up.</strong></div>
		<form method="post" action="/signup">
		<fieldset>
		<legend>Registration Info</legend>
		<div class="input-group">
		<span class="input-group-addon">Username</span>
		<input class="form-control" type="text" id="username" name="username"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Email</span>
		<input class="form-control" type="email" id="email" name="email" />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Password</span>
		<input class="form-control" type="password" id="password" name="password1" />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Retype Password</span>
		<input class="form-control" type="password" id="password" name="password2" />
		</div>
		<input type="hidden" id="perm" name="perm" value="U"/>
		<input type="hidden" id="usergroup" name="usergroup" value="User"/>
		</fieldset>
		<input class="Link LButton" type="submit" value="Sign Up" name="submit" />
	</form>
	</div>';
	}
	public function counter(){
		global $dbc, $core;
		if(!isset($_SESSION['uid'])){
			$u = $_SERVER['REMOTE_ADDR'];
			$q = "INSERT INTO `views` (`count`) VALUES ('$u')";
			mysqli_query($dbc, $q);
		} else {
			return false;
		}
	}
	
}

?>