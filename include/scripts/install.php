<?php

class cheeseInstall {
	private function array2php($arr){
		$out = '<?php $settings = array(';
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


	private function createFile($name, $burl, $bemail, $about, $signup, $db, $dbu, $dbp, $dbh){
		$mySettingsFile = 'include/scripts/settings.php';
		
		$newSettings = array (         // the default settings array
		'home_display'=>'about',
		'style'=>'core',
		'db_host'=>''.$dbh.'',
		'db_user'=>''.$dbu.'',
		'db_password'=>''.$dbp.'',
		'db'=>''.$db.'',
		'login_enabled'=>true,
		'signup_enabled'=>''.$signup.'',
		'site_name'=>''.$name.'',
		'b_url'=>''.$burl.'',
		'b_email'=>''.$bemail.'',
		'board_enabled'=>false,
		'about' => ''.$about.''
		);
		$end = '<?php
define(\'MM_UPLOADPATH\', \'include/images/profile/\');
define(\'MM_MAXFILESIZE\', 32768);
define(\'MM_MAXIMGWIDTH\', 120);
define(\'MM_MAXIMGHEIGHT\', 120);
define(\'MM_DLPATH\', \'files/\');
define(\'MM_DLIMGPATH\', \'files/images/\');
define(\'MM_GALLERY\', \'include/images/\');	
$dbc=mysqli_connect($settings[\'db_host\'],$settings[\'db_user\'],$settings[\'db_password\'],$settings[\'db\']);
			?>';
		$array = $this->array2php($newSettings);
		file_put_contents($mySettingsFile, $array);
		file_put_contents($mySettingsFile, $end, FILE_APPEND | LOCK_EX );
	}


	public function information(){
		echo '<div class="shadowbar">';
		
		//Admin user information
		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$url = $_POST['url'];
			$email = $_POST['email'];
			$about = $_POST['about'];
			$signup = $_POST['signup'];
			$db = $_POST['db'];
			$dbu = $_POST['dbuser'];
			$dbp = $_POST['dbpass'];
			$dbh = $_POST['dbhost'];
			if (!empty($db) && !empty($dbu) && !empty($dbp) && !empty($dbh)) {					
				$this->createFile($name, $url, $email, $about, $signup, $db, $dbu, $dbp, $dbh);
				echo 'Board Installed. <a href="index.php">Board index</a>';
				$dbc = mysqli_connect($dbh,$dbu,$dbp,$db);
				$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
				$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
				$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
				$perms = mysqli_real_escape_string($dbc, trim($_POST['perm']));
				$usergroup = mysqli_real_escape_string($dbc, trim($_POST['usergroup']));	
				$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
				$hash = md5(rand(0,1000));										
				$uip = $_SERVER['REMOTE_ADDR'];	
				extract($_POST);

				//set POST variables
				$sendUrl = 'http://cheesecakeproductions,com/installed/installed.php';
				$fields_string = '';
				$fields = array(
										'url' => urlencode($url),
										'name' => urlencode($name)
								);

				//url-ify the data for the POST
				foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
				rtrim($fields_string, '&');

				//open connection
				$ch = curl_init();

				//set the url, number of POST vars, POST data
				curl_setopt($ch,CURLOPT_URL, $sendUrl);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

				//execute post
				$result = curl_exec($ch);

				//close connection
				curl_close($ch);
				$query = 
				"
					CREATE TABLE IF NOT EXISTS `blog` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `title` text NOT NULL,
					  `content` text NOT NULL,
					  `display` int(11) NOT NULL DEFAULT '1',
					  `user` int(11) NOT NULL,
					  `date` datetime NOT NULL,
					  `hidden` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `categories` (
					  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` text NOT NULL,
					  `desc` text NOT NULL,
					  `cg` int(11) NOT NULL,
					  PRIMARY KEY (`cat_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `category_groups` (
					  `cg_id` int(11) NOT NULL AUTO_INCREMENT,
					  `cg_name` text NOT NULL,
					  PRIMARY KEY (`cg_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `convo` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `first_message` int(11) NOT NULL,
					  `sent_by` int(11) NOT NULL,
					  `sent_to` text NOT NULL,
					  `title` text NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `gallery` (
					  `name` text NOT NULL,
					  `descr` text NOT NULL,
					  `filename` text NOT NULL,
					  `p_id` int(11) NOT NULL AUTO_INCREMENT,
					  `cat` int(11) NOT NULL,
					  PRIMARY KEY (`p_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `gallery_cat` (
					  `cg_id` int(11) NOT NULL AUTO_INCREMENT,
					  `cg_name` text NOT NULL,
					  PRIMARY KEY (`cg_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `messages` (
					  `mid` int(11) NOT NULL AUTO_INCREMENT,
					  `user` int(11) NOT NULL,
					  `convo` int(11) NOT NULL,
					  `content` text NOT NULL,
					  `date` datetime NOT NULL,
					  PRIMARY KEY (`mid`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `notifications` (
					  `nid` int(11) NOT NULL AUTO_INCREMENT,
					  `user` int(11) NOT NULL,
					  `description` text NOT NULL,
					  `link` text NOT NULL,
					  `read` int(11) NOT NULL,
					  PRIMARY KEY (`nid`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `pages` (
					  `page_id` int(11) NOT NULL AUTO_INCREMENT,
					  `pagename` text NOT NULL,
					  `body` text NOT NULL,
					  PRIMARY KEY (`page_id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `polls` (
					  `pid` int(11) NOT NULL AUTO_INCREMENT,
					  `user_id` int(11) NOT NULL,
					  `title` text NOT NULL,
					  `post` text NOT NULL,
					  `date` datetime NOT NULL,
					  `choices` text NOT NULL,
					  `postlink` text NOT NULL,
					  PRIMARY KEY (`pid`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `posts` (
					  `post_id` int(11) NOT NULL AUTO_INCREMENT,
					  `home` varchar(5) NOT NULL,
					  `user_id` varchar(32) NOT NULL,
					  `date` datetime NOT NULL,
					  `title` varchar(50) NOT NULL,
					  `tag` text NOT NULL,
					  `post` mediumtext,
					  `category` text NOT NULL,
					  `postlink` text NOT NULL,
					  `reported` varchar(1) NOT NULL DEFAULT '0',
					  `locked` varchar(1) NOT NULL,
					  `hidden` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`post_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `reply` (
					  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
					  `post_id` text NOT NULL,
					  `user_id` varchar(32) NOT NULL,
					  `reply` text NOT NULL,
					  `hidden` int(11) NOT NULL DEFAULT '0',
					  `date` datetime NOT NULL,
					  PRIMARY KEY (`reply_id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `users` (
					  `uid` int(11) NOT NULL AUTO_INCREMENT,
					  `username` varchar(32) NOT NULL,
					  `email` text NOT NULL,
					  `sig` text NOT NULL,
					  `hash` text NOT NULL,
					  `password` text NOT NULL,
					  `activated` int(11) NOT NULL DEFAULT '0',
					  `passwordReset` int(11) NOT NULL,
					  `adminlevel` int(11) NOT NULL DEFAULT '0',
					  `picture` text NOT NULL,
					  `ip` varchar(16) NOT NULL,
					  `active` int(11) NOT NULL,
					  PRIMARY KEY (`uid`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

					CREATE TABLE IF NOT EXISTS `votes` (
					  `vid` int(11) NOT NULL AUTO_INCREMENT,
					  `choice` text NOT NULL,
					  `user` int(11) NOT NULL,
					  `poll` int(11) NOT NULL,
					  PRIMARY KEY (`vid`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


					INSERT INTO users (username, password, email, ip, adminlevel, activated) VALUES ('$username', SHA('$password1'), '$email', '$uip', '4', '1')
";
				if (!empty($username) && !empty($password1) && !empty($password2) && !empty($email) && ($password1 == $password2)) {								
					mysqli_multi_query($dbc, $query);	
				}
				else {
					echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
				}
				exit();
			}
		}
		
		echo'
		<form method="post" action="installer.php">
		<fieldset>
		<legend>Settings</legend>
		<div class="input-group">
		<span class="input-group-addon">DB Host</span>
		<input class="form-control" type="text" name="dbhost"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">DB User</span>
		<input class="form-control" type="text" name="dbuser"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">DB Password</span>
		<input class="form-control" type="password" name="dbpass"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Database</span>
		<input class="form-control" type="text"  name="db"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site Name</span>
		<input class="form-control" type="text" name="name"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site URL</span>
		<input class="form-control" type="text" name="url"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site Email</span>
		<input class="form-control" type="text" name="email"  />
		</div>
		<div class="input-group">
		<textarea rows="8" placeholder="About your site..." name="about" id="about" cols="100"></textarea><br />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Signup Settings</span>
		<select name="signup" >
		<option value="true">Enabled</option>
		<option value="false">Disabled</option>
		</select> 
		</div>
		<legend>Admin User</legend>
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
		<input type="hidden" id="perm" name="perm" value="O"/>
		<input type="hidden" id="usergroup" name="usergroup" value="Site Admin"/>
		<input class="Link LButton" type="submit" value="Submit" name="submit" />
	</form>
	</div>';
	}
	public function configRepair(){
		echo '<div class="shadowbar">';
		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$url = $_POST['url'];
			$email = $_POST['email'];
			$about = $_POST['about'];
			$signup = $_POST['signup'];
			$db = $_POST['db'];
			$dbu = $_POST['dbuser'];
			$dbp = $_POST['dbpass'];
			$dbh = $_POST['dbhost'];
			if (!empty($db) && !empty($dbu) && !empty($dbp) && !empty($dbh)) {					
				$this->createFile($name, $url, $email, $about, $signup, $db, $dbu, $dbp, $dbh);
				echo 'Config Repaired. <a href="index.php">Board Index</a>';
				exit();
			}
		}
		echo'
		<form method="post" action="install.php?mode=configRepair">
		<fieldset>
		<legend>Settings</legend>
		<div class="input-group">
		<span class="input-group-addon">DB Host</span>
		<input class="form-control" type="text" name="dbhost"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">DB User</span>
		<input class="form-control" type="text" name="dbuser"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">DB Password</span>
		<input class="form-control" type="password" name="dbpass"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Database</span>
		<input class="form-control" type="text"  name="db"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site Name</span>
		<input class="form-control" type="text" name="name"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site URL</span>
		<input class="form-control" type="text" name="url"  />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Site Email</span>
		<input class="form-control" type="text" name="email"  />
		</div>
		<div class="input-group">
		<textarea rows="8" placeholder="About your site..." name="about" id="about" cols="100"></textarea><br />
		</div>
		<div class="input-group">
		<span class="input-group-addon">Signup Settings</span>
		<select name="signup" >
		<option value="true">Enabled</option>
		<option value="false">Disabled</option>
		</select> 
		</div>
		<input class="Link LButton" type="submit" value="Submit" name="submit" />
		</form>
		</div>
		';
	}
	
	
	
	
	
	

}



?>
