<?php $settings = array( "home_display" => "about", "style" => "christmas", "db_host" => "localhost", "db_user" => "root", "db_password" => "wnFSB3L5m", "db" => "loh", "login_enabled" => true, "signup_enabled" => "true", "site_name" => "League of Heroes", "b_url" => "loh.cheesecakebb.org", "b_email" => "gage@cheesecakebb.org", "board_enabled" => false, "about" => "                 [b]Everyone vote on the newest poll[/b]
League of Heroes website
Post on the forums, check out blogs, or look at pages!
Great for all LOH members, join now!
[b]Maintenance[/b]
Activation emails should be sending normally now." ); ?><?php
define('MM_UPLOADPATH', 'include/images/profile/');
define('MM_MAXFILESIZE', 32768);
define('MM_MAXIMGWIDTH', 120);
define('MM_MAXIMGHEIGHT', 120);
define('MM_DLPATH', 'files/');
define('MM_DLIMGPATH', 'files/images/');
define('MM_GALLERY', 'include/images/');	
$dbc=mysqli_connect($settings['db_host'],$settings['db_user'],$settings['db_password'],$settings['db']);
			?>