<?php

/**
 * USER CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class User {

	public function profile($user) {
		global $DATA;

		if (!$this->exists($user)) {

			echo "<script>page('404');</script>";

		} else {

			$DATA['page'] = new Template(Base::viewsDir('profile'));
			$DATA['page']->COLOR = $this->getColor($user);

			$name = $this->getName($user);
			$bio = $this->getBio($user);

			if ($DATA['userSession']->loggedIn()) {

				if ($_SESSION['user_user'] == $user) {

					$DATA['page']->block('CONFIG');

				};
			}

			$DATA['page']->NAME = $name;
			$DATA['page']->IMG  = $this->getPhoto($user);
			$DATA['page']->BIO  = $bio;

			$DATA['page']->show();
		}
	}

	public function isAdmin($user) {
		global $DATA;
		
		$sql = SQL::selectOneWhere('type', 'users', 'user', $user);

		foreach($sql as $user) {
			$type = $user['type'];
		}

		if ($type == 0) {
			return true;
		} else {
			return false;
		}
	}

	static public function exists($user) {
		global $DATA;

		$confirmIfExists = SQL::selectOneWhereLimit('user', 'users', 'user', $user);

		if ($confirmIfExists->rowCount() == 0) {
			return false;
		} else {
			return true;
		}
	}

	public function getColor($user, $acurrate = false) {
		global $DATA;

		$idToColor = array('1'	=>	'blue',
						   '2'	=>	'green',
						   '3'	=>	'red',
						   '4'	=>	'orange');

		$idToHex = array('1'	=>	'#00adee',
					     '2'	=>	'#4CD964',
					     '3'	=>	'#e74c3c',
					     '4'	=>	'#FF9500');

		$results = SQL::selectOneWhereLimit('color', 'users', 'user', $user);

		foreach ($results as $color) {
			$colorId = $color['color'];
		}

		if ($acurrate) {

			return $idToHex[$colorId];

		} else {

			return $idToColor[$colorId];

		}
	}

	public function getBio($user) {
		global $DATA;

		$results = SQL::selectOneWhereLimit('bio', 'users', 'user', $user);

		foreach ($results as $result) {
			return $result['bio'];
		}

	}

	public function getName($user) {
		global $DATA;

		$results = SQL::selectOneWhereLimit('name', 'users', 'user', $user);

		foreach ($results as $result) {
			return $result['name'];
		}
	}

	public function getPhoto($user) {
		$filename = HOST_URL . '/imgs/users/' . $user . '_big.png';
		$file_headers = @get_headers($filename);

		if ($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found'){

			return 'default';

		} else if ($file_headers[0] == 'HTTP/1.0 302 Found' && $file_headers[7] == 'HTTP/1.0 404 Not Found'){

			return 'default';

		} else {

			return $user;

		}
	}

	public function configPage($user) {
		global $DATA;

		if (!$this->exists($user)) {

			echo "<script>page('404');</script>";

		} else {

			$DATA['page'] = new Template(Base::viewsDir('user.config'));

			$color = $this->getColor($user);
			$bio = $this->getBio($user);

			$DATA['page']->COLOR = $color;
			$DATA['page']->CFG_BIO  = $bio;
			$DATA['page']->CFG_USER = $user;

			$DATA['page']->block('COLOR_'.strtoupper($color));

			$DATA['page']->show();

		}
	}


	public function configUpdate($user, $color, $bio) {
		global $DATA;

		if (!$this->exists($user)) {

			echo "<script>page('404');</script>";

		} else {

			SQL::updateOne('users', 'color', $color, 'user', $user);
			SQL::updateOne('users', 'bio', $bio, 'user', $user);

			Base::message('Definições alteradas!', $this->getColor($user));
		}
	}

	static function addFavLater($itemId = 0, $user, $thing) {
		global $DATA;

		/*
		 *	STATUS MAP
		 * 
		 *	STATUS	=>	DESCRIPTION
		 *	0 		=>	Nenhum problema
		 *	1		=>	Utilizador inexistente
		 *	2		=>	Item já gravado na lista em questão
		 *	3 		=>	Problema na base de dados
		 *	4 		=>	Item inválido
		 *  5		=> 	Sem sessão iniciada
		 */

		if ($DATA['userSession']->loggedIn()) {

			$result = array();

			if ($itemId != 0) {

				if (!User::exists($user)) {

					$result['status'] = 1;

				} else {

					$query = SQL::selectOneWhereLimit($thing, 'users', 'user', $user);

					if($query) {

						foreach ($query as $item) {
							$new = $item[$thing];
						}

						$confirm = explode(';', $new);

						$alsoExists = false;

						for ($i = 0; $i < count($confirm); $i++) {

							if($confirm[$i] == $itemId) {

								$alsoExists = true;
								
							}

						}

						if (!$alsoExists) {

							$new .= $itemId . ';';

							if(SQL::updateOne('users', $thing, $new, 'user', $user)) {

								$result['status'] = 0;

							} else {

								$result['status'] = 3;

							}

						} else {

							$result['status'] = 2;

						}

					} else {

						$result['status'] = 3;

					}

				}

			} else {

				$result['status'] = 4;

			}

		} else {
			$result['status'] = 5;
		}

		ob_end_clean();
		header('Content-type: application/json');
		echo json_encode($result);	

	}
}

?>