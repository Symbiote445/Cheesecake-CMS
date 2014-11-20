	<style>
.imgHolder { 
	display:none;
    position: absolute;
    display: block;
    border: 3px solid red;
    margin: auto;
    top: 0;
    left: 0;
    right: 0;
	z-index:1000;
	border-radius:16px;
	background:#E9EAED;
overflow:hidden;
 }

.close { padding:5px; }
	</style>
	<script type="text/javascript">
var observe;
if (window.attachEvent) {
    observe = function (element, event, handler) {
        element.attachEvent('on'+event, handler);
    };
}
else {
    observe = function (element, event, handler) {
        element.addEventListener(event, handler, false);
    };
}
function init () {
    var text = document.getElementById('text');
    function resize () {
        text.style.height = 'auto';
        text.style.height = text.scrollHeight+'px';
    }
    /* 0-timeout to get the already changed text */
    function delayedResize () {
        window.setTimeout(resize, 0);
    }
    observe(text, 'change',  resize);
    observe(text, 'cut',     delayedResize);
    observe(text, 'paste',   delayedResize);
    observe(text, 'drop',    delayedResize);
    observe(text, 'keydown', delayedResize);
    resize();
}

$(document).ready(function(){
    $('.city').click(function(){
    
        $('.imgHolder').children("img").attr("src", $(this).data("img"));
        $('.imgHolder').show();
    
    });
    
    $('.close').click(function(){
        $('.imgHolder').hide();
    });
});

</script>

<?php
/*
CheesecakePortal 1.0 Gallery Module
*/
$galleryClass = new gallery;
if(isset($_GET['action'])){
	if (($_GET['action'] === 'viewgallery')){
	$galleryClass->vg();
	}
	if(($_GET['action'] === 'uploadphoto')) {
	$galleryClass->uloadp();
	}
}
class gallery{
	function vg(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		echo'<div class="shadowbar">
			<div class="imgHolder" style="display:none;">
			<div class="close">X</div>
				<img style="max-height:500px" src="" /> 
			</div>';
		echo'<h3>Gallery</h3>';
		if($core->verify("4") || $core->verify("2")){
		echo '<a class="Link LButton" href="index.php?action=uploadphoto">Upload File To Gallery </a><br>';
		}
		$secureLimit = preg_replace("/[^0-9]/", "", $_GET['limit']);
		$limit = mysqli_real_escape_string($dbc, $secureLimit);
		$query = "SELECT * FROM gallery ORDER BY p_id LIMIT $limit,1";
		mysqli_query($dbc, $query);
		$data = mysqli_query($dbc, $query);
		while($row = mysqli_fetch_array($data)){
		echo '<div class="gci"> ';
			if(!empty($row['filename'])){
				echo'<img class="city" style="max-height:100px" data-img="include/images/'.$row['filename'].'" src="'.MM_GALLERY, $row['filename'].'"><br />';
			}
			if(!empty($row['name'])){
				echo '<strong>'.$row['name'] . '</strong><br />';
			}
			if(!empty($row['descr'])){
				echo $row['descr'];
			}
			
			echo '</div>';
		}
		echo '<a class="Link LButton" href="index.php?action=vg&limit='.($limit - 1).'">Previous </a><a class="Link LButton" href="index.php?action=vg&limit='.($limit + 1).'"> Next</a>';
		echo '</div>';
	}
	
	function uloadp(){
	
		global $dbc, $parser, $layout, $main, $settings, $core;
		if (!isset($_SESSION['user_id'])) {
			echo '<p class="login">Please <a href="ucp.php?action=login">log in</a> to access this page.</p>';
			exit();
		}
		else {
			echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '. <a href="ucp.php?action=logout">Log out</a>.</p>');
		}
		if($core->verify("4") || $core->verify("2")){
		echo '<div class="shadowbar">
		<h3>Photo Upload</h3>';
		if (isset($_POST['submit'])) {
		$query = "SELECT * FROM gallery";
		$data = mysqli_query($dbc, $query);
		$pnum = mysqli_num_rows($data);
		$pnumu = ($pnum + 1);
			$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			$filename = mysqli_real_escape_string($dbc, trim($_FILES["file"]["name"]));
			$name = mysqli_real_escape_string($dbc, trim($_POST['name']));
			$desc = mysqli_real_escape_string($dbc, trim($_POST['desc']));
			$pnumname = 'galleryUploadNumber'.$pnumu.'.'.$extension;
			$user = $_SESSION['user_id'];
			if ((($_FILES["file"]["type"] == "image/gif")
						|| ($_FILES["file"]["type"] == "image/jpeg")
						|| ($_FILES["file"]["type"] == "image/jpg")
						|| ($_FILES["file"]["type"] == "image/pjpeg")
						|| ($_FILES["file"]["type"] == "image/x-png")
						|| ($_FILES["file"]["type"] == "image/png"))
					&& ($_FILES["file"]["size"] < 5000000)
					&& in_array($extension, $allowedExts)) {
				if ($_FILES["file"]["error"] > 0) {
					echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
				} else {
					if (file_exists("include/images" . $pnumname)) {
						echo '<p class="error">' . $_FILES["file"]["name"] . ' already exists.</p>';
						exit();
					} else {
					$query = "INSERT INTO gallery SET `picture` = '$pnumname' WHERE user_id = '".$_SESSION['user_id']."'";
					mysqli_query($dbc, $query);
						move_uploaded_file($_FILES["file"]["tmp_name"],
						"include/images/" . $pnumname);
						$query = "INSERT INTO gallery (name, descr, filename) VALUES ('$name', '$desc', '$pnumname')";
						mysqli_query($dbc, $query);
						echo "Success!";
						exit();
					}
				}
			} else {
				echo '<p class="error">Invalid file</p>';
			}
		}
		
		
		echo'<form enctype="multipart/form-data" method="post" action="index.php?action=up">
		<fieldset>
		<legend>Picture Upload</legend>
		<label for="name">Picture Name:</label><br />
		<input type="text" id="name" name="name" value="" /><br />
		<label for="desc">Description</label><br />
		<textarea id="desc" name="desc" rows="4" cols="30"></textarea><br />
		<label for="file">Picture:</label>';
		echo'<input type="file" id="file" name="file" />
		</fieldset>
		<input type="submit" value="Save Picture" name="submit" /> <a class="button" href="acp.php">Cancel</a>
	</form>
	</div>';
	} else {
	die("<p style=\"color: white;\">Insufficient Permissions</p>");
	}
	echo '</div>';
	}
	}

?>