<?php

/**
 * USER CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class User {

	var $database = 'MathPocket';
    var $usersTable = 'users';

    var $fields = array(
        'user' => 'user',
        'pass' => 'password'
    );

    var $data = array('id', 'name');
    
    var $loginVar = true;
    
    var $keyPrefix = 'user_';
    
    var $cookie = true;
    
    var $rememberTime = 7;
    
    var $cookiePath = '/';
    
    var $erro = '';
    
    function encryptPass($string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'Pi8D1E2^e8s&vUnkg7~|asdfgjkg;T]]EGMuFM54sYMen~w5w5Tr]p.!4x%a1v;Z0X78sF';
        $secret_iv = 'N|;b,$567+76;Or.';

        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }
    
    function confirmUser($user, $pass) {
        global $DATA;

        $pass = $this->encryptPass($pass);

        // Procura por usuários com o mesmo usuário e pass
        $sql = "SELECT COUNT(*) AS total
                FROM `{$this->database}`.`{$this->usersTable}`
                WHERE
                     `{$this->fields['user']}` = '{$user}'
                    AND
                     `{$this->fields['pass']}` = '{$pass}'";

                    echo $sql;

        $query = $DATA['db']->prepare($sql);
        $query->execute();

        if ($query) {
            // Total de usuários encontrados
            $total = $query->fetchColumn();
            
            // Limpa a consulta da memória
            $query->closeCursor();
        } else {
            // A consulta foi mal sucedida, retorna false
            return false;
        }
        
        // Se houver apenas um usuário, retorna true
        return ($total == 1) ? true : false;
    }

    function login($user, $pass, $remember = false) {    
        global $DATA;        
        // Verifica se é um usuário válido

        $result = array();

        if ($user == null || $pass == null) {

            $result['status'] = 'needData';

            ob_end_clean();
            header('Content-type: application/json');
            echo json_encode($result);  

        } else {

            if ($this->confirmUser($user, $pass)) {
            
                if ($this->loginVar AND !isset($_SESSION)) {
                    session_start();
                }
                
                if ($this->data != false) {
                    // Adiciona o campo do usuário na lista de data
                    if (!in_array($this->fields['user'], $this->data)) {
                        $this->data[] = 'user';
                    }
                
                    // Monta o formato SQL da lista de fields
                    $data = '`' . join('`, `', array_unique($this->data)) . '`';

                    // Consulta os data
                    $sql = "SELECT {$data}
                            FROM `{$this->database}`.`{$this->usersTable}`
                            WHERE `{$this->fields['user']}` = '{$user}'";

                    $query = $DATA['db']->query($sql);
                    
                    // Se a consulta falhou
                    if (!$query) {
                        $this->erro = 'A consulta dos data é inválida';

                        $result['status'] = 'wrong';

                        ob_end_clean();
                        header('Content-type: application/json');
                        echo json_encode($result);  

                    } else {

                        $data = $query->fetch(PDO::FETCH_ASSOC);
                        // Limpa a consulta da memória
                        $query->closeCursor();
                        
                        foreach ($data AS $chave=>$value) {
                            $_SESSION[$this->keyPrefix . $chave] = $value;
                        }
                    }
                }
                
                $_SESSION[$this->keyPrefix . 'loggedIn'] = true;
                
                // Define um cookie para maior segurança?
                if ($this->cookie) {
                    // Monta uma cookie com informações gerais sobre o usuário: usuario, ip e navegador
                    $value = join('#', array($user, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
                    $value = sha1($value);
                    
                    setcookie($this->keyPrefix . 'token', $value, 0, $this->cookiePath);
                }
            
                if ($remember) $this->rememberData($user, $pass);

                $result['status'] = 'correct';

                ob_end_clean();
                header('Content-type: application/json');
                echo json_encode($result);
                exit;
                
                            
            } else {
                $this->erro = 'Utilizador inválido';
               
                $result['status'] = 'wrong';

                ob_end_clean();
                header('Content-type: application/json');
                echo json_encode($result);  
            }
        }
    }

    function loggedIn($cookies = true) {
        if ($this->loginVar AND !isset($_SESSION)) {
            session_start();
        }
        
        if (!isset($_SESSION[$this->keyPrefix . 'loggedIn']) OR !$_SESSION[$this->keyPrefix . 'loggedIn']) {

            if ($cookies) {
                return $this->confirmRememberedData();
            } else {
                $this->erro = 'Não há usuário loggedIn';
                return false;
            }
        }
        
        if ($this->cookie) {
            if (!isset($_COOKIE[$this->keyPrefix . 'token'])) {
                $this->erro = 'Não existem utilizadores com sessão iniciada.';
                return false;
            } else {
                $value = join('#', array($_SESSION[$this->keyPrefix . 'user'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
                $value = sha1($value);
    
                if ($_COOKIE[$this->keyPrefix . 'token'] !== $value) {
                    $this->erro = 'Não há usuário loggedIn';
                    return false;
                }
            }
        }

        $user = array();
        $user['user'] = $_SESSION[$this->keyPrefix . 'user'];

        $session_json = json_encode($user);

        echo "<script>
             var user = eval('( "  . $session_json .  ")');
            </script>";
        
        return true;
    }
    
    function logout($cookies = true) {
        if ($this->loginVar AND !isset($_SESSION)) {
            session_start();
        }
        
        $size = strlen($this->keyPrefix);

        foreach ($_SESSION AS $chave=>$value) {
            if (substr($chave, 0, $size) == $this->keyPrefix) {
                unset($_SESSION[$chave]);
            }
        }
        
        if (count($_SESSION) == 0) {
            session_destroy();
            
            if (isset($_COOKIE['PHPSESSID'])) {
                setcookie('PHPSESSID', false, (time() - 3600));
                unset($_COOKIE['PHPSESSID']);
            }
        }
        
        if ($this->cookie AND isset($_COOKIE[$this->keyPrefix . 'token'])) {
            setcookie($this->keyPrefix . 'token', false, (time() - 3600), $this->cookiePath);
            unset($_COOKIE[$this->keyPrefix . 'token']);
        }
        
        if ($cookies) $this->cleanRememberedData();
        
        return !$this->loggedIn(false);
    }
    
    function rememberData($user, $pass) {    
        $time = strtotime("+{$this->rememberTime} day", time());

        $user = rand(1, 9) . base64_encode($user);
        $pass = rand(1, 9) . base64_encode($pass);
    
        setcookie($this->keyPrefix . 'lu', $user, $time, $this->cookiePath);
        setcookie($this->keyPrefix . 'ls', $pass, $time, $this->cookiePath);
    }

    function confirmRememberedData() {
        if (isset($_COOKIE[$this->keyPrefix . 'lu']) AND isset($_COOKIE[$this->keyPrefix . 'ls'])) {

            $user = base64_decode(substr($_COOKIE[$this->keyPrefix . 'lu'], 1));
            $pass = base64_decode(substr($_COOKIE[$this->keyPrefix . 'ls'], 1));
            
            return $this->login($user, $pass, true);        
        }
        
        return false;
    }
    
    function cleanRememberedData() {

        if (isset($_COOKIE[$this->keyPrefix . 'lu'])) {
            setcookie($this->keyPrefix . 'lu', false, (time() - 3600), $this->cookiePath);
            unset($_COOKIE[$this->keyPrefix . 'lu']);            
        }

        if (isset($_COOKIE[$this->keyPrefix . 'ls'])) {
            setcookie($this->keyPrefix . 'ls', false, (time() - 3600), $this->cookiePath);
            unset($_COOKIE[$this->keyPrefix . 'ls']);            
        }
    }

    function registration($name, $user, $pass) {
        global $DATA;       

        if (DB_STATUS) {

            $result = array();

            if (!$name == '' && !$user == '' && !$pass == '')  {

                $confirmIfExists = $DATA['db']->query("SELECT * FROM users WHERE user = '" . $user ."';");

                if ($confirmIfExists->rowCount() == 0) {

                    $pass = $this->encryptPass($pass);

                    $query =  "INSERT INTO users(name, user, password) VALUES ('".$name."', '".$user."', '".$pass."')";
                    $DATA['db']->query($query);

                    $result['status'] = 0;

                } else {

                    //Utilizador já existente
                    $result['status'] = 1;
                }   

            } else {

                //Dados necessários
                $result['status'] = 2;

            }

            ob_end_clean();
            header('Content-type: application/json');
            echo json_encode($result);  

        } else {

            $page = new Page('tecnical', 'red');

        }

    }

	public function profile($user) {
		global $DATA;

		if (!$this->exists($user)) {

			echo "<script>page('404');</script>";

		} else {

			$DATA['page'] = new Template(Base::viewsDir('profile'));
			$DATA['page']->COLOR = $this->getColor($user);

			$name = $this->getName($user);
			$bio = $this->getBio($user);

			if ($DATA['user']->loggedIn()) {

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

		$idToHex = array('1'	=>	'#007AFF',
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

			$page = new Page('404', 'red');

		} else {

			SQL::updateOne('users', 'color', $color, 'user', $user);
			SQL::updateOne('users', 'bio', $bio, 'user', $user);

			$result = array();
            $result['status'] = 0;

            ob_end_clean();
            header('Content-type: application/json');
            echo json_encode($result);  
		}
	}
}

?>