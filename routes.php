<?php

/**
 * ROUTER
 *
 * @author Henrique Dias <me@henriquedias.com>
 * @package MathPocket
 */

require_once('/config.php');

$DATA['url'] = isset($_GET['url']) ? $_GET['url'] : null;
$DATA['url'] = rtrim($DATA['url'], '/');
$DATA['url'] = explode('/', $DATA['url']);

if(empty($DATA['url'][0])) {

	if ($DATA['user']->loggedIn()) {
		$page = new Piece('home.user');
	} else {
		$page = new Piece('home');
	}

} else {

	switch ($DATA['url'][0]) {

		case 'sidebar':
			$page = new Piece('sidebar');
			break;

		case 'about':
			$page = new Piece('about');
			break;

		case 'dictionary':
			dictionary();
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

		default:
			$page = new Piece('404', 'red');
			break;
	}
}

function dictionary() {
	global $DATA;

	$page = new Dictionary();

	if (!isset($DATA['url'][1])) {

		$page->allItems();

	} else {

		if (is_numeric($DATA['url'][1])) {

			$n = $DATA['url'][1];
			$page->allItems($n);

		} else if (isset($DATA['url'][2])) {

			if (is_numeric($DATA['url'][2])) {
				$page->category($DATA['url'][1], $DATA['url'][2]);
			} else {
				$page->item($DATA['url'][2]);
			}

		} else if ($DATA['url'][1] == 'favorites') {

			($DATA['user']->loggedIn(true, false)) ? $page->listFavLater($_SESSION['user_user'], 'favs') : Helper::needLogin();


		} else if ($DATA['url'][1] == 'readlater') {

			($DATA['user']->loggedIn(true, false)) ? $page->listFavLater($_SESSION['user_user'], 'later') : Helper::needLogin();

		} else {

			$page->category($DATA['url'][1]);

		}
	}
}

function profile() {
	global $DATA;

	if (!isset($DATA['url'][1])) {

		$page = new Piece('404', 'red');

	} else {

		if ($DATA['user']->loggedIn()) {

			$DATA['user']->profile($DATA['url'][1]);

		} else {

			Helper::needLogin();

		}
	}
}

function user() {
	global $DATA;

	if($DATA['url'][1]) {

		switch ($DATA['url'][1]) {

			case 'login':
				if ($DATA['user']->loggedIn()) {

					/**
					  * @todo Sessão já iniciada. Colocar outra pag em vez de 404.
					  */
					$page = new Piece('404', 'red');

				} else {

					$page = new Piece('login');

				}
				break;

			case 'register':
				if ($DATA['user']->loggedIn()) {

					/**
					  * @todo Sessão já iniciada. Colocar outra pag em vez de 404.
					  */
					$page = new Piece('404', 'red');

				} else {

					$page = new Piece('register');

				}
				break;

			case 'config':
				if ($DATA['user']->loggedIn()) {

					$DATA['user']->configPage($_SESSION['user_user']);

				} else {

					Helper::needLogin();
				}

				break;

			default:
				$page = new Piece('404', 'red');
				break;
		}
	}
}


function actions() {
	global $DATA;

	if ($DATA['url'][1]) {

		switch ($DATA['url'][1]) {

			case 'logout':
				if ($DATA['user']->logout()) {

					$result['status'] = 0;

	                ob_end_clean();
	                header('Content-type: application/json');
	                echo json_encode($result);
				}

				break;

			case 'login':
				$user = isset($_POST['user']) ? $_POST['user'] : null;
				$pass = isset($_POST['pass']) ? $_POST['pass'] : null;

				$remember = (isset($_POST['remember']) AND !empty($_POST['remember']));

				$DATA['user']->login( $user, $pass, $remember);
				break;

			case 'register':
				$name = isset($_POST['name']) ? $_POST['name'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;
				$pass = isset($_POST['password']) ? $_POST['password'] : null;

				$DATA['user'] = new User;
				$DATA['user']->registration($name, $user, $pass);
				break;

			case 'update_conf':
				$user = isset($_POST['user']) ? $_POST['user'] : null;
				$color = isset($_POST['color']) ? $_POST['color'] : null;
				$bio = isset($_POST['bio']) ? $_POST['bio'] : null;

				User::configUpdate($user, $color, $bio);
				break;

			case 'addFav':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				Dictionary::actionFavLater($id, $user, 'favs', 'add');
				break;

			case 'addLater':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				Dictionary::actionFavLater($id, $user, 'later', 'add');
				break;

			case 'remFav':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				Dictionary::actionFavLater($id, $user, 'favs', 'rem');
				break;

			case 'remLater':
				$id = isset($_POST['id']) ? $_POST['id'] : null;
				$user = isset($_POST['user']) ? $_POST['user'] : null;

				Dictionary::actionFavLater($id, $user, 'later', 'rem');
				break;

			default:
				$page = new Piece('404', 'red');
				break;
		}
	}
}

?>
