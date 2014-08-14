<?php

class Person {

    protected $database = 'MathSpot';
    protected $usersTable = 'users';

    protected $fields = array(
        'user' => 'user',
        'pass' => 'password'
    );

    protected $data = array('id', 'name');

    protected $loginVar = true;

    protected $keyPrefix = 'user_';

    protected $cookie = true;

    protected $rememberTime = 7;

    protected $cookiePath = '/';

    protected $erro = '';

    function __construct() {
        $this->db = new \Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    /**
     * Confirm if an user really exists
     *
     * @param   string $user Username
     * @return  bool
     */
    static public function exists($user) {
        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $confirmIfExists = $db->query("SELECT user FROM users WHERE user ='" . $user . "' LIMIT 1");

        if ($confirmIfExists) {
            return ($confirmIfExists->rowCount() == 0) ? false : true;
        } else {
            return false;
        }
    }

    /**
     * Get some information about an user.
     *
     * @param   string $user Username
     * @param   string $info The info needed
     *
     * @return  bool|string     Returns a boolean value if something went wrong or the string with info.
     */
    static public function getInfo($user, $info) {

        if ($info === 'color') {
            Person::getColor($user);
            return false;
        }

        if ($info === 'photo') {
            Person::getPhoto($user);
            return false;
        }

        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $results = $db->select("SELECT " . $info . " FROM users WHERE user ='" . $user . "' LIMIT 1");

        $sth = false;

        if ($results) {

            foreach ($results as $result) {
                $sth = $result[$info];
            }

        } else {

            $sth = false;

        }

        return $sth;
    }

    /**
     * Get user color.
     *
     * @param   string $user Username
     * @param   bool $accurate True for HEX and false for name.
     *
     * @return  bool|string     The color or false if something went wrong.
     */
    static public function getColor($user, $accurate = false) {

        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $idToColor = array(
            '1' => 'blue',
            '2' => 'green',
            '3' => 'red',
            '4' => 'orange'
        );

        $idToHex = array(
            '1' => '#007AFF',
            '2' => '#4CD964',
            '3' => '#e74c3c',
            '4' => '#FF9500'
        );

        $results = $db->select("SELECT color FROM users WHERE user ='" . $user . "' LIMIT 1");

        if ($results) {

            foreach ($results as $color) {
                $colorId = $color['color'];
            }

            if (empty($colorId)) {
                $colorId = '1';
            }

            return ($accurate) ? $idToHex[$colorId] : $idToColor[$colorId];

        } else {

            return false;

        }
    }

    /**
     * Get Photo URL
     *
     * @param   string $user Username
     * @return  string          Return the photo file name
     */
    static public function getPhoto($user) {
        $filename = ROOT . DS . 'public' . DS . 'imgs' . DS . 'users' . DS . $user . '_big.png';

        if (file_exists($filename)) {
            return $user;
        } else {
            return 'default';
        }
    }

    /**
     * Confirm if an user has admin roles
     *
     * @param   string $user Username
     * @return  bool
     */
    static public function isAdmin($user) {

        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $sql = $db->select("SELECT type FROM users WHERE user ='" . $user . "'");

        if ($sql) {

            foreach ($sql as $user) {
                $type = $user['type'];
            }

            $type = isset($type) ? $type : 1;

            return ($type == 0) ? true : false;

        } else {

            return false;

        }
    }

    static public function configUpdate($user, $color, $bio) {
        global $person;

        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $result = array();

        if ($person->loggedIn() && $_SESSION['user_user'] == $user) {

            if (!Person::exists($user)) {

                $result['status'] = 1;

            } else {

                $query = "UPDATE users SET color ='" . $color . "', bio ='" . $bio . "' WHERE user ='" . $user . "'";

                if ($db->query($query)) {

                    $result['status'] = 0;

                } else {

                    $result['status'] = 3;
                }
            }

        } else {
            $result['status'] = 5;
        }

        ob_end_clean();
        header('Content-type: application/json');
        echo json_encode($result);
    }

    /*
    static public function profile($user) {
        global $DATA;


    }

    static public function configPage($user) {
        global $DATA;

        if (!Person::exists($user)) {

            $page = new Piece('404', 'red');

        } else {

            $page = new Template(Helper::viewsDir('user.config'));

            $color = Person::getColor($user);
            $bio = Person::getInfo($user, 'bio');

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

            if (!Person::exists($user)) {

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
     */

    /**
     * Encrypt Pass Algorithm
     *
     * @param   string $string The password to be encrypted
     * @return  bool|string
     */
    protected function encryptPass($string) {

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'Pi8D1E2^e8s&vUnkg7~|asdfgjkg;T]]EGMuFM54sYMen~w5w5Tr]p.!4x%a1v;Z0X78sF';
        $secret_iv = 'N|;b,$567+76;Or.';

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }

    /**
     * Confirm if an user exists
     *
     * @param   string $user Username
     * @param   string $pass Password
     * @return  bool
     */
    protected function confirmUser($user, $pass) {
        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $pass = $this->encryptPass($pass);

        $sql = "SELECT COUNT(*) AS num
                FROM `{$this->database}`.`{$this->usersTable}`
                WHERE
                     `{$this->fields['user']}` = '{$user}'
                    AND
                     `{$this->fields['pass']}` = '{$pass}'";

        $query = $db->select($sql);

        if ($query) {

            $num = $query[0]['num'];
            return ($num == 1) ? true : false;

        } else {

            return false;
        }
    }

    /**
     * Set cookie to remember user login data.
     *
     * @param $user
     * @param $pass
     */
    protected function rememberData($user, $pass) {
        $time = strtotime("+{$this->rememberTime} day", time());

        $user = rand(1, 9) . base64_encode($user);
        $pass = rand(1, 9) . base64_encode($pass);

        setcookie($this->keyPrefix . 'lu', $user, $time, $this->cookiePath);
        setcookie($this->keyPrefix . 'ls', $pass, $time, $this->cookiePath);
    }

    /**
     * Confirm if the remembered data is correct.
     *
     * @return bool
     */
    protected function confirmRememberedData() {
        if (isset($_COOKIE[$this->keyPrefix . 'lu']) AND isset($_COOKIE[$this->keyPrefix . 'ls'])) {

            $user = base64_decode(substr($_COOKIE[$this->keyPrefix . 'lu'], 1));
            $pass = base64_decode(substr($_COOKIE[$this->keyPrefix . 'ls'], 1));

            return $this->login($user, $pass, true);
        }

        return false;
    }

    /**
     * Cleans the cookie with login data.
     */
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

    /**
     * Make user login
     *
     * @param   string $user Username
     * @param   string $pass Password
     * @param   bool $remember
     * @return  bool
     */
    public function login($user, $pass, $remember = false) {
        $db = new \Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $result = array();

        if ($user == null || $pass == null) {

            $result['status'] = 7;

        } else {

            if ($this->confirmUser($user, $pass)) {

                if ($this->loginVar AND !isset($_SESSION)) {
                    session_start();
                }

                if ($this->data != false) {

                    if (!in_array($this->fields['user'], $this->data)) {
                        $this->data[] = 'user';
                    }

                    $data = '`' . join('`, `', array_unique($this->data)) . '`';

                    // Consulta os data
                    $sql = "SELECT {$data}
                            FROM `{$this->database}`.`{$this->usersTable}`
                            WHERE `{$this->fields['user']}` = '{$user}'";

                    $query = $db->query($sql);

                    if (!$query) {

                        $result['status'] = 3;

                    } else {

                        $data = $query->fetch(PDO::FETCH_ASSOC);
                        $query->closeCursor();

                        foreach ($data AS $key => $value) {
                            $_SESSION[$this->keyPrefix . $key] = $value;
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

            } else {

                $result['status'] = 8;

            }
        }

        ob_end_clean();
        header('Content-type: application/json');
        echo json_encode($result);

        return false;
    }

    /**
     * Confirm if the user is logged In
     *
     * @param   bool $cookies
     * @param   bool $json
     * @return  bool
     */
    public function loggedIn($cookies = true, $json = true) {
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
                 var user = eval('( " . $session_json . ")');
                </script>";

        }

        return true;
    }

    /**
     * Logout the user
     *
     * @param   bool $cookies
     * @return  bool
     */
    function logout($cookies = true) {
        if ($this->loginVar AND !isset($_SESSION)) {
            session_start();
        }

        $size = strlen($this->keyPrefix);

        foreach ($_SESSION AS $chave => $value) {
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

    /**
     * Register an user
     *
     * @param $name
     * @param $user
     * @param $pass
     */
    public function registration($name, $user, $pass) {
        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $result = array();

        if (!$name == '' && !$user == '' && !$pass == '') {

            $confirmIfExists = $db->select("SELECT * FROM users WHERE user = '" . $user . "';");

            if (count($confirmIfExists) == 0) {

                $pass = $this->encryptPass($pass);

                $query = "INSERT INTO users(name, user, password) VALUES ('" . $name . "', '" . $user . "', '" . $pass . "')";
                $db->query($query);

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