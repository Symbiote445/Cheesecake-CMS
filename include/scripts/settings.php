<? $settings = array( "home_display" => "News", "style" => "core", "db_host" => "localhost", "db_user" => "root", "db_password" => "w3nF4BrL6n4m", "db" => "cblog", "login_enabled" => true, "signup_enabled" => "true", "site_name" => "Cheesecake Blog", "b_url" => "cheesecakebb.org", "b_email" => "gage@cheesecakebb.org", "board_enabled" => false, "about" => "    Welcome to the official site for Cheesecake Portal, website software." ); ?><?
define('MM_UPLOADPATH', 'include/images/profile/');
define('MM_MAXFILESIZE', 32768);
define('MM_MAXIMGWIDTH', 120);
define('MM_MAXIMGHEIGHT', 120);
define('MM_DLPATH', 'files/');
define('MM_DLIMGPATH', 'files/images/');
define('MM_GALLERY', 'include/images/');	
$dbc=mysqli_connect($settings['db_host'],$settings['db_user'],$settings['db_password'],$settings['db']);
			?>