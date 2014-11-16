<?php
/*
CheesecakeCore
*/

//error_reporting(E_ALL);
if(!defined("CCore")){
	die("Access Denied.");
}
class admin {
	private function array2php($arr){
		$out = '<? $settings = array(';
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
	public function delu(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		if(!$core->verify("4")){
			exit();
		}
		$core->isLoggedIn();
		if (isset($_POST['submit'])) {
			$userid = mysqli_real_escape_string($dbc, trim($_POST['userid']));
			if (!empty($userid)) {
				$query = "DELETE FROM users WHERE uid = $userid";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>User has been successfully deleted. Would you like to <a href="index.php?action=acp&mode=users">go back to the admin panel</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<div class="shadowbar"><p class="error">You must enter information into all of the fields.</p></div>';
			}
		} 
		
		
		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=acp&mode=deleteuser">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>
			<input type="hidden" name="userid" value="'.$_GET['del'].'">';
		echo 'User ID: ' . $_GET['del'] . '<br /> <br />';
		echo'</fieldset>
		<input type="submit" value="Delete User" name="submit" />    <a class="button" href="index.php?action=acp">Cancel</a> 
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
				$query = "UPDATE users SET adminlevel = '$perm' WHERE username = '$user'";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>User has been successfully edited. Would you like to <a href="index.php">return to the ACP</a>?</p></a>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}

		}
		if(!$core->verify("4")){
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
		

		

		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=acp&mode=editperms">
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
	public function usr() {
		global $settings, $version, $dbc, $layout, $core, $parser;
		echo '<div class="shadowbar">';
		if(!$core->verify("4")){
			exit();
		}


		// Connect to the database

		// Grab the profile data from the database
		$query = "SELECT * FROM users ORDER BY uid DESC";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			echo sprintf($layout['adminUserLayout'], $row['username'], $row['uid'], $row['uid'], $row['activated'], $row['hash'], $row['adminlevel'], $row['username']);
		}
		echo '</div>';
	}
	public function acp(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		if(!$core->verify("4")){
			die('<div class="shadowbar">You don\'t have significant privilege</div>');
		}
		echo '<div class="shadowbar">
		<a class="Link LButton" href="index.php?action=acp">Admin </a><a class="Link LButton" href="index.php?action=acp&mode=users">Users </a><a class="Link LButton" href="index.php?action=acp&mode=Settings">Settings </a>';
		echo '</div>
';
		if(isset($_GET['mode'])){
			if($_GET['mode'] == 'users'){
				$this->usr();
			}
			if($_GET['mode'] == 'deleteuser'){
				$this->delu();
			}
			if($_GET['mode'] == 'editperms'){
				$this->eur();
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
					
					$newSettings = array (         // the default settings array
					'home_display'=>''.$home.'',
					'style'=>''.$style.'',
					'db_host'=>'localhost',
					'db_user'=>'root',
					'db_password'=>'w3nF4BrL6n4m',
					'db'=>''.$db.'',
					'login_enabled'=>true,
					'signup_enabled'=>''.$signup.'',
					'site_name'=>''.$name.'',
					'b_url'=>''.$burl.'',
					'b_email'=>''.$bemail.'',
					'board_enabled'=>false,
					'about' => " ".$about.""
					);
					$end = '<?
define(\'MM_UPLOADPATH\', \'include/images/profile/\');
define(\'MM_MAXFILESIZE\', 32768);
define(\'MM_MAXIMGWIDTH\', 120);
define(\'MM_MAXIMGHEIGHT\', 120);
define(\'MM_DLPATH\', \'files/\');
define(\'MM_DLIMGPATH\', \'files/images/\');
define(\'MM_GALLERY\', \'include/images/\');	
$dbc=mysqli_connect($settings[\'db_host\'],$settings[\'db_user\'],$settings[\'db_password\'],$settings[\'db\']);
			?>';
					file_put_contents($mySettingsFile, $this->array2php($newSettings));
					file_put_contents($mySettingsFile, $end, FILE_APPEND | LOCK_EX );

					echo '<div class="alert alert-success">Settings Edited</div>';
				}
				global $settings;
				
				echo'<div class="shadowbar"><div class="alert alert-info">Please refer to the documentation <a href="http://cheesecakebb.org/index.php?action=pages&page=Settings">Here</a> for settings</div>
		<form method="post" action="index.php?action=acp&mode=Settings">
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
		}
	}
}


class core {
	public function Version($local, $remote){
		$remoteVersion=trim(file_get_contents($remote));
		return version_compare($local, $remoteVersion, 'ge');
	}
	public function verify($permissionName){
		global $dbc;
		if(isset($_SESSION['uid'])){	
			$query = "SELECT adminlevel FROM users WHERE uid = '" . $_SESSION['uid'] . "'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			if($row['adminlevel'] === $permissionName){
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
				foreach($modules as $name => $module) if ($module['enabled']) {
					echo '<a class="btn btn-default width100" href="'.$module['sidebar'].'">'.$module['sidebarDesc'].'</a>';
				}
			}
		}
	}
	public function logout(){
		session_destroy();
		//setcookie('username', "", time()-10, "/");
		//setcookie('user_id', "", time()-10, "/");

		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';

		header('Location: ' . $home_url);
	}
	public function isLoggedIn(){
		echo '<div class="shadowbar">';
		if (!isset($_SESSION['uid'])) {
			echo '<p class="login">Please <a href="index.php?action=ucp&mode=login">log in</a> to access this page.</p>';
			exit();
		}
		else {
			echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '. <a href="index.php?action=logout">Log out</a>.</p>');
		}
		echo '</div>';
	}

	public function login() {
		global $dbc, $layout;
		if(!isset($_SESSION['uid'])){
			if(isset($_POST['submit'])){
				$username = mysqli_real_escape_string($dbc, trim($_POST['email']));
				$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
				if(!empty($username) && !empty($password)){
					$query = "SELECT uid, email, username, password FROM users WHERE email = '$username' AND password = SHA('$password') ";
					$data = mysqli_query($dbc, $query);
					if((mysqli_num_rows($data) === 1)){
						$row = mysqli_fetch_array($data);
						$_SESSION['uid'] = $row['uid'];
						$_SESSION['username'] = $row['username'];
						echo "<div class=\"shadowbar\"><script type=\"text/javascript\">document.write(\"You will be redirected to main page in 5 seconds.\");
				setTimeout('Redirect()', 5000);</script> if not click <a href=\"index.php\">here</a></div>";
						exit();
					} else {
						echo '';
					}
				} else {
					echo 'You must enter both your username AND password.';
				}
			}
			print($layout['login']);
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

			if (!empty($_FILES["new_picture"]["name"])) {
				$query = "SELECT * FROM users";
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
					if ($_FILES["new_picture"]["name"]["error"] > 0) {
						echo "Return Code: " . $_FILES["new_picture"]["name"]["error"] . "<br>";
					} else {
						$query = "UPDATE users SET `picture` = '$pnumname' WHERE uid = '".$_SESSION['uid']."'";
						mysqli_query($dbc, $query);
						move_uploaded_file($_FILES["new_picture"]["tmp_name"],
						"include/images/profile/" . $pnumname);
					}
				} else {
					echo 'Error: Invalid File.';
				}
				if(!empty($email)){
					$query = "UPDATE users SET `email` = '$email' WHERE uid = '".$_SESSION['uid']."'";
					mysqli_query($dbc, $query);	
					echo'Profile Updated';
					exit();
				}
			} else {
				if(!empty($email)){
					$query = "UPDATE users SET `email` = '$email' WHERE uid = '".$_SESSION['uid']."'";
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
			}
			else {
				echo '<p class="error">There was a problem accessing your profile.</p>';
			}
		}
		



		echo'<form enctype="multipart/form-data" method="post" action="index.php?action=editprofile">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Personal Information</legend>
		<label for="new_picture">Picture:</label>';
		if (!empty($old_picture)) {
			echo '<img style="max-height:120px;" class="profile" src="include/images/profile/' . $old_picture . '" alt="Profile Picture" /><br /><br />';
		}
		echo'<input type="file" id="new_picture" name="new_picture" />
	<label for="email">E-Mail:</label>
	<input type="text" id="email" name="email" />
		</fieldset>
		<input type="submit" value="Save Profile" name="submit" /> <a class="button" href="index.php?action=ucp">Cancel</a>
	</form>
	</div>';
	}
	public function ucp(){
		global $dbc, $parser, $layout, $main, $settings, $core; 
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
			echo '<div class="shadowbar"><table class="table">';
			echo '<tr><td>Username:</td><td>' . $row['username'] . '</td></tr>';
			echo '<a class="Link LButton" href="index.php?action=ucp&mode=rm&to1='.$row['username'].'">PM This User</a><br>';
			echo '<a class="Link LButton" href="index.php?action=ucp&mode=notes&u='.$row['uid'].'">View User Notes</a><br>';
			echo '</td></tr>';
			echo '<tr><td>Email:</td><td>' . $row['email'] . '</td></tr>';
			echo '<tr><td>Picture:</td><td><img style="max-height:100px;" class="img-square" src="include/images/profile/' . $row['picture'] .
			'" alt="Profile Picture" /></td></tr>';
			echo '</table>';
			if (!isset($_GET['uid']) || ($_SESSION['uid'] == $_GET['uid'])) {
				echo '<p><a class="button" href="index.php?action=editprofile">Edit</a></p>';
			}
		}
		else {
			echo '<p class="error">There was a problem accessing your profile.</p>';
		}
		echo'</div>';
	}
	public function activate() {
		global $dbc, $parser, $layout, $main, $settings, $core; 
		$secureHash = $_GET['hash'];
		$hash = mysqli_real_escape_string($dbc, $secureHash);
		// Grab the profile data from the database
		$query = "UPDATE users SET `activated` = '1' WHERE hash = '$hash' ";
		$data = mysqli_query($dbc, $query);	
		echo '<div class="shadowbar">User successfully activated! You can now login!</div>';
		exit();
		
		
	}
	public function signup(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		if(($settings['signup_enabled'] === 'false')){
			die('<div class="alert alert-warning"><strong>Registration Disabled.</strong></div>');
		}
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
			http://'.$burl.'/index.php?action=verifyaccount&hash='.$hash.'
			'; // Our message above including the link				
					$headers = 'From:'.$settings['site_name'].'' . "\r\n"; // Set from headers
					mail($to, $subject, $message, $headers); // Send our email								
					$uip = $_SERVER['REMOTE_ADDR'];					
					$query = "INSERT INTO users (username, password, email, hash, ip) VALUES ('$username', SHA('$password1'), '$email', '$hash', '$uip')";
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
		
		echo'<div class="shadowbar"><div class="alert alert-info"><strong>Please enter your username and desired password to sign up.</strong></div>
		<form method="post" action="index.php?action=signup">
		<fieldset>
		<legend>Registration Info</legend>
		<div class="input-group">
		<span class="input-group-addon">Username</span>
		<input class="form-control" type="text" id="username" name="username"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Email</span>
		<input class="form-control" type="text" id="email" name="email" />
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
	
}

?>