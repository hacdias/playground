<?php

/**
 * USER SESSION CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 *
 * @author Thiago Belem <contato@thiagobelem.net> | Extremamente editado por Henrique Dias
 * @link http://blog.thiagobelem.net/
 */

require_once('config.php');

class UserSession extends Base {

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

        if ($user == '' || $pass == '') {

            $page = new Page('login', 'blue', false, true);

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
                        $page = new Page('login', 'blue', true); //return false
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
                echo '<script> history.go(-2); </script>';
                exit;
                
                            
            } else {
                $this->erro = 'Utilizador inválido';
                $page = new Page('login', 'blue', true);
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

            if (!$name == '' && !$user == '' && !$pass == '')  {

                $confirmIfExists = $DATA['db']->query("SELECT * FROM users WHERE user = '" . $user ."';");

                if ($confirmIfExists->rowCount() == 0) {

                    $pass = $this->encryptPass($pass);

                    $query =  "INSERT INTO users(name, user, password) VALUES ('".$name."', '".$user."', '".$pass."')";
                    $DATA['db']->query($query);

                    $queryData = "INSERT INTO userdata(user) VALUES ('".$name."')";
                    $DATA['db']->query($queryData);

                    $this->message('O seu registo foi concluido com sucesso!', true);

                } else {

                    $page =  new Page('register', 'blue', false, false, true);

                }   

            } else {

                $page =  new Page('register', 'blue', false, true);

            }

        } else {

            $page = new Page('tecnical', 'red');

        }
    }
    
}

?>