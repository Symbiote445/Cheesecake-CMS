	<style>
.og-grid {
	list-style: none;
	padding: 20px 0;
	margin: 0 auto;
	text-align: center;
	width: 100%;
}

.og-grid li {
	display: inline-block;
	margin: 10px 5px 0 5px;
	vertical-align: top;
	height: 250px;
}

.og-grid li > a,
.og-grid li > a img {
	border: none;
	outline: none;
	display: block;
	position: relative;
}

.og-grid li.og-expanded > a::after {
	top: auto;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
	border-bottom-color: #ddd;
	border-width: 15px;
	left: 50%;
	margin: -20px 0 0 -15px;
}

.og-expander {
	position: absolute;
	background: #ddd;
	top: auto;
	left: 0;
	width: 100%;
	margin-top: 10px;
	text-align: left;
	height: 0;
	overflow: hidden;
}

.og-expander-inner {
	padding: 50px 30px;
	height: 100%;
}

.og-close {
	position: absolute;
	width: 40px;
	height: 40px;
	top: 20px;
	right: 20px;
	cursor: pointer;
}

.og-close::before,
.og-close::after {
	content: '';
	position: absolute;
	width: 100%;
	top: 50%;
	height: 1px;
	background: #888;
	-webkit-transform: rotate(45deg);
	-moz-transform: rotate(45deg);
	transform: rotate(45deg);
}

.og-close::after {
	-webkit-transform: rotate(-45deg);
	-moz-transform: rotate(-45deg);
	transform: rotate(-45deg);
}

.og-close:hover::before,
.og-close:hover::after {
	background: #333;
}

.og-fullimg,
.og-details {
	width: 50%;
	float: left;
	height: 100%;
	overflow: hidden;
	position: relative;
}

.og-details {
	padding: 0 40px 0 20px;
}

.og-fullimg {
	text-align: center;
}

.og-fullimg img {
	display: inline-block;
	max-height: 100%;
	max-width: 100%;
}

.og-details h3 {
	font-weight: 300;
	font-size: 52px;
	padding: 40px 0 10px;
	margin-bottom: 10px;
}

.og-details p {
	font-weight: 400;
	font-size: 16px;
	line-height: 22px;
	color: #999;
}

.og-details a {
	font-weight: 700;
	font-size: 16px;
	color: #333;
	text-transform: uppercase;
	letter-spacing: 2px;
	padding: 10px 20px;
	border: 3px solid #333;
	display: inline-block;
	margin: 30px 0 0;
	outline: none;
}

.og-details a::before {
	content: '\2192';
	display: inline-block;
	margin-right: 10px;
}

.og-details a:hover {
	border-color: #999;
	color: #999;
}

.og-loading {
	width: 20px;
	height: 20px;
	border-radius: 50%;
	background: #ddd;
	box-shadow: 0 0 1px #ccc, 15px 30px 1px #ccc, -15px 30px 1px #ccc;
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -25px 0 0 -25px;
	-webkit-animation: loader 0.5s infinite ease-in-out both;
	-moz-animation: loader 0.5s infinite ease-in-out both;
	animation: loader 0.5s infinite ease-in-out both;
}

