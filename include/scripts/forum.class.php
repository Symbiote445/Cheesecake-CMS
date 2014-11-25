<?php
$forum = new Forums;
if(isset($_GET['action'])){
	if (($_GET['action'] == 'viewcategory')){
		$forum->category();
		$forum->forumAdminBar();
	}
	if($_GET['action'] == 'newforum'){
		$forum->newforum();
	}
	if($_GET['action'] == 'newcat'){
		$forum->newcat();
	}
	if (($_GET['action'] == 'viewforum')){
		$forum->viewforum();
		$forum->forumAdminBar();
	}
	if(($_GET['action'] == 'viewpost')){
		$forum->vpost();
	}
	if(($_GET['action'] == 'posttopic')){
		$forum->upost();
		$forum->forumAdminBar();
	}
	if(($_GET['action'] == 'postreply')){
		$forum->postreply();
		$forum->forumAdminBar();
	}
	if(($_GET['action'] == 'reportpost')){
		$forum->rep();
		$forum->forumAdminBar();
	}
	if($_GET['action'] == 'adminposts'){
		$forum->forumPostAdmin();
	}
	if($_GET['action'] == 'deletecat'){
		$forum->deletecat();
	}
	if($_GET['action'] == 'deleteforum'){
		$forum->deleteforum();
	}
	if($_GET['action'] == 'forumDeletePost'){
		$forum->delp();
		$forum->forumAdminBar();
	}
	if($_GET['action'] == 'ForumHidePost'){
		$forum->hidep();
		$forum->forumAdminBar();
	}
	if($_GET['action'] == 'ForumUnHidePost'){
		$forum->unhidep();
		$forum->forumAdminBar();
	}
	if($_GET['action'] == 'adminreply'){
		$forum->forumReplyAdmin();
	}
	if($_GET['action'] == 'ForumHideReply'){
		$forum->hider();
		$forum->forumAdminBar();
	}
	if($_GET['action'] == 'ForumUnHideReply'){
		$forum->unhider();
		$forum->forumAdminBar();
	}
	if($_GET['action'] == 'forumDeleteReply'){
		$forum->delr();
		$forum->forumAdminBar();
	}
}
class Forums{
	public function forumAdminBar(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		if($core->verify("4") || $core->verify("2")){
		echo sprintf($layout['adminBar'], 'index.php?action=adminposts', 'Post');
		echo sprintf($layout['adminBar'], 'index.php?action=adminreply', 'Reply');
	}
	}
	public function newforum() {
		global $dbc, $parser, $layout, $main, $settings, $core;

		$core->isLoggedIn();
		echo '<div class="shadowbar">';
		if (isset($_POST['submit'])) {
			$catt = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['catt'])));	$desc = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['desc'])));
			$cg = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['cg'])));
			if (!empty($catt)) { 
				$query = "INSERT INTO categories (`name`, `desc`, `cg`) VALUES ('$catt', '$desc', '$cg')";
				mysqli_query($dbc, $query);
				echo '<p>Your forum has been successfully added. Would you like to go back to the <a href="index.php?action=acp">Admin Panel</a>?</p>';
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} 
		if($core->verify("4") || $core->verify("2")){
		echo'<form enctype="multipart/form-data" method="post" action="index.php?action=newforum">
		<fieldset>
		<legend>Create Forum:</legend>
			<label type="hidden" for="catt">Forum name:</label><br />
			<input type="text" name="catt"><br /><br />
			<label type="hidden" for="desc">Description</label><br />
			<textarea rows="4"  name="desc" id="desc" cols="100"></textarea><br>
			<select name="cg">';
		
		$query = "SELECT * FROM category_groups";

		$data = mysqli_query($dbc, $query);

		while ($row = mysqli_fetch_array($data)) {

			echo '<option value="'.$row['cg_id'].'">'.$row['cg_name'].'</option>';

		}

		echo'</select>
		</fieldset>
		<input type="submit" value="Save Forum" name="submit" />     
	</form>';
		echo '<table class"table">';
		echo '<thead><th>Forums</th></thead>';
		$query = "SELECT * FROM categories ORDER BY cat_id ASC";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			echo '<tr>';
			echo '<td>'.$row['name'].'<a href="index.php?action=deleteforum&f='.$row['cat_id'].'">Delete Forum</a></td></tr>';
		}
		
		echo'</table>';
		echo'</div>';
	}
	}
	public function deletecat(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
		if($core->verify("4") || $core->verify("2")){
		if (isset($_POST['submit'])) {
			$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
			if (!empty($postid)) {

				$query = "DELETE FROM category_groups WHERE cg_id = $postid";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>Category has been successfully deleted. Would you like to <a href="index.php?action=viewcategory">go back to the forums</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		}
		
		
		
		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=deletecat">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>';
		echo'<input type="hidden" name="postid" value="'.$_GET['cat'].'">
		</fieldset>
		<input type="submit" value="Delete" name="submit" />   <a class="button" href="index.php">Cancel</a> 
	</form>
	</div>';	
	}
	}
	public function deleteforum(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
		if($core->verify("4") || $core->verify("2")){
		if (isset($_POST['submit'])) {
			$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
			if (!empty($postid)) {

				$query = "DELETE FROM categories WHERE cat_id = $postid";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>Forum has been successfully deleted. Would you like to <a href="index.php?action=viewcategory">go back to the forums</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} 
		
		
		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=deleteforum">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>';
		echo'<input type="hidden" name="postid" value="'.$_GET['f'].'">
		</fieldset>
		<input type="submit" value="Delete" name="submit" />   <a class="button" href="index.php">Cancel</a> 
	</form>
	</div>';
	}
	}
	public function newcat() {
		global $dbc, $parser, $layout, $main, $settings, $core;

		$core->isLoggedIn();
		echo '<div class="shadowbar">';
		if (isset($_POST['submit'])) {
			$catt = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['catt'])));
			if (!empty($catt)) { 
				$query = "INSERT INTO category_groups (`cg_name`) VALUES ('$catt')";
				mysqli_query($dbc, $query);
				echo '<p>Your category has been successfully added. Would you like to go back to the <a href="index.php?action=acp">Admin Panel</a>?</p>';
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} 
		if($core->verify("4") || $core->verify("2")){
		echo'<form enctype="multipart/form-data" method="post" action="index.php?action=newcat">
		<fieldset>
		<legend>Create Category:</legend>
			<label type="hidden" for="catt">Category name:</label><br />
			<input type="text" name="catt"><br /><br />
		<input type="submit" value="Save Category" name="submit" />     
	</form>';
		echo '<table class"table">';
		echo '<thead><th>Categories</th></thead>';
		$query = "SELECT * FROM category_groups";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			echo '<tr>';
			echo '<td>'.$row['cg_name'].' <a href="index.php?action=deletecat&cat='.$row['cg_id'].'">Delete Category</a></td></tr>';
		}
		
		echo'</table>';
		echo'</div>';
	}
	}
	public function category(){
		echo '<div class="shadowbar">';
		global $dbc, $parser, $layout, $main, $settings, $core;
		if($core->verify("4") || $core->verify("2")){
			echo '<a class="Link LButton" href="index.php?action=newcat">New Category</a><a class="Link LButton" href="index.php?action=newforum">New Forum</a>';
		}
		$query = "SELECT * FROM category_groups";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			$category = $row['cg_id'];
			echo '<table class="table cgBox">';
			echo '<thead>';
			echo '<h3>'.$row['cg_name'].'</h3>';
			echo '<th>Forum</th>';
			echo '<th>Latest Posts</th>';
			echo '</thead>';
			echo'<tbody>';
			$query1 = "SELECT * FROM categories WHERE cg = ".$category." ORDER BY cat_id ASC";
			$data1 = mysqli_query($dbc, $query1);
			while ($row1 = mysqli_fetch_array($data1)) {
				$query2 = "SELECT users.*, posts.* FROM posts JOIN users ON users.uid = posts.user_id AND category = ".$row1['cat_id']." AND hidden = '0' ORDER BY post_id DESC";
				$count = mysqli_query($dbc, $query2);
				$rc = mysqli_fetch_array($count);
				echo'<tr>';
				echo'<td><a class="nav" href="index.php?action=viewforum&cat='.$row1['cat_id'].'">' .$row1['name']. '<span class="badge">' . mysqli_num_rows($count) . ' Post(s)</span></a>';
				echo'<div class="col-md-6">'.$row1['desc'].'</div>';
				echo'</td>';
				echo'<td>';
				if((mysqli_num_rows($count) > 0)){ 
					echo'<a href="index.php?action=viewpost&post_id='.$rc['post_id'].'">'.$rc['title'].'</a><br>';
					echo'By: <a href="index.php?action=ucp&uid='.$rc['uid'].'">' . $rc['username'] . '</a>';
				}
				echo'</td></tr>';
			}
		}
		echo '</tbody></table></div>';
	}
	/*
		while ($row = mysqli_fetch_array($data)) {
		$query2 = "SELECT user.*, posts.* FROM posts JOIN user ON user.id = posts.id AND category = ".$row['cat_id']." AND hidden = '0' ORDER BY post_id DESC";
		$count = mysqli_query($dbc, $query2);
			$rc = mysqli_fetch_array($count);
			
			if(!empty($row['name'])) {
				echo'<tr>';
				echo '<div class="col-md-10 cgBox">';
				echo '<h3>'.$row['cg_name'].'</h3>';
				echo'<td><a class="nav" href="index.php?action=viewforum&cat='.$row['cat_id'].'">' .$row['name']. '<span class="badge">' . mysqli_num_rows($count) . ' Post(s)</span></a>';
				echo $row['desc'];
				echo'</td>';
				echo'<td>';
				if((mysqli_num_rows($count) > 0)){
				echo'<a href="index.php?action=viewpost&post_id='.$rc['post_id'].'">'.$rc['title'].'</a><br>';
				echo'By: <a href="index.php?action=ucp&id='.$rc['id'].'">' . $rc['username'] . '</a>';
				}
				echo'</td></div></tr>';
			}

		}
		echo '</tbody></table></div>';
}
*/
	public function viewforum(){
		echo '<div class="shadowbar">';
		global $dbc;
		$secureCategory = preg_replace("/[^0-9]/", "", $_GET['cat']);
		$cat = mysqli_real_escape_string($dbc, $secureCategory);
		$query = "SELECT posts.*, users.* FROM posts JOIN users ON users.uid = posts.user_id AND category = '".$cat."' AND hidden = '0' ORDER BY posts.post_id DESC";
		$data = mysqli_query($dbc, $query);
		echo '<table class="table">';
		echo '<thead>';
		echo '<th>Post Title</th>';
		echo '<th>Latest Posts</th>';
		echo '</thead>';
		echo '<tbody>';
		while ($row = mysqli_fetch_array($data)) {
			$query2 = "SELECT users.*, reply.* FROM reply JOIN users ON users.uid = reply.user_id AND post_id = ".$row['post_id']." AND hidden = '0' ";
			$count = mysqli_query($dbc, $query2);
			$rc = mysqli_fetch_array($count);
			if(!empty($row['title'])) {
				echo'<tr>';
				echo'<td>';
				if(($row['locked'] === '1')){ 
					echo'<a class="nav" href="index.php?action=viewpost&post_id='.$row['post_id'].'"><img width="25px" height="25px" src="include/images/lock.png" />' .$row['title']. '<span class="badge">' . mysqli_num_rows($count) . ' Replies</span></a>';  
				} else {
					echo'<a class="nav" href="index.php?action=viewpost&post_id='.$row['post_id'].'">' .$row['title']. '<span class="badge">' . mysqli_num_rows($count) . ' Replies</span></a>';
				}
				echo'</td>';
				echo'<td>';
				echo'Posted By:';
				echo '<a href="index.php?action=ucp&uid='.$row['uid'].'">' . $row['username'] . '</a>';
				echo'</td>';
			}
			
		}
		echo '</tbody></table></div>';
	}

	public function vpost() {
		echo '<div class="shadowbar">';
		global $dbc, $parser, $layout, $main, $settings, $core;
		$secureCategory = preg_replace("/[^0-9]/", "", $_GET['post_id']);
		$postid = mysqli_real_escape_string($dbc, $secureCategory);
		if(isset($_GET['mode']) && ($_GET['mode'] === 'lock')){
			if($core->verify("2") || $core->verify("4")){
				$query = "UPDATE posts SET locked = 1 WHERE post_id = '$postid'";
				mysqli_query($dbc, $query);
				echo '<div class="alert alert-info"><strong>Post Locked</strong></div>';
			}
		}
		$query = "SELECT posts.*, users.* FROM posts JOIN users ON users.uid = posts.user_id AND posts.post_id = $postid AND hidden = '0'";
		$data = mysqli_query($dbc, $query);
		if($core->verify("2") || $core->verify("4")){
			echo '<a class="Link LButton" href="index.php?action=viewpost&post_id='.$postid.'&mode=lock">Lock Post</a><br>';
		}
		while ($row = mysqli_fetch_array($data)) {
			$replyTitle = $row['title'];
			if(($row['locked'] != '1')){
				echo '<a class="Link LButton" href="index.php?action=postreply&postid='.$_GET['post_id'].'">Reply</a>';
			}
			$titler = $row['title'];
			$parsed = $parser->parse($row['post']);
			$sig = $parser->parse($row['sig']);
			echo sprintf($layout['blogViewFormat'], $row['title'], $row['picture'], $row['uid'], $row['username'], date('M j Y g:i A', strtotime($row['date'])), $parsed, $sig);
		}
		
		//error_reporting(E_ALL);
		global $dbc;;
		// Grab the profile data from the database
		$query = "SELECT reply.*, users.* FROM reply JOIN users ON users.uid = reply.user_id AND reply.post_id = $postid AND hidden = '0'";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			$parsed = $parser->parse($row['reply']);
			$sig = $parser->parse($row['sig']);
			echo sprintf($layout['blogViewFormat'], $replyTitle, $row['picture'], $row['uid'], $row['username'], date('M j Y g:i A', strtotime($row['date'])), $parsed, $sig);	
		}

		echo '</div></div></div><br />';
	}

	public function rep() {
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
		$secureCategory = preg_replace("/[^0-9]/", "", $_GET['pid']);
		$postid = mysqli_real_escape_string($dbc, $secureCategory);
		$query = "UPDATE posts SET reported = '1' WHERE post_id = '$postid'";
		$data = mysqli_query($dbc, $query);
		echo '<div class="shadowbar">
			<h3>Post Reported</h3>';
		echo 'Post Reported.';
		echo '</div>';
	}

	public function upost(){
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
			$post1 = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['post1'])));
			$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
			$category = mysqli_real_escape_string($dbc, trim($_POST['category']));
			// Update the post data in the database
			if (!empty($post1) && !empty($title)) {
				$query = "INSERT INTO posts (`user_id`, `date`, `title`, `post`, `category`) VALUES ('$username', NOW(), '$title', '$post1', '$category')";
				mysqli_query($dbc, $query);
				echo '<p>Your post has been successfully added. Would you like to <a href="index.php?action=viewcategory">view all of the posts</a>?</p>';
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} // End of check for form submission
		echo'<form enctype="multipart/form-data" method="post" action="index.php?action=posttopic">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Post Here:</legend>
			<label type="hidden" for="title">Title:</label><br />
			<input type="text" name="title"><br /><br />';
		global $dbc; 
		echo'<select id="category" name="category">';
		$query = "SELECT * FROM categories";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			echo '<option value="'.$row['cat_id'].'">'.$row['name'].'</option>';
		}
		echo'</select><br /><br />';	
		echo'<label type="hidden" for="post1">Post Content:</label><br />
		<textarea rows="4"  name="post1" id="post1" cols="50"></textarea><br />
		</fieldset>
		<input type="submit" value="Save Post" name="submit" />     
	</form>
	</div>';
	}
	public function delp(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
if($core->verify("4") || $core->verify("2")){

		if (isset($_POST['submit'])) {
			$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
			if (!empty($postid)) {

				$query = "DELETE FROM posts WHERE post_id = $postid";
				mysqli_query($dbc, $query);
				echo '<div class="shadowbar"><p>Post has been successfully deleted. Would you like to <a href="index.php">go back to the admin panel</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} 
		
		
		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=forumDeletePost&mode=delete">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>';
		echo'<input type="hidden" name="postid" value="'.$_GET['del'].'">
		</fieldset>
		<input type="submit" value="Delete Post" name="submit" />   <a class="button" href="index.php?action=acp">Cancel</a> 
	</form>
	</div>';
		
	}
	}
	public function hider(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();

		if($core->verify("2") || $core->verify("4")){
			if (isset($_POST['submit'])) {
				$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
				if (!empty($postid)) {

					$query = "UPDATE reply SET `hidden` = '1' WHERE reply_id = $postid";
					mysqli_query($dbc, $query);
					echo '<div class="shadowbar"><p>Post has been successfully hidden. Would you like to <a href="index.php?action=forumReplyAdmin">go back to replies</a>?</p></div>';
					
					exit();
				}
				else {
					echo '<p class="error">You must enter information into all of the fields.</p>';
				}
			} 
			
			echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=ForumHideReply&mode=hide">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>';
			echo'<input type="hidden" name="postid" value="'.$_GET['del'].'">
		</fieldset>
		<input type="submit" value="Hide Post" name="submit" />   <a class="button" href="mcp.php">Cancel</a> 
	</form>
	</div>';
			
		}
	}
	public function hidep(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
		if($core->verify("2") || $core->verify("4")){
			if (isset($_POST['submit'])) {
				$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
				if (!empty($postid)) {

					$query = "UPDATE posts SET `hidden` = '1' WHERE post_id = $postid";
					mysqli_query($dbc, $query);
					echo '<div class="shadowbar"><p>Post has been successfully hidden. Would you like to <a class="Link LButton" href="index.php?action=acp">go back to the admin panel</a>?</p></div>';
					
					exit();
				}
				else {
					echo '<p class="error">You must enter information into all of the fields.</p>';
				}
			} 
			
			echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=ForumHidePost&mode=hide">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>';
			echo'<input type="hidden" name="postid" value="'.$_GET['del'].'">
		</fieldset>
		<input type="submit" value="Hide Post" name="submit" />   <a class="button" href="mcp.php">Cancel</a> 
	</form>
	</div>';
			
		}
	}
	public function unhidep(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn(); 
		if($core->verify("2") || $core->verify("4")){
			if (isset($_POST['submit'])) {
				$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
				if (!empty($postid)) {

					$query = "UPDATE posts SET `hidden` = '0' WHERE post_id = $postid";
					mysqli_query($dbc, $query);
					echo '<div class="shadowbar"><p>Post has been successfully unhidden. Would you like to <a class="Link LButton" href="index.php?action=acp">go back to the Admin panel</a>?</p></div>';
					
					exit();
				}
				else {
					echo '<p class="error">You must enter information into all of the fields.</p>';
				}
			} 
			
			
			echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=ForumUnHidePost&mode=unhide">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>';
			echo'<input type="hidden" name="postid" value="'.$_GET['del'].'">
		</fieldset>
		<input type="submit" value="Unhide Post" name="submit" />   <a class="button" href="mcp.php">Cancel</a> 
	</form>
	</div>';
			
		}
	}
	public function unhider(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();

		if($core->verify("2") || $core->verify("4")){
			if (isset($_POST['submit'])) {
				$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
				if (!empty($postid)) {

					$query = "UPDATE reply SET `hidden` = '0' WHERE reply_id = $postid";
					mysqli_query($dbc, $query);
					echo '<div class="shadowbar"><p>Post has been successfully hidden. Would you like to <a href="index.php?action=forumReplyAdmin">go back to replies</a>?</p></div>';
					
					exit();
				}
				else {
					echo '<p class="error">You must enter information into all of the fields.</p>';
				}
			} 
			
			
			echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=ForumUnHideReply&mode=unhide">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>';
			echo'<input type="hidden" name="postid" value="'.$_GET['del'].'">
		</fieldset>
		<input type="submit" value="Unhide Post" name="submit" />   <a class="button" href="mcp.php">Cancel</a> 
	</form>
	</div>';
			
		}
	}
	public function delr(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
		if($core->verify("2") || $core->verify("4")){
			if (isset($_POST['submit'])) {
				$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
				if (!empty($postid)) {

					$query = "DELETE FROM reply WHERE reply_id = $postid";
					mysqli_query($dbc, $query);
					echo '<div class="shadowbar"><p> has been successfully deleted. Would you like to <a href="index.php?action=forumReplyAdmin">go back to replies</a>?</p></div>';
					
					exit();
				}
				else {
					echo '<p class="error">You must enter information into all of the fields.</p>';
				}
			} 
			
			
			echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=forumDeleteReply&mode=dr">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Are you sure?</legend>';
			echo'<input type="hidden" name="postid" value="'.$_GET['del'].'">
		</fieldset>
		<input type="submit" value="Delete Post" name="submit" />   <a class="button" href="mcp.php">Cancel</a> 
	</form>
	</div>';
			
		}
	}
	public function postreply(){
		global $dbc, $core;
		$core->isLoggedIn();
		if(isset($_GET['postid'])){
			$secureCategory = preg_replace("/[^0-9]/", "", $_GET['postid']);
			$postid = mysqli_real_escape_string($dbc, $secureCategory);
			$query = "SELECT locked FROM posts WHERE post_id = '$postid'";

			$data = mysqli_query($dbc, $query);

			$row = mysqli_fetch_array($data);
			if(($row['locked'] === '1')){
				echo '<div class="shadowbar"><h3>Reply</h3><p>Post is locked. Cannot reply.</p></div>';
				exit();
			}
		}
		
		// Grab the profile data from the database

		$query = "SELECT uid FROM users WHERE uid = '" . $_SESSION['uid'] . "'";

		$data = mysqli_query($dbc, $query);

		$row = mysqli_fetch_array($data);

		$username = $row['uid'];



		

		if (isset($_POST['submit'])) {
			// Grab the profile data from the POST
			$reply = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['reply'])));
			$secureCategory = preg_replace("/[^0-9]/", "", $_POST['replyid']);
			$replyid = mysqli_real_escape_string($dbc, $secureCategory);
			// Update the post data in the database
			if (!empty($reply)) {
				$link = 'index.php?action=viewpost&post_id='.$replyid;
				$description = 'Someone has replied to a post you are involved in';
				$infoquery = "SELECT DISTINCT `user_id` FROM reply WHERE `post_id` = '" .$replyid. "' AND `user_id` !='".$username."' ";
				$data = mysqli_query($dbc, $infoquery);
				while ($rows = mysqli_fetch_array($data)){
				$core->addNotification($rows['user_id'], $link, $description);
				}
				$link = 'index.php?action=viewpost&post_id='.$replyid;
				$description = 'Someone has replied to your post';
				$infoquery = "SELECT DISTINCT `user_id` FROM posts WHERE `post_id` = '" .$replyid. "' ";
				$data = mysqli_query($dbc, $infoquery);
				$rows = mysqli_fetch_array($data);
				if($rows['user_id'] != $_SESSION['uid']){
				$core->addNotification($rows['user_id'], $link, $description);
				}
				
				// Only set the picture column if there is a new picture
				$query = "INSERT INTO reply (`post_id`, `user_id`, `reply`, `date`) VALUES ('$replyid', '$username', '$reply', NOW())";
				mysqli_query($dbc, $query) or die(mysqli_error($dbc));
				// Confirm success with the user
				echo '<div class="shadowbar"><p>Your post has been successfully added. Would you like to <a href="index.php?action=viewcategory">view all of the posts</a>?</p></div>';
				exit();
			}
			else {
				echo '<div class="shadowbar"><p class="error">You must enter information into all of the fields.</p></div>';
			}
		} // End of check for form submission
		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=postreply">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
		<fieldset>
		<legend>Reply:</legend>
		<input type="hidden" name="replyid" value="'.$_GET['postid'].'">
		<textarea rows="4"  name="reply" id="reply" cols="50"></textarea><br />
		</fieldset>
		<input type="submit" value="Save Post" name="submit" />    <a class="button" href="index.php?action=vp&post_id='.$_GET['postid'].'">Cancel</a> 
	</form>
	</div>';
	}
	public function forumReplyAdmin(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		echo '<div class="shadowbar">';
		$core->isLoggedIn();
		

		if($core->verify("4") || $core->verify("2")){


		$query = "SELECT reply.*, users.* FROM reply JOIN users ON users.uid = reply.user_id ORDER BY reply.reply_id DESC ";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			$parsed = $parser->parse($row['reply']);
			echo sprintf($layout['adminPostLayout'], 'N/A', $parsed, $row['reply_id'], 'forumDeleteReply', 'delete', $row['reply_id'], $row['hidden'], 'ForumHideReply', $row['reply_id'], 'ForumUnHideReply', $row['reply_id'], $row['username'], $row['adminlevel']);
		}
		echo '</div>';
	}
	}
	public function forumPostAdmin(){
		global $settings, $version, $dbc, $layout, $core, $parser;
		echo '<div class="shadowbar">';
		$core->isLoggedIn();
		

		if($core->verify("4") || $core->verify("2")){


		$query = "SELECT posts.*, users.* FROM posts JOIN users ON users.uid = posts.user_id ORDER BY posts.post_id DESC ";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			$parsed = $parser->parse($row['post']);
			echo sprintf($layout['adminPostLayout'], $row['title'], $parsed, $row['post_id'], 'forumDeletePost', 'delete', $row['post_id'], $row['hidden'], 'ForumHidePost', $row['post_id'], 'ForumUnHidePost', $row['post_id'], $row['username'], $row['adminlevel']);
		}
		echo '</div>';
	}
	}
}
?>