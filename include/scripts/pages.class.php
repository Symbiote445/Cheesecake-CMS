<?php
//Pages
$pages = new pages;
if(isset($_GET['action']) && ($_GET['action'] == "pages")){
	$pages->page();

	if($_GET['action'] === 'pages' && !isset($_GET['page'])) {
		$pages->pagelist();
	}
	$pages->pagesAdminBar();

	if(isset($_GET['mode'])){
		if($_GET['mode'] == "edit"){
			$pages->editPage();
		}
		if($_GET['mode'] == "addpage"){
			$pages->addpage();
		}
		if($_GET['mode'] == "pageadmin"){
			$pages->pageadmin();
		}
		$pages->pagesAdminBar();
	}
}


class pages{
	public function pagesAdminBar(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		echo sprintf($layout['adminBar'], '/pages/mode/pageadmin', 'Page');
	}
	static function stats(){
		global $dbc;
		$query = "SELECT * FROM pages";
		$data = mysqli_query($dbc, $query);
		$pcount = mysqli_num_rows($data);
		$day = date("j");
		$month = date("M");
		$year = date("Y");
		$filename = $day . $month . $year . '.dat';
		$str = "Pages: \r\n Pages: $pcount \r\n";
		file_put_contents("include/".$filename, $str, FILE_APPEND);
		echo '<div class="shadowbar">Pages stats finished...</div>';		
	}
	public function addpage(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
		if (isset($_POST['submit'])) {
			$page = mysqli_real_escape_string($dbc, trim($_POST['page']));
			$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
			//Lower case everything
			$pagelink = strtolower($title);
			//Make alphanumeric (removes all other characters)
			$pagelink = preg_replace("/[^a-z0-9_\s-]/", "", $pagelink);
			//Clean up multiple dashes or whitespaces
			$pagelink = preg_replace("/[\s-]+/", " ", $pagelink);
			//Convert whitespaces and underscore to dash
			$pagelink = preg_replace("/[\s_]/", "-", $pagelink);		

			$query = "SELECT * FROM pages WHERE pagelink = '$pagelink'";
			$data = mysqli_query($dbc, $query);
			if((mysqli_num_rows($data)) > 0){
				echo 'Page already exists. Try a different name.';
			}
			
			elseif (!empty($page) && !empty($title)) {

				$query = "INSERT INTO pages (`pagename`, `body`, `pagelink`) VALUES ('$title', '$page', '$pagelink')";
				mysqli_query($dbc, $query);

				echo '<div class="shadowbar"><p>Your page has been successfully added. Would you like to <a href="/pages/mode/pageadmin">go back to the admin panel</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		}
		if($core->verify("4") || $core->verify("2")){
			print($layout['adminPageAddLayout']);
		}
	}
	public function page(){
		global $dbc, $parser, $layout, $main, $settings, $core;

		if(isset($_GET['page'])){
			$page = mysqli_real_escape_string($dbc, $_GET['page']);

			if(!isset($_GET['page']) && !isset($_GET['action'])){
				$page = $settings['home_display'];
			}
			$query = "SELECT * FROM pages WHERE pagelink = '$page'";
			$data = mysqli_query($dbc, $query);

			$row = mysqli_fetch_array($data);
			echo '<div class="shadowbar">';
			echo'<h3>' . $row['pagename'] . '</h3>';
			$parsed = $parser->parse($row['body']);
			echo '<pre>'.$parsed.'</pre>';
			echo '</div>'; 
		}
	}
	public function pageadmin(){
		global $dbc, $parser, $layout, $main, $settings, $core;

		echo '';
		if(!$core->verify("4")){
			exit();
		}
		global $dbc, $parser, $layout, $main, $settings, $core; 	
		if(isset($_GET['pagename'])){
			$pagename = mysqli_real_escape_string($dbc, $_GET['pagename']);
			$query = "DELETE FROM pages WHERE pagename = '$pagename'";
			mysqli_query($dbc, $query);
			echo 'Page Deleted. <a href="/pages">Back to pages</a><br>';
		}	
		$query = "SELECT * FROM pages";
		$data = mysqli_query($dbc, $query);
		echo'<div class="shadowbar"><legend>Page Admin</legend><table class="table"><thead><th>Page Name</th><th>Options</th></thead>';
		while($row = mysqli_fetch_array($data)){
			echo '<tr><td>'.$row['pagename'].'</td><td><a class="Link LButton" href="/pages/mode/pageadmin/pagename/'.$row['pagename'].'"> Delete Page</a><a class="Link LButton" href="/pages/mode/edit/page/'.$row['page_id'].'"> Edit Page</a></td></tr>';
		}
		echo '</table></div>';
		
		
	}
	public function pagelist(){
		global $dbc;
		if(!isset($_GET['f'])){
			$f = 0;
		} else {
			$secureF = preg_replace("/[^0-9]/", "", $_GET['f']);
			$f = mysqli_real_escape_string($dbc, $secureF);
		}
		$query = "SELECT * FROM pages LIMIT $f,5";
		$data = mysqli_query($dbc, $query);
		echo '<div class="shadowbar">';
		echo '<h3>Pages</h3><table class="table">';
		while ($row = mysqli_fetch_array($data)) {

			if(!empty($row['pagename'])) {
				echo'<tr><td><a href="/pages/page/'.$row['pagelink'].'">'.$row['pagename'].'</a><br><hr style="margin:5px;"></td></tr>';
			}
		}
		echo '</table><a class="Link LButton" href="/pages/f/'.($f - 5).'">Previous</a><a class="Link LButton" href="/pages/f/'.($f + 5).'">Next</a>';
		echo '</div>'; 
	}
	public function editPage(){
		global $dbc, $parser, $layout, $main, $settings, $core;

		if(!$core->verify("4")){
			die('Insufficient Permissions.');
		}
		if(isset($_POST['submit'])){
			$content = mysqli_real_escape_string($dbc, trim($_POST['content']));
			$page = mysqli_real_escape_string($dbc, trim($_POST['page']));
			$query = "UPDATE `pages` SET `body` = '$content' WHERE `page_id` = '$page'";
			mysqli_query($dbc, $query);
			$msg = 'Page edited.';
		}
		echo '<div class="shadowbar">';
		if(isset($_GET['page'])){
			$securePage = preg_replace("/[^0-9]/", "", $_GET['page']);
			$page = mysqli_real_escape_string($dbc, $securePage);
			$query = "SELECT body, page_id FROM pages WHERE page_id = '$page'";
			$data = mysqli_query($dbc, $query);		
			$row = mysqli_fetch_array($data);
			echo sprintf($layout['adminPageEditLayout'], $row['body'], $row['page_id']);
		} else {
			if(isset($msg)){
				echo '<div class="alert alert-success">'.$msg.'</div>';
			}
		}
		echo'</div>';
	}
}
?>