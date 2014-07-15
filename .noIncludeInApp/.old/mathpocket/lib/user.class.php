<?php

/**
 *
 * @author Thiago Belem <contato@thiagobelem.net>
 * @link http://blog.thiagobelem.net/
 * 
 */
class User {

    var $database = 'mathpocket';
    var $usersTable = 'users';

    var $fields = array(
        'user' => 'user',
        'pass' => 'password'
    );

    var $data = array('id', 'name');
    
    var $loginVar = true;
    
    var $keyPrefix = 'user_';
    
    var $cookie = true;
    
    var $caseSensitive = true;
    
    var $dataFilter = true;
    
    var $rememberTime = 7;
    
    var $cookiePath = '/';
    
    var $erro = '';
    
    function encryptPass($pass) {
        return sha1($pass);
    }
    
    function confirmUser($user, $pass) {

        mysql_connect('localhost', 'root', '30164554') or trigger_error(mysql_error());
        $pass = $this->encryptPass($pass);
        
        if ($this->dataFilter) {
            $user = mysql_escape_string($user);
            $pass = mysql_escape_string($pass);
        }
        
        // Os data são case-sensitive?
        $binary = ($this->caseSensitive) ? 'BINARY' : '';

        // Procura por usuários com o mesmo usuário e pass
        $sql = "SELECT COUNT(*) AS total
                FROM `{$this->database}`.`{$this->usersTable}`
                WHERE
                    {$binary} `{$this->fields['user']}` = '{$user}'
                    AND
                    {$binary} `{$this->fields['pass']}` = '{$pass}'";

        $query = mysql_query($sql);
        if ($query) {
            // Total de usuários encontrados
            $total = mysql_result($query, 0, 'total');
            
            // Limpa a consulta da memória
            mysql_free_result($query);
        } else {
            // A consulta foi mal sucedida, retorna false
            return false;
        }
        
        // Se houver apenas um usuário, retorna true
        return ($total == 1) ? true : false;
    }

    function login($user, $pass, $remember = false) {            
        // Verifica se é um usuário válido
        if ($this->confirmUser($user, $pass)) {
        
            if ($this->loginVar AND !isset($_SESSION)) {
                session_start();
            }
        
            if ($this->dataFilter) {
                $user = mysql_real_escape_string($user);
                $pass = mysql_real_escape_string($pass);
            }
            
            if ($this->data != false) {
                // Adiciona o campo do usuário na lista de data
                if (!in_array($this->fields['user'], $this->data)) {
                    $this->data[] = 'user';
                }
            
                // Monta o formato SQL da lista de fields
                $data = '`' . join('`, `', array_unique($this->data)) . '`';
        
                // Os data são case-sensitive?
                $binary = ($this->caseSensitive) ? 'BINARY' : '';

                // Consulta os data
                $sql = "SELECT {$data}
                        FROM `{$this->database}`.`{$this->usersTable}`
                        WHERE {$binary} `{$this->fields['user']}` = '{$user}'";

                $query = mysql_query($sql);
                
                // Se a consulta falhou
                if (!$query) {
                    $this->erro = 'A consulta dos data é inválida';
                    return false;
                } else {
                    $data = mysql_fetch_assoc($query);
                    // Limpa a consulta da memória
                    mysql_free_result($query);
                    
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
            return true;
            
                        
        } else {
            $this->erro = 'Utilizador inválido';
            return false;
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
}

?>