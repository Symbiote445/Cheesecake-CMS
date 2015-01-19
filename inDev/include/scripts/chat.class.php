<?php
//XMPP Chat 
$chat_init = new CandyChatIntegration;
if(isset($_GET['action'])){
	if($_GET['action'] == 'chat'){
	$chat_init->chat(true);
	}
	if($_GET['action'] == 'chatSignup'){
	echo '<div class="shadowbar"><iframe id="chatFrame" style="height:40em; width:100%;" src="//cheesecakeproductions.com:9090/plugins/registration/sign-up.jsp"></iframe></div>';
	}
}

class CandyChatIntegration {
	public function chat($start){
	$initialise = '
		<div class="alert alert-info" role="alert">All usernames must be followed by @cheesecakeproductions.com (Ex. nobody@cheesecakeproductions.com). Chat signups are seperate from website signups. <a href="index.php?action=chatSignup">Not signed up for chat?</a></div>
		<iframe id="chatFrame" style="height:40em;" width=100% src="//cheesecakeproductions.com/chat/user/index.html"></iframe>
	';
	$S = $start;
	if(isset($S)){
		if($S == true){
			echo '<div class="shadowbar">';
			echo $initialise;
			echo '</div>';
		}
	}
	}
}
?>