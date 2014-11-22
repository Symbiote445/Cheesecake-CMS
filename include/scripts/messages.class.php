<?php
//CCore PM Mod
if(isset($_GET['action'])){
if($_GET['action'] == "messages"){
$messages->viewConvo();
}
}

$messages = new PM;
class PM {
	public function viewConvo(){
		echo '<div class="shadowbar">';
		global $dbc;
		$query = "SELECT convo.*, users.* FROM convo JOIN users ON users.username = convo.to";
		$data = mysqli_query($dbc, $query);
		echo '<table class="table">';
		echo '<thead>';
		echo '<th>Message Title</th>';
		echo '</thead>';
		echo '<tbody>';
		while ($row = mysqli_fetch_array($data)) {
			$query2 = "SELECT * FROM messages WHERE convo = ".$row['id']."";
			$count = mysqli_query($dbc, $query2);
			$rc = mysqli_fetch_array($count);
			if(!empty($row['title'])) {
				echo'<tr>';
				echo'<td>';
					echo'<a class="nav" href="index.php?action=messages&m='.$row['id'].'">' .$row['title']. '<span class="badge">' . mysqli_num_rows($count) . ' Messages</span></a>';  
				echo'</td></tr>';
			}
			
		}
		echo '</tbody></table></div>';
	}
}
?>