@-webkit-keyframes loader {
	0% { background: #ddd; }
	33% { background: #ccc; box-shadow: 0 0 1px #ccc, 15px 30px 1px #ccc, -15px 30px 1px #ddd; }
	66% { background: #ccc; box-shadow: 0 0 1px #ccc, 15px 30px 1px #ddd, -15px 30px 1px #ccc; }
}

@-moz-keyframes loader {
	0% { background: #ddd; }
	33% { background: #ccc; box-shadow: 0 0 1px #ccc, 15px 30px 1px #ccc, -15px 30px 1px #ddd; }
	66% { background: #ccc; box-shadow: 0 0 1px #ccc, 15px 30px 1px #ddd, -15px 30px 1px #ccc; }
}

@keyframes loader {
	0% { background: #ddd; }
	33% { background: #ccc; box-shadow: 0 0 1px #ccc, 15px 30px 1px #ccc, -15px 30px 1px #ddd; }
	66% { background: #ccc; box-shadow: 0 0 1px #ccc, 15px 30px 1px #ddd, -15px 30px 1px #ccc; }
}

@media screen and (max-width: 830px) {

	.og-expander h3 { font-size: 32px; }
	.og-expander p { font-size: 13px; }
	.og-expander a { font-size: 12px; }

}

@media screen and (max-width: 650px) {

	.og-fullimg { display: none; }
	.og-details { float: none; width: 100%; }
	
}
.main > p {
	text-align: center;
	padding: 50px 20px;
}

/* Header Style */
.codrops-top {
	line-height: 24px;
	font-size: 11px;
	background: #fff;
	background: rgba(255, 255, 255, 0.5);
	text-transform: uppercase;
	z-index: 9999;
	position: relative;
	box-shadow: 1px 0px 2px rgba(0,0,0,0.2);
}

.codrops-top a {
	padding: 0px 10px;
	letter-spacing: 1px;
	color: #333;
	display: inline-block;
}

.codrops-top a:hover {
	background: rgba(255,255,255,0.8);
	color: #000;
}

.codrops-top span.right {
	float: right;
}

.codrops-top span.right a {
	float: left;
	display: block;
}
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
	<!--
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
-->

<script src="include/scripts/js/modernizr.custom.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
     $(document).ready(function(){
           $('li img').on('click',function(){
                var src = $(this).attr('src');
                var img = '<img src="' + src + '" class="img-responsive"/>';
                $('#myModal').modal();
                $('#myModal').on('shown.bs.modal', function(){
                    $('#myModal .modal-body').html(img);
                });
                $('#myModal').on('hidden.bs.modal', function(){
                    $('#myModal .modal-body').html('');
                });
           });  
        })
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
	if(($_GET['action'] === 'addGallery')) {
	$galleryClass->galleryCategory();
	}
	if(($_GET['action'] === 'deleteGallery')) {
	$galleryClass->deleteGallery();
	}
}

class gallery{
	public function vg(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		if($core->verify("4") || $core->verify("2")){
		echo '<div class="shadowbar"><a class="Link LButton" href="index.php?action=uploadphoto">Upload File To Gallery </a><a class="Link LButton" href="index.php?action=addGallery">Add Gallery</a></div>';
		}
		echo'<div class="shadowbar">';
		if(isset($_GET['limit'])){
		$secureLimit = preg_replace("/[^0-9]/", "", $_GET['limit']);
		$limit = mysqli_real_escape_string($dbc, $secureLimit);
		} else {
		$limit = 1;
		}
		$query = "SELECT * FROM gallery_cat WHERE cg_id = ".$limit."";
		$data = mysqli_query($dbc, $query);
		while($row = mysqli_fetch_array($data)) {
		echo '<h3>'.$row['cg_name'].'</h3>';
		$query = "SELECT * FROM gallery WHERE cat = ".$row['cg_id']." ";
		mysqli_query($dbc, $query);
		$data = mysqli_query($dbc, $query);
		echo'
			<div class="main">
				<ul id="og-grid" class="og-grid">';
		while($row = mysqli_fetch_array($data)){
			if(!empty($row['filename'])){
				echo'<li>
						<a href="http://'.$settings['b_url'].'/index.php?action=viewgallery" data-largesrc="include/images/'.$row['filename'].'" data-title="'.$row['name'].'" data-description="'.$row['descr'].'">
							<img style="max-height:70px;" src="include/images/'.$row['filename'].'" alt="img01"/>
						</a>
					</li>';
			} 

		}
		echo '</ul>
				</div>';
						echo '<a class="Link LButton" href="index.php?action=viewgallery&limit='.($limit - 1).'">Previous </a><a class="Link LButton" href="index.php?action=viewgallery&limit='.($limit + 1).'"> Next</a>';
		echo '</div>';
	}
	}
	public function deleteGallery(){
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
		if($core->verify("4") || $core->verify("2")){
		if (isset($_POST['submit'])) {
			$postid = mysqli_real_escape_string($dbc, trim($_POST['postid']));
			if (!empty($postid)) {

				$query = "DELETE FROM gallery_cat WHERE cg_id = $postid";
				mysqli_query($dbc, $query); 
				echo '<div class="shadowbar"><p>Gallery has been successfully deleted. Would you like to <a href="index.php?action=viewgallery">go back to the gallery</a>?</p></div>';
				
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		}
		
		
		
		echo'<div class="shadowbar"><form enctype="multipart/form-data" method="post" action="index.php?action=deleteGallery">
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
	public function uloadp(){
	
		global $dbc, $parser, $layout, $main, $settings, $core;
		$core->isLoggedIn();
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
			$cat = mysqli_real_escape_string($dbc, trim($_POST['cat']));
			$pnumname = 'galleryUploadNumber'.$pnumu.'.'.$extension;
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
						move_uploaded_file($_FILES["file"]["tmp_name"],
						"include/images/" . $pnumname);
						$query = "INSERT INTO gallery (name, descr, filename, cat) VALUES ('$name', '$desc', '$pnumname', '$cat')";
						mysqli_query($dbc, $query);
						echo "Success!";
						exit();
					}
				}
			} else {
				echo '<p class="error">Invalid file</p>';
			}
		}
		
		
		echo'<form enctype="multipart/form-data" method="post" action="index.php?action=uploadphoto">
		<fieldset>
		<legend>Picture Upload</legend>
		<label for="name">Picture Name:</label><br />
		<input type="text" id="name" name="name" value="" /><br />';
		echo'<select id="cat" name="cat">';
		$query = "SELECT * FROM gallery_cat";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			echo '<option value="'.$row['cg_id'].'">'.$row['cg_name'].'</option>';
		}
		echo'</select><br /><br />';	
		echo'
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
	public function galleryCategory() {
		global $dbc, $parser, $layout, $main, $settings, $core;

		$core->isLoggedIn();
		echo '<div class="shadowbar">';
		if (isset($_POST['submit'])) {
			$catt = mysqli_real_escape_string($dbc, strip_tags( trim($_POST['catt'])));
			if (!empty($catt)) { 
				$query = "INSERT INTO gallery_cat (`cg_name`) VALUES ('$catt')";
				mysqli_query($dbc, $query);
				echo '<p>Your category has been successfully added. Would you like to go back to the <a href="index.php?action=viewgallery">Gallery</a>?</p>';
				exit();
			}
			else {
				echo '<p class="error">You must enter information into all of the fields.</p>';
			}
		} 
		if($core->verify("4") || $core->verify("2")){
		echo'<form enctype="multipart/form-data" method="post" action="index.php?action=addGallery">
		<fieldset>
		<legend>Create Gallery:</legend>
			<label type="hidden" for="catt">Gallery name:</label><br />
			<input type="text" name="catt"><br /><br />
		<input type="submit" value="Save Gallery" name="submit" />     
	</form>';
		echo '<table class"table">';
		echo '<thead><th>Categories</th></thead>';
		$query = "SELECT * FROM gallery_cat";
		$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)) {
			echo '<tr>';
			echo '<td>'.$row['cg_name'].' <a href="index.php?action=deleteGallery&cat='.$row['cg_id'].'">Delete Gallery</a></td></tr>';
		}
		
		echo'</table>';
		echo'</div>';
	}
	}
	}

?>
<script src="include/scripts/js/grid.js"></script>
		<script>
			$(function() {
				Grid.init();
			});
		</script>