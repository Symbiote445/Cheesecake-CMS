<?php
//Cheesecake Core Blog
$blog = new blog;
if(isset($_GET['action'])){
if(isset($_GET['action']) && ($_GET['action'] == "Blog")){
if(isset($_GET['action']) && !isset($_GET['mode'])){
if($_GET['action'] === "Blog"){
global $dbc, $parser, $layout, $main, $settings, $core;
$blog->viewBlog();
}
$blog->blogAdminBar();
}
if(isset($_GET['mode'])){
if($_GET['mode'] == "postblog"){
$blog->postBlog();
}
if($_GET['mode'] == "admin"){
$blog->blogPostAdmin();
}
if($_GET['mode'] == "delete"){
$blog->blogDeletePost();
}
if($_GET['mode'] == "hide"){
$blog->blogHideAdmin();
}
if($_GET['mode'] == "unhide"){
$blog->blogUnHideAdmin();
}
$blog->blogAdminBar();
}
}
} else {
  $blog->homepage();	
}

class blog {
	public function homepage(){
	global $dbc, $parser, $layout, $main, $settings, $core;
		$query = "SELECT blog.*, users.* FROM blog INNER JOIN users ON users.uid = blog.user ORDER BY blog.id DESC LIMIT 3";
		$data = mysqli_query($dbc, $query);
		echo '<div class="shadowbar"><h3>Latest Blog Posts</h3><hr>';
		while ($row = mysqli_fetch_array($data)) {
			$parsed = $parser->parse($row['content']);
			$sig = $parser->parse($row['sig']);
			echo sprintf($layout['blogViewFormat'], $row['title'], $row['picture'], $row['uid'], $row['username'], date('M j Y g:i A', strtotime($row['date'])), $parsed, $sig);
		}
		echo '</div>';
	}
	public function blogAdminBar(){
	global $dbc, $parser, $layout, $main, $settings, $core;
	if($core->verify("4")){
	echo sprintf($layout['adminBar'], 'index.php?action=Blog&mode=admin', 'Blog');
	}
	}

	public function viewBlog(){
	global $dbc, $parser, $layout, $main, $settings, $core;
		$query = "SELECT blog.*, users.* FROM blog INNER JOIN users ON users.uid = blog.user ORDER BY blog.id DESC";
		$data = mysqli_query($dbc, $query);

		while ($row = mysqli_fetch_array($data)) {
			$parsed = $parser->parse($row['content']);
			$sig = $parser->parse($row['sig']);
			echo sprintf($layout['blogViewFormat'], $row['title'], $row['picture'], $row['uid'], $row['username'], date('M j Y g:i A', strtotime($row['date'])), $parsed, $sig);
		}
	}
	
	public function postBlog(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		echo'<div class="shadowbar">';
		if($core->verify("4") || $core->verify("2")){

			global $dbc;
			$query = "SELECT * FROM users WHERE uid = '" . $_SESSION['uid'] . "'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			$username = $row['uid'];
			if (isset($_POST['submit'])) {
				$post1 = mysqli_real_escape_string($dbc, trim($_POST['post1']));
				$display = mysqli_real_escape_string($dbc, trim($_POST['display']));
				$title = mysqli_real_escape_string($dbc, trim($_POST['title']));

				if (!empty($post1) && !empty($title)) {

					$query = "INSERT INTO blog (`title`, `content`, `display`, `user`, `date`) VALUES ('$title', '$post1', '$display', '$username', NOW())";
					mysqli_query($dbc, $query);

					echo '<p>Your post has been successfully added. Would you like to <a href="index.php?action=vb">view all of the blog posts</a>?</p>';
					
					exit();
				}
				else {
					echo '<p class="error">You must enter information into all of the fields.</p>';
				}
			}
			print($layout['postBlogFormat']);
			echo'</div>';
		}
	}
	public function blogPostAdmin(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		echo '<div class="shadowbar">';
		$core->isLoggedIn();
		

		if(!$core->verify("4")){
			exit();
		}

		$query = "SELECT blog.*, users.* FROM blog JOIN users ON users.uid = blog.user ORDER BY blog.id DESC ";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			$parsed = $parser->parse($row['content']);
			echo sprintf($layout['adminPostLayout'], $row['title'], $parsed, $row['id'], 'Blog', 'delete', $row['id'], $row['display'], 'Blog', $row['id'], 'Blog', $row['id'], $row['username'], $row['adminlevel']);
		}
		echo '</div>';
	}
	public function blogHideAdmin(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		$core->isLoggedIn();
		if(!$core->verify("4")){
			exit();
		}
		if (isset($_POST['submit'])) {
			$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
			if (!empty($postid)) {

				$query = "UPDATE blog SET `display`='0' WHERE id = $postid";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>Post has been successfully hidden. Would you like to <a href="index.php">go back to the admin panel</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} 
		
		
		echo sprintf($layout['adminDeleteLayout'], 'hide', $_GET['del']);
	}
	public function blogUnHideAdmin(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		$core->isLoggedIn();
		if(!$core->verify("4")){
			exit();
		}
		if (isset($_POST['submit'])) {
			$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
			if (!empty($postid)) {

				$query = "UPDATE blog SET `display`='1' WHERE id = $postid";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>Post has been successfully unhidden. Would you like to <a href="index.php">go back to the admin panel</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} 
		
		
		echo sprintf($layout['adminDeleteLayout'], 'unhide', $_GET['del']);
	}
	public function blogDeletePost(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		$core->isLoggedIn();
		if(!$core->verify("4")){
			exit();
		}
		if (isset($_POST['submit'])) {
			$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
			if (!empty($postid)) {

				$query = "DELETE FROM blog WHERE id = $postid";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>Post has been successfully deleted. Would you like to <a href="index.php">go back to the admin panel</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} 
		
		$id = mysqli_real_escape_string($dbc, trim($_GET['del']));
		echo sprintf($layout['adminDeleteLayout'], 'delete', $id);
	}
}
?>