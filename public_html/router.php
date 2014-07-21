<?php

/**
 * ROUTER
 *
 * @author Henrique Dias
 * @package MathPocket
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

		case 'dictionary':
			dictionary();
			break;

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

		case 'sidebar':
			$page = new Sidebar();
			break;

		default:
			$page = new Page('404', 'red');
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
				$page = new Page('404', 'red');
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

					$result['status'] = 0;

	                ob_end_clean();
	                header('Content-type: application/json');
	                echo json_encode($result);
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

			case 'addFav':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				User::addFavLater($id, $user, 'favs');
				break;

			case 'addLater':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				User::addFavLater($id, $user, 'later');
				break;

			default:
				$page = new Page('404', 'red');
				break;
		}
	}
}

function profile() {
	global $DATA;

	if (!isset($DATA['url'][1])) {

		$page = new Page('404', 'red');

	} else {

		if ($DATA['userSession']->loggedIn()) {

			$DATA['user']->profile($DATA['url'][1]);

		} else {

			$DATA['page'] = new Page('login', 'blue', array('needLogin'	=> true));

		}
				
	}
}

function dictionary() {
	global $DATA;

	$page = new Dictionary();

	if (!isset($DATA['url'][1])) {

		$page->allItems();

	} else {

		if ($DATA['url'][1] == 'item') {

			if (!isset($DATA['url'][2])) {

				$page->allItems();

			} else {

				$page->item($DATA['url'][2]);

			}

		} else if (is_numeric($DATA['url'][1])) {

			$n = $DATA['url'][1];
			$page->allItems($n);

		} else if ($DATA['url'][1] == 'category') {

			if (!isset($DATA['url'][2])) {

				$page->allItems();

			} else {

				$page->category($DATA['url'][2]);
			}

		} else {

			$page = new Page('404', 'red');

		}
	}
		
}

?>