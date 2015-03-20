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
		if($core->verify("pages.*") || $core->verify("pages.addPage")){
		if (isset($_POST['submit'])) {
			$page = mysqli_real_escape_string($dbc, trim($_POST['page']));
			$title = mysqli_real_escape_string($dbc, trim($_POST['title']));
			if (!empty($page) && !empty($title)) {

				$query = "INSERT INTO pages (`pagename`, `body`) VALUES ('$title', '$page')";
				mysqli_query($dbc, $query);

				echo '<div class="shadowbar"><p>Your page has been successfully added. Would you like to <a href="/pages/mode/pageadmin">go back to the admin panel</a>?</p></div>';
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
			$query = "SELECT * FROM `pages` WHERE `pagename` = '$title'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			$pid = $row['page_id'];
			$pagelink = $title.'-'.$pid;
			//Lower case everything
			$pagelink = strtolower($pagelink);
			//Make alphanumeric (removes all other characters)
			$pagelink = preg_replace("/[^a-z0-9_\s-]/", "", $pagelink);
			//Clean up multiple dashes or whitespaces
			$pagelink = preg_replace("/[\s-]+/", " ", $pagelink);
			//Convert whitespaces and underscore to dash
			$pagelink = preg_replace("/[\s_]/", "-", $pagelink);	
			$query = "UPDATE `pages` SET `pagelink` = '$pagelink' WHERE `page_id` = '$pid'";
			mysqli_query($dbc, $query);


		}
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
			$ID = $row['page_id'];
			echo '<div class="shadowbar">';
			echo'<h3>' . $row['pagename'] . '</h3>';
			$parsed = $parser->parse($row['body']);
			echo $parsed;
			echo '</div>'; 
			$query = "SELECT users.*, comments.* FROM `comments` JOIN `users` ON `user` = `uid` AND `module` = 'pages' AND `id` = '$ID'";
			$data = mysqli_query($dbc, $query);
			while($row = mysqli_fetch_array($data)){
				$body = htmlentities($row['body']);
				echo '<div class="shadowbar">';
				echo '<a href="/ucp/'.$row['uid'].'">' . $row['username'] . '</a><hr style="padding:0; margins:0;" />';
				echo '<pre>'.$body.'</pre>';
				echo '</div>';
			}
			if(isset($_SESSION['uid'])){
				$UID = $_SESSION['uid'];
			echo (
			<<<EOD
			<div class="shadowbar" style="display:none;" id="prev"><div id="cmm"></div></div>
			<div class="shadowbar">
			<div id="alert"></div>
			<form id="commentForm" method="post" action="/postComment">
			<textarea class="editor" style="width:100%;" placeholder="Comment..." id="rs" name="comment"></textarea>
			<input type="hidden" value="$UID" name="user" id="user">
			<input type="hidden" value="pages" name="module">
			<input type="hidden" value="$ID" name="id">
			<input class="Link LButton" type="submit" value="&#10004;" name="submit">
			</form>
			</div>
		<script>
    $(function comment() {
    $("#commentForm").validate({ // initialize the plugin
        // any other options,
        onkeyup: false,
        rules: {
            comment: {
                required: true,
                minlength: 30,
				maxlength: 400
            }
        }
    });
    $('#commentForm').ajaxForm({
        beforeSend: function() {
			return $("#commentForm").valid();
        },
				success : function(result) {
					console.log(result);
					if(result == " success"){
						body = $("#rs").val();
						htm = String(body).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
						cmm = "<a href='/ucp/uid/" + $("#user").val();
						cmm += "'>Me</a><hr>" + htm;
						cmm += "</div>";
						$("#cmm").html(cmm);
						$("#prev").show();
					}else if(result == " failure"){
						$("#alert").html("<div class='alert alert-warning'>Error</div>");
						document.getElementById("commentForm").reset();
						//$("#alert").show();
					}
			   }
    });
    }); 
</script>
EOD
			);
			}
		}
	}
	public function pageadmin(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		if($core->verify("pages.*")){
		global $dbc, $parser, $layout, $main, $settings, $core; 	
		if(isset($_GET['pagename'])){
			$pagename = mysqli_real_escape_string($dbc, $_GET['pagename']);
			$query = "DELETE FROM pages WHERE pagelink = '$pagename'";
			mysqli_query($dbc, $query);
			echo 'Page Deleted. <a href="/pages">Back to pages</a><br>';
		}	
		$query = "SELECT * FROM pages";
		$data = mysqli_query($dbc, $query);
		echo'<div class="shadowbar"><legend>Page Admin</legend><table class="table"><thead><th>Page Name</th><th>Options</th></thead>';
		while($row = mysqli_fetch_array($data)){
			echo '<tr><td>'.$row['pagename'].'</td><td><a class="Link LButton" href="/pages/mode/pageadmin/pagename/'.$row['pagelink'].'"> Delete Page</a><a class="Link LButton" href="/pages/mode/edit/page/'.$row['page_id'].'"> Edit Page</a></td></tr>';
		}
		echo '</table></div>';
		
		}
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
		echo '<h3>Pages</h3>
		<table class="table">
		<thead>
		<th>Page Title</th>
		</th>';
		while ($row = mysqli_fetch_array($data)) {

			if(!empty($row['pagename'])) {
				echo'<tr><td><a href="/pages/'.$row['pagelink'].'">'.$row['pagename'].'</a></td></tr>';
			}
		}
		echo '</table><a class="Link LButton" href="/pages/f/'.($f - 5).'">Previous</a><a class="Link LButton" href="/pages/f/'.($f + 5).'">Next</a>';
		echo '</div>'; 
	}
	public function editPage(){
		global $dbc, $parser, $layout, $main, $settings, $core;

		if($core->verify("pages.*") || $core->verify("pages.editPage")){
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
}
?>