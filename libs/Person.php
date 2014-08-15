<?php

class Person {

    protected $sUsersTable = 'users';

    protected $aFields = array(
        'user' => 'user',
        'pass' => 'password'
    );

    protected $aData = array('id', 'name');

    protected $bLoginVar = true;

    protected $sKeyPrefix = 'user_';

    protected $bCookie = true;

    protected $iRememberTime = 7;

    protected $sCookiePath = '/';

    protected $sError = '';

    function __construct() {
        $this->db = new \Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    /**
     * Get some information about an user.
     *
     * @param   string $sUser Username
     * @param   string $sInfo The info needed
     *
     * @return  bool|string     Returns a boolean value if something went wrong or the string with info.
     */
    static public function getInfo($sUser, $sInfo) {

        if ($sInfo === 'color') {
            Person::getColor($sUser);
            return false;
        }

        if ($sInfo === 'photo') {
            Person::getPhoto($sUser);
            return false;
        }

        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $aResults = $db->select("SELECT " . $sInfo . " FROM users WHERE user ='" . $sUser . "' LIMIT 1");
        //$aResults->execute();


        $sth = false;

        if ($aResults) {

            foreach ($aResults as $aResult) {
                $sth = $aResult[$sInfo];
            }

        } else {

            $sth = false;

        }

        return $sth;
    }

    /**
     * Get user color.
     *
     * @param   string $sUser Username
     * @param   bool $bAccurate True for HEX and false for name.
     *
     * @return  bool|string     The color or false if something went wrong.
     */
    static public function getColor($sUser, $bAccurate = false) {

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

        $aResults = $db->select("SELECT color FROM users WHERE user ='" . $sUser . "' LIMIT 1");

        if ($aResults) {

            foreach ($aResults as $aColor) {
                $sColorId = $aColor['color'];
            }

            if (empty($sColorId)) {
                $sColorId = '1';
            }

            return ($bAccurate) ? $idToHex[$sColorId] : $idToColor[$sColorId];

        } else {

            return false;

        }
    }

    /**
     * Get Photo URL
     *
     * @param   string $sUser Username
     * @return  string Return the photo file name
     */
    static public function getPhoto($sUser) {
        $sFilename = ROOT . DS . 'public' . DS . 'imgs' . DS . 'users' . DS . $sUser . '_big.png';

        if (file_exists($sFilename)) {
            return $sUser;
        } else {
            return 'default';
        }
    }

    /**
     * Confirm if an user has admin roles
     *
     * @param   string $sUser Username
     * @return  bool
     */
    static public function isAdmin($sUser) {

        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $aResults = $db->select("SELECT type FROM users WHERE user ='" . $sUser . "'");

        if ($aResults) {

            $iType = isset($aResults[0]['type']) ? intval($aResults[0]['type']) : 1;

            /* foreach ($aResults as $aResult) {
                $iType = intval($aResult['type']);
            } */

            //$iType = isset($iType) ? $iType : 1;

            return ($iType === 0) ? true : false;

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

                $bio = htmlspecialchars($bio);

                if (strlen($bio) > 600) {
                    $bio = substr($bio, 0, 597) . '...';
                }

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

    /**
     * Confirm if the user is logged In
     *
     * @param   bool $bCookies
     * @param   bool $bJson
     * @return  bool
     */
    public function loggedIn($bCookies = true, $bJson = true) {
        if ($this->bLoginVar AND !isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION[$this->sKeyPrefix . 'loggedIn']) OR !$_SESSION[$this->sKeyPrefix . 'loggedIn']) {

            if ($bCookies) {
                return $this->confirmRememberedData();
            } else {
                $this->sError = 'Não há usuário loggedIn';
                return false;
            }
        }

        if ($this->bCookie) {
            if (!isset($_COOKIE[$this->sKeyPrefix . 'token'])) {
                $this->sError = 'Não existem utilizadores com sessão iniciada.';
                return false;
            } else {
                $value = join('#', array($_SESSION[$this->sKeyPrefix . 'user'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
                $value = sha1($value);

                if ($_COOKIE[$this->sKeyPrefix . 'token'] !== $value) {
                    $this->sError = 'Não há usuário loggedIn';
                    return false;
                }
            }
        }


        if ($bJson) {

            $user = array();
            $user['user'] = $_SESSION[$this->sKeyPrefix . 'user'];

            $session_json = json_encode($user);

            echo "<script>
                 var user = eval('( " . $session_json . ")');
                </script>";

        }

        return true;
    }

    /*
    static public function profile($user) {
        global $DATA;


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
     * Confirm if the remembered aData is correct.
     *
     * @return bool
     */
    protected function confirmRememberedData() {
        if (isset($_COOKIE[$this->sKeyPrefix . 'lu']) AND isset($_COOKIE[$this->sKeyPrefix . 'ls'])) {

            $user = base64_decode(substr($_COOKIE[$this->sKeyPrefix . 'lu'], 1));
            $pass = base64_decode(substr($_COOKIE[$this->sKeyPrefix . 'ls'], 1));

            return $this->login($user, $pass, true);
        }

        return false;
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

                if ($this->bLoginVar AND !isset($_SESSION)) {
                    session_start();
                }

                if ($this->aData != false) {

                    if (!in_array($this->aFields['user'], $this->aData)) {
                        $this->aData[] = 'user';
                    }

                    $aData = '`' . join('`, `', array_unique($this->aData)) . '`';

                    // Consulta os aData
                    $sql = "SELECT {$aData}
                            FROM `{$this->sUsersTable}`
                            WHERE `{$this->aFields['user']}` = '{$user}'";

                    $query = $db->query($sql);

                    if (!$query) {

                        $result['status'] = 3;

                    } else {

                        $aData = $query->fetch(Database::FETCH_ASSOC);
                        $query->closeCursor();

                        foreach ($aData AS $key => $value) {
                            $_SESSION[$this->sKeyPrefix . $key] = $value;
                        }
                    }
                }

                $_SESSION[$this->sKeyPrefix . 'loggedIn'] = true;

                if ($this->bCookie) {

                    $value = join('#', array($user, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']));
                    $value = sha1($value);

                    setcookie($this->sKeyPrefix . 'token', $value, 0, $this->sCookiePath);
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
                FROM {$this->sUsersTable}
                WHERE
                     `{$this->aFields['user']}` = '{$user}'
                    AND
                     `{$this->aFields['pass']}` = '{$pass}'";

        $query = $db->select($sql);

        if ($query) {

            $num = $query[0]['num'];
            return ($num == 1) ? true : false;

        } else {

            return false;
        }
    }

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
     * Set cookie to remember user login aData.
     *
     * @param $user
     * @param $pass
     */
    protected function rememberData($user, $pass) {
        $time = strtotime("+{$this->iRememberTime} day", time());

        $user = rand(1, 9) . base64_encode($user);
        $pass = rand(1, 9) . base64_encode($pass);

        setcookie($this->sKeyPrefix . 'lu', $user, $time, $this->sCookiePath);
        setcookie($this->sKeyPrefix . 'ls', $pass, $time, $this->sCookiePath);
    }

    /**
     * Confirm if an user really exists
     *
     * @param   string $sUser Username
     * @return  bool
     */
    static public function exists($sUser) {
        $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

        $confirmIfExists = $db->query("SELECT user FROM users WHERE user ='" . $sUser . "' LIMIT 1");

        if ($confirmIfExists) {

            return ($confirmIfExists->rowCount() == 0) ? false : true;

        } else {

            return false;
        }
    }

    /**
     * Logout the user
     *
     * @param   bool $cookies
     * @return  bool
     */
    function logout($cookies = true) {
        if ($this->bLoginVar AND !isset($_SESSION)) {
            session_start();
        }

        $size = strlen($this->sKeyPrefix);

        foreach ($_SESSION AS $chave => $value) {
            if (substr($chave, 0, $size) == $this->sKeyPrefix) {
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

        if ($this->bCookie AND isset($_COOKIE[$this->sKeyPrefix . 'token'])) {
            setcookie($this->sKeyPrefix . 'token', false, (time() - 3600), $this->sCookiePath);
            unset($_COOKIE[$this->sKeyPrefix . 'token']);
        }

        if ($cookies) $this->cleanRememberedData();

        return !$this->loggedIn(false);
    }

    /**
     * Cleans the cookie with login aData.
     */
    protected function cleanRememberedData() {

        if (isset($_COOKIE[$this->sKeyPrefix . 'lu'])) {
            setcookie($this->sKeyPrefix . 'lu', false, (time() - 3600), $this->sCookiePath);
            unset($_COOKIE[$this->sKeyPrefix . 'lu']);
        }

        if (isset($_COOKIE[$this->sKeyPrefix . 'ls'])) {
            setcookie($this->sKeyPrefix . 'ls', false, (time() - 3600), $this->sCookiePath);
            unset($_COOKIE[$this->sKeyPrefix . 'ls']);
        }
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