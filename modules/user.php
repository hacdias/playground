<?php

/**
 * USER CLASS
 *
 * @author Henrique Dias <me@henriquedias.com>
 * @package MathPocket
 */

require_once('config.php');

class User {

	var $database = 'MathSpot';
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

    static public function exists($user) {
        global $DATA;

        $confirmIfExists = SQL::selectWhereLimit('user', 'users', 'user', $user);

        if ($confirmIfExists) {

            return ($confirmIfExists->rowCount() == 0) ? false : true;

        } else {

            return false;

        }
    }

    static public function getInfo($user, $info) {
        global $DATA;

        $results = SQL::selectWhereLimit($info, 'users', 'user', $user);

        if ($results) {

            foreach ($results as $result) {
                return $result[$info];
            } 

        } else {

            return false;

        } 
    }

    static public function getColor($user, $acurrate = false) {
        global $DATA;

        $idToColor = array('1'  =>  'blue',
                        '2'  =>  'green',
                        '3'  =>  'red',
                        '4'  =>  'orange');

        $idToHex = array('1'    =>  '#007AFF',
                        '2'    =>  '#4CD964',
                        '3'    =>  '#e74c3c',
                        '4'    =>  '#FF9500');

        $results = SQL::selectWhereLimit('color', 'users', 'user', $user);

        if ($results) {
            
            foreach ($results as $color) {
                $colorId = $color['color'];
            }

            return ($acurrate) ? $idToHex[$colorId] : $idToColor[$colorId];

        } else {

            return false;

        }
    }

    static public function getPhoto($user) {
        $filename = ROOT . DS . 'public' . DS . 'imgs' . DS . 'users' . DS . $user . '_big.png';
        
        if (file_exists($filename)) {
            return $user;
        } else {
            return 'default';
        }
    }

    static public function isAdmin($user) {
        global $DATA;

        $sql = SQL::selectWhere('type', 'users', 'user', $user);

        if ($sql) {

            foreach($sql as $user) {
                $type = $user['type'];
            }

            return ($type == 0) ? true : false;

        } else {

            return false;

        }
    }

    static public function profile($user) {
        global $DATA;

        if (!User::exists($user)) {

            $page = new Piece('404', 'red');

        } else {

            $page = new Template(Helper::viewsDir('profile'));
            $page->COLOR = User::getColor($user);

            $name = User::getInfo($user, 'name');
            $bio = User::getInfo($user, 'bio');

            if ($DATA['user']->loggedIn()) {

                if ($_SESSION['user_user'] == $user) {

                    $page->block('CONFIG');

                };
            }

            $page->NAME = $name;
            $page->IMG  = User::getPhoto($user);
            $page->BIO  = $bio;

            $page->show();
        }
    }

    static public function configPage($user) {
        global $DATA;

        if (!User::exists($user)) {

            $page = new Piece('404', 'red');

        } else {

            $page = new Template(Helper::viewsDir('user.config'));

            $color = User::getColor($user);
            $bio = User::getInfo($user, 'bio');

            $page->COLOR = $color;
            $page->CFG_BIO  = $bio;
            $page->CFG_USER = $user;

            $page->block('COLOR_'.strtoupper($color));

            $page->show();
        }
    }

    static public function configUpdate($user, $color, $bio) {
        global $DATA;

        if ($DATA['user']->loggedIn() && $_SESSION['user_user'] == $user) {

            if (!User::exists($user)) {

                $page = new Piece('404', 'red');

            } else {

                $result = array();

                if(SQL::updateOne('users', 'color', $color, 'user', $user) && SQL::updateOne('users', 'bio', $bio, 'user', $user)) {

                    $result['status'] = 0;

                } else {

                    $result['status'] = 3;

                }
            }

        } else {

            $result = array();
            $result['status'] = 5;

        }

        ob_end_clean();
        header('Content-type: application/json');
        echo json_encode($result);  
    }
    
    protected function encryptPass($string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'Pi8D1E2^e8s&vUnkg7~|asdfgjkg;T]]EGMuFM54sYMen~w5w5Tr]p.!4x%a1v;Z0X78sF';
        $secret_iv = 'N|;b,$567+76;Or.';

        $key = hash('sha256', $secret_key);
        
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }
    
