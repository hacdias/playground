<?php

/**
 * ROUTER
 *
 * @author Henrique Dias
 * @package CodePocket
 */

require_once('/config.php');

$DATA['url'] = isset($_GET['url']) ? $_GET['url'] : null;
$DATA['url'] = rtrim($DATA['url'], '/');
$DATA['url'] = explode('/', $DATA['url']);

if(empty($DATA['url'][0])) {

	if ($DATA['userSession']->loggedIn()) {
		$page = new Page('home.user');
	} else {
		$page = new Page('home');
	}	

} else {

	switch ($DATA['url'][0]) {

		case 'about':
			$page = new Page('about');
			break;

		case '404':
			$page = new Page('404', 'red');
			break;

		case 'profile':
			profile();
			break;

		case 'user':
			user();
			break;

		case 'action':
			actions();
			break;

		case 'admin':
			if ($DATA['userSession']->loggedIn() && $DATA['user']->isAdmin($_SESSION['user_user'])) {
				admin();
			} else {
				echo "<script>page('404');</script>";
			}
			break;

		default:
			echo "<script>page('404');</script>";
			break;
	}
}

function user() {
	global $DATA;

	if($DATA['url'][1]) {

		switch ($DATA['url'][1]) {

			case 'login':
				$page = new Page('login');
				break;

			case 'register':
				$page = new Page('register');
				break;

			case 'config':
				if ($DATA['userSession']->loggedIn()) {

					$DATA['user']->configPage($_SESSION['user_user']);

				} else {

					$noSignedIn();

				}
				break;

			default:
				echo "<script>page('404');</script>";
				break;
		}
	}
}


function actions() {
	global $DATA;

	if ($DATA['url'][1]) {

		switch ($DATA['url'][1]) {

			case 'logout':
				if ($DATA['userSession']->logout()) {

					echo '<script>reloadToHome();</script>';
					die;
					exit;

				}

				break;

			case 'login':
				if (isset($_POST['user']) && isset($_POST['pass'])) {
					$user = $_POST['user'];
					$pass = $_POST['pass'];
				} else {
					$user = '';
					$pass = '';
				}

				$remember = (isset($_POST['remember']) AND !empty($_POST['remember']));

				$DATA['userSession']->login( $user, $pass, $remember);
				break;

			case 'register':
				$name = $_POST['name'];
				$user = $_POST['user'];
				$pass = $_POST['password'];

				$DATA['userSession'] = new UserSession;
				$DATA['userSession']->registration($name, $user, $pass);
				break;

			case 'update_conf':
				$user = $_POST['user'];
				$color = $_POST['color'];
				$bio = $_POST['bio'];

				$DATA['user']->configUpdate($user, $color, $bio);
				break;

			default:
				echo "<script>page('404');</script>";
				break;
		}
	}
}

function profile() {
	global $DATA;

	if (!isset($DATA['url'][1])) {

		echo "<script>page('404');</script>";

	} else {

		if ($DATA['userSession']->loggedIn()) {

			$DATA['user']->profile($DATA['url'][1]);

		} else {

			$DATA['page'] = new Page('login', 'blue', false, false, false, true);

		}
				
	}
}

function admin() {
	global $DATA;

	if (!isset($DATA['url'][1])) {

		$DATA['page'] = new Page('admin/main', 'orange');

	} else {

		switch($DATA['url'][1]) {

			case 'rails':
				adminRails();
				break;

			case 'items':
				adminItems();
				break;

			default:
				echo "<script>page('404');</script>";
				break;

		}
	}
}

?>