<?php

class cheeseInstall {

	public function array2php($arr){
		$out = '<? $settings = array(';
		foreach( $arr as $k => $v ){
			if( is_bool($v) ){
				$v = ( $v ) ? 'true' : 'false';
			}
			else{
				$v = '\''.$v.'\'';
			}
			$out .= ' \''.$k.'\' => '.$v.',';
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
				$query = 
				"

CREATE TABLE IF NOT EXISTS `blog` (
`id` int(11) NOT NULL,
`title` text NOT NULL,
`content` text NOT NULL,
`display` int(11) NOT NULL DEFAULT '1',
`user` int(11) NOT NULL,
`date` datetime NOT NULL,
`hidden` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `categories` (
`cat_id` int(11) NOT NULL,
`name` text NOT NULL,
`desc` text NOT NULL,
`cg` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `category_groups` (
`cg_id` int(11) NOT NULL,
`cg_name` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pages` (
`page_id` int(11) NOT NULL,
`pagename` text NOT NULL,
`body` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `posts` (
`post_id` int(11) NOT NULL,
`home` varchar(5) NOT NULL,
`user_id` varchar(32) NOT NULL,
`date` datetime NOT NULL,
`title` varchar(50) NOT NULL,
`post` mediumtext,
`category` text NOT NULL,
`reported` varchar(1) NOT NULL DEFAULT '0',
`locked` varchar(1) NOT NULL,
`hidden` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `reply` (
`reply_id` int(11) NOT NULL,
`post_id` text NOT NULL,
`user_id` varchar(32) NOT NULL,
`reply` text NOT NULL,
`hidden` int(11) NOT NULL DEFAULT '0',
`date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `users` (
`uid` int(11) NOT NULL,
`username` varchar(32) NOT NULL,
`email` text NOT NULL,
`hash` text NOT NULL,
`password` text NOT NULL,
`activated` int(11) NOT NULL DEFAULT '0',
`adminlevel` int(11) NOT NULL DEFAULT '0',
`picture` text NOT NULL,
`ip` varchar(12) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


ALTER TABLE `blog`
ADD PRIMARY KEY (`id`);

ALTER TABLE `categories`
ADD PRIMARY KEY (`cat_id`);

ALTER TABLE `category_groups`
ADD PRIMARY KEY (`cg_id`);

ALTER TABLE `pages`
ADD PRIMARY KEY (`page_id`);

ALTER TABLE `posts`
ADD PRIMARY KEY (`post_id`);

ALTER TABLE `reply`
ADD PRIMARY KEY (`reply_id`);

ALTER TABLE `users`
ADD PRIMARY KEY (`uid`);


ALTER TABLE `blog`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
ALTER TABLE `categories`
MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
ALTER TABLE `category_groups`
MODIFY `cg_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE `pages`
MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
ALTER TABLE `posts`
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
ALTER TABLE `reply`
MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
ALTER TABLE `users`
MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;

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
	
	
	
	
	
	
	/*
		public function populate(){
			global $dbc;
			if (isset($_POST['submit'])) {
			global $dbc;
				$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
				$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
				$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
				$perms = mysqli_real_escape_string($dbc, trim($_POST['perm']));
				$usergroup = mysqli_real_escape_string($dbc, trim($_POST['usergroup']));	
				$email = mysqli_real_escape_string($dbc, trim($_POST['email']));

				$query = 
				"

CREATE TABLE IF NOT EXISTS `bans` (
`ban_id` int(11) NOT NULL AUTO_INCREMENT,
`bannedip` varchar(42) NOT NULL,
PRIMARY KEY (`ban_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `blog` (
`post_id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` varchar(32) NOT NULL,
`post_date` date NOT NULL,
`title` varchar(20) NOT NULL,
`post` mediumtext,
PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `categories` (
`cat_id` int(11) NOT NULL AUTO_INCREMENT,
`name` text NOT NULL,
`desc` text NOT NULL,
PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `convo` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` tinytext NOT NULL,
`user` tinytext NOT NULL,
`started_by` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `gallery` (
`name` text NOT NULL,
`descr` text NOT NULL,
`filename` text NOT NULL,
`p_id` int(11) NOT NULL AUTO_INCREMENT,
PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `groups` (
`group_id` int(11) NOT NULL AUTO_INCREMENT,
`groupname` text NOT NULL,
`groupdesc` text NOT NULL,
`locked` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `group_forums` (
`forum_id` int(11) NOT NULL AUTO_INCREMENT,
`group_id` text NOT NULL,
`name` text NOT NULL,
`description` text NOT NULL,
PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `group_members` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`group_id` text NOT NULL,
`user_id` text NOT NULL,
`rank` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `mods` (
`mod_id` int(11) NOT NULL AUTO_INCREMENT,
`modname` text NOT NULL,
`modfile` text NOT NULL,
`href` text NOT NULL,
`enabled` varchar(1) NOT NULL,
PRIMARY KEY (`mod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `news` (
`post_id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` varchar(32) NOT NULL,
`post_date` date NOT NULL,
`title` varchar(20) NOT NULL,
`post` mediumtext,
PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `notes` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`note` longtext NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `options` (
`op_id` int(11) NOT NULL AUTO_INCREMENT,
`name` text NOT NULL,
`desc` text NOT NULL,
`about` text NOT NULL,
PRIMARY KEY (`op_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `pages` (
`page_id` int(11) NOT NULL AUTO_INCREMENT,
`pagename` text NOT NULL,
`body` text NOT NULL,
PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `pm` (
`msg_id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` varchar(32) NOT NULL,
`to` varchar(32) NOT NULL,
`msg_date` date NOT NULL,
`title` varchar(40) NOT NULL,
`msg` mediumtext,
`convo` int(11) NOT NULL,
PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `posts` (
`post_id` int(11) NOT NULL AUTO_INCREMENT,
`home` varchar(5) NOT NULL,
`user_id` varchar(32) NOT NULL,
`post_date` date NOT NULL,
`title` varchar(50) NOT NULL,
`post` mediumtext,
`category` text NOT NULL,
`reported` varchar(1) NOT NULL DEFAULT '0',
`locked` varchar(1) NOT NULL,
PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `reply` (
`reply_id` int(11) NOT NULL AUTO_INCREMENT,
`post_id` text NOT NULL,
`user_id` varchar(32) NOT NULL,
`reply` text NOT NULL,
PRIMARY KEY (`reply_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(32) NOT NULL,
`usergroup` text NOT NULL,
`rank` text NOT NULL,
`permissions` varchar(32) NOT NULL,
`password` varchar(40) NOT NULL,
`join_date` datetime DEFAULT NULL,
`first_name` varchar(32) DEFAULT NULL,
`last_name` varchar(32) DEFAULT NULL,
`gender` varchar(1) DEFAULT NULL,
`sig` text NOT NULL,
`birthdate` date DEFAULT NULL,
`city` varchar(32) DEFAULT NULL,
`state` varchar(2) DEFAULT NULL,
`picture` varchar(32) DEFAULT 'nopic.png',
`email` text NOT NULL,
`hash` varchar(32) NOT NULL,
`activated` int(1) NOT NULL DEFAULT '0',
`status` text NOT NULL,
`ip` varchar(42) NOT NULL,
PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

INSERT INTO user (username, usergroup, rank, password, join_date, email, hash, permissions, ip) VALUES ('$username', '$usergroup', 'Site Admin', SHA('$password1'), NOW(), '$email', '$hash', 'O', '$uip');

";
				if (!empty($username) && !empty($password1) && !empty($password2) && !empty($email) && ($password1 == $password2)) {				
					$hash = md5(rand(0,1000));										
					$uip = $_SERVER['REMOTE_ADDR'];					
					mysqli_multi_query($dbc, $query);	
				}
				else {
					echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
				}

			}
			var_dump($dbc);
			echo 'hi'.$dbc;
			echo '
		<form method="post" action="install.php?action=populate">
		<fieldset>
		<legend>Admin User and Settings Info</legend>
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
		</fieldset>
		<input class="Link LButton" type="submit" value="Sign Up" name="submit" />
		</form>
		';
		}

*/

}



?>