    protected function confirmUser($user, $pass) {
        global $DATABASE;

        $pass = $this->encryptPass($pass);

        $sql = "SELECT COUNT(*) AS total
                FROM `{$this->database}`.`{$this->usersTable}`
                WHERE
                     `{$this->fields['user']}` = '{$user}'
                    AND
                     `{$this->fields['pass']}` = '{$pass}'";

        $query = $DATABASE->prepare($sql);
        $query->execute();

        if ($query) {
            
            $total = $query->fetchColumn();
            $query->closeCursor();

        } else {

            return false;
        }

        return ($total == 1) ? true : false;
    }

    protected function rememberData($user, $pass) {    
        $time = strtotime("+{$this->rememberTime} day", time());

        $user = rand(1, 9) . base64_encode($user);
        $pass = rand(1, 9) . base64_encode($pass);
    
        setcookie($this->keyPrefix . 'lu', $user, $time, $this->cookiePath);
        setcookie($this->keyPrefix . 'ls', $pass, $time, $this->cookiePath);
    }

    protected function confirmRememberedData() {
        if (isset($_COOKIE[$this->keyPrefix . 'lu']) AND isset($_COOKIE[$this->keyPrefix . 'ls'])) {

            $user = base64_decode(substr($_COOKIE[$this->keyPrefix . 'lu'], 1));
            $pass = base64_decode(substr($_COOKIE[$this->keyPrefix . 'ls'], 1));
            
            return $this->login($user, $pass, true);        
        }
        
        return false;
    }
    
    protected function cleanRememberedData() {

        if (isset($_COOKIE[$this->keyPrefix . 'lu'])) {
            setcookie($this->keyPrefix . 'lu', false, (time() - 3600), $this->cookiePath);
            unset($_COOKIE[$this->keyPrefix . 'lu']);            
        }

        if (isset($_COOKIE[$this->keyPrefix . 'ls'])) {
            setcookie($this->keyPrefix . 'ls', false, (time() - 3600), $this->cookiePath);
            unset($_COOKIE[$this->keyPrefix . 'ls']);            
        }
    }

    function login($user, $pass, $remember = false) {    
        global $DATA;     
        global $DATABASE;   

        $result = array();

        if ($user == null || $pass == null) {

            $result['status'] = 7; //Responde isto se faltarem dados

            header('Content-type: application/json');  //coloca o cabeçalho a identificar o tipo json
            echo json_encode($result);   //Codifica em  Json

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

                    $query = $DATABASE->query($sql);
                    
                    if (!$query) {

                        $result['status'] = 3;

                        header('Content-type: application/json');
                        echo json_encode($result);  

                    } else {

                        $data = $query->fetch(PDO::FETCH_ASSOC);
                        $query->closeCursor();
                        
                        foreach ($data AS $chave=>$value) {
                            $_SESSION[$this->keyPrefix . $chave] = $value;
                        }
                    }
                }
                
                $_SESSION[$this->keyPrefix . 'loggedIn'] = true;
                
                if ($this->cookie) {
                    
                    $value = join('#', array($user, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
                    $value = sha1($value);
                    
                    setcookie($this->keyPrefix . 'token', $value, 0, $this->cookiePath);
                }
            
                if ($remember) $this->rememberData($user, $pass);

                $result['status'] = 0;

                header('Content-type: application/json');
                echo json_encode($result);
                exit;
                
                            
            } else {
               
                //Dados errados!!!
                $result['status'] = 8;

                ob_end_clean();
                header('Content-type: application/json');
                echo json_encode($result);  
            }
        }
    }

    function loggedIn($cookies = true, $json = true) {
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

        
        if ($json) {

            $user = array();
            $user['user'] = $_SESSION[$this->keyPrefix . 'user'];

            $session_json = json_encode($user);

            echo "<script>
                 var user = eval('( "  . $session_json .  ")');
                </script>";
                
        }
    
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

    function registration($name, $user, $pass) {
        global $DATA; 
        global $DATABASE;      

        $result = array();

        if (!$name == '' && !$user == '' && !$pass == '')  {

            $confirmIfExists = $DATABASE->query("SELECT * FROM users WHERE user = '" . $user ."';");

            if ($confirmIfExists->rowCount() == 0) {

                $pass = $this->encryptPass($pass);

                $query =  "INSERT INTO users(name, user, password) VALUES ('".$name."', '".$user."', '".$pass."')";
                $DATABASE->query($query);

                $result['status'] = 0;

            } else {

                $result['status'] = 2;
            }   

        } else {

            $result['status'] = 7;

        }

        header('Content-type: application/json');
        echo json_encode($result);  

    }
}

?>