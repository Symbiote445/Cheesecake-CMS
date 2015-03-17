<?php
//Downloads Module
$dl = new dLoad;
if(isset($_GET['action'])){
	if($_GET['action'] == "dlList"){
		$dl->dlList();
	}
	if($_GET['action'] == "uploadFile"){
		$dl->uploadFile();
	}
	if($_GET['action'] == "dlAdmin"){
		$dl->dlAdmin();
	}
}

class dLoad {
	public function dlList() {
		echo '<div class="shadowbar"><a class="Link LButton" href="/dlAdmin">Downloads Admin</a></div>';
		global $dbc, $layout, $core;
		$query = "SELECT * FROM `downloads`";
		$data = mysqli_query($dbc, $query);
		print($layout['dlListBegin']);
		while ($row = mysqli_fetch_array($data)){
			echo sprintf($layout['dlListMid'], $row['rawName'], $row['filename'], $row['fileDesc']);
		}
		print($layout['dlListEnd']);
	}
	public function uploadFile() {
		echo '<div class="shadowbar">';
		global $dbc, $layout, $core;
		if($core->verify("dl.*") || $core->verify("dl.upload")){
		if(isset($_POST['submit'])){
			$filename = mysqli_real_escape_string($dbc, trim($_POST['name']));
			$desc = mysqli_real_escape_string($dbc, trim($_POST['desc']));
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			$uniName = uniqid();
			$uniName = $uniName . '.' . $extension; 
			$query = "INSERT INTO `downloads` (`filename`, `fileDesc`, `rawName`) VALUES ('$filename', '$desc', '$uniName')";
			$data = mysqli_query($dbc, $query);
			$upload = "include/files/".$uniName;
			move_uploaded_file($_FILES['file']['tmp_name'], $upload);
			echo '<div class="shadowbar">Uploaded</div>';
		}
		echo'
		<div class="progress" style="color:#000;">
			<div class="progress-bar progress-bar-success progress-bar-striped bar"><div class="percent">0%</div></div>
		</div>
		<div id="alert"></div>
		<form enctype="multipart/form-data" id="fUP" name="fUP" method="post" action="/uploadFile">
		<fieldset>
		<legend>File Upload</legend>
		<label for="name">File Name:</label><br />
		<input type="text" id="name" name="name" value="" /><br />	
		<label for="desc">Description</label><br />
		<textarea id="desc" name="desc" rows="4" cols="30"></textarea><br />
		<label for="file">File:</label>';
		echo'<input class="Link LButton" type="file" id="file" name="file" />
		</fieldset>
		<input title="Save File" data-placement="bottom" data-toggle="tooltip" class="Link LButton" type="submit" id="save" value="&#10004;" name="submit" /> <a class="button" href="/viewgallery">Cancel</a>
	</form>
	</div>';
		echo (<<<EOL
		<script>
    $(function upload() {
    $("#fUP").validate({ // initialize the plugin
        // any other options,
        onkeyup: false,
        rules: {
            name: {
                required: true,
                minlength: 3
            },
			file: {
				required: true
			}
        }
    });
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');

    $('form').ajaxForm({
        beforeSend: function() {
			return $("#fUP").valid();
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
		complete: function() {
			document.getElementById("fUP").reset();
		}
    });
    }); 
</script>
EOL
		);
		}
	}
	public function dlAdmin() {
		global $dbc, $core;
		if($core->verify("dl.*")){
			echo '<div class="shadowbar">';
			if(isset($_GET['do'])){
				if($_GET['do'] == "delete"){
					$id = mysqli_real_escape_string($dbc, trim($_GET['id']));
					$query = "SELECT * FROM `downloads` WHERE `id` = '$id'";
					$data = mysqli_query($dbc, $query);
					$row = mysqli_fetch_array($data);
					$filename = $row['rawName'];
					$query = "DELETE FROM `downloads` WHERE `id` = '$id'";
					mysqli_query($dbc, $query);
					unlink('include/files/'.$filename);
					echo 'File Deleted';
				}
			}
			$query = "SELECT * FROM `downloads`";
			$data = mysqli_query($dbc, $query);
			echo '
							<table class="table table-bordered">
					<thead>
						<th>Filename</th>
						<th>Description</th>
						<th>Options</th>
					</thead>
					<tbody>';
			while($row = mysqli_fetch_array($data)){
				echo '
						<tr>
						<td>'.$row['filename'].'</td>
						<td>'.$row['fileDesc'].'</td>
						<td><a title="Delete" data-placement="top" data-toggle="tooltip" href="/dlAdmin/do/delete/id/'.$row['id'].'"><span class="glyphicon glyphicon-remove"></span></a></td>
						</tr>						
				';
			}
			echo '
			</tbody>
				</table>
				</div>';
		}
	}
}

?>