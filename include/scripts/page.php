<?php
//Page Generation
class pageGeneration {
	public function Generate(){
		global $dbc, $parser, $layout, $settings, $core, $admin, $version;
		$core->counter();
	if(isset($_GET['action'])){
			if($_GET['action'] === 'logout'){
				$core->logout();
			}
			if($_GET['action'] == 'doLogin'){
				$core->login();
				exit();
			}
			if($_GET['action'] == 'postComment'){
				$core->addcomment();
				exit();
			}
	}
		$parser->SetSmileyURL("http://".$settings['b_url']."/include/images/smileys");
		$core->checkLogin();
		echo sprintf($layout['header-begin'], $settings['site_name'], $settings['style'], $settings['style'], $settings['style'], $settings['style'], $settings['site_name']);
		$core->loadModule("nav");
		print($layout['header-end']);
		$core->sidebar();
		$core->securityAgent("check");
			if(!isset($_GET['action'])){
				if($settings['home_display'] == 'none' || $settings['home_display'] == 'about'){
					echo '<div class="shadowbar">';
					$parsed = $parser->parse($settings['about']);
					print($parsed);
					echo '</div>';
				}
			}
		$core->loadModule("initialLoad");
		if(isset($_GET['action'])){
			if($_GET['action'] == 'login'){
				if(isset($error)){
					echo $error;
				}
				print($layout['login']);
			}
			if($_GET['action'] === 'signup'){
				$core->signup();
			}
			if($_GET['action'] === 'verifyaccount'){
				$core->activate();
			}
			if($_GET['action'] === 'acp'){
				$admin->acp();
			}
			if($_GET['action'] === 'ucp'){
				$core->ucp();
			}
			if($_GET['action'] === 'editprofile'){
				$core->editprofile();
			}
			if($_GET['action'] == "messages"){
			$core->viewConvo();
			}
			if($_GET['action'] == "viewmessage"){
			$core->viewMessage();
			}
			if($_GET['action'] == "sendmessage"){
			$core->sendMessage();
			}
			if($_GET['action'] == "replymessage"){
			$core->sendMessageReply();
			}
			if($_GET['action'] == "passwordReset"){
			$core->deactivateAndReset();
			}
		}
		$core->loadModule("initialLoad");
		$core->notifBar();
		echo sprintf($layout['footer'], $settings['b_url'], $settings['site_name'], $version['core']);
	}
}
?>