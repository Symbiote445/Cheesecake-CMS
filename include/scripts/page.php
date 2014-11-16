<?php
//Page Generation
class pageGeneration {
	public function Generate(){
		global $dbc, $parser, $layout, $settings, $core, $admin, $version;
		echo sprintf($layout['header-begin'], $settings['site_name'], $settings['style'], $settings['style'], $settings['style'], $settings['style'], $settings['site_name']);
		$core->loadModule("nav");
		print($layout['header-end']);
		sidebar();
		if(isset($_GET['action'])){
			if($_GET['action'] === 'login'){
				$core->login();
			}
			if($_GET['action'] === 'logout'){
				$core->logout();
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
		} else {
			if(!isset($_GET['action'])){
				echo '<div class="shadowbar">';
				print($settings['about']);
				echo '</div>';
			}
		}
		$core->loadModule("initialLoad");
		echo sprintf($layout['footer'], $settings['b_url'], $settings['site_name'], $version['core']);
	}
}
?>