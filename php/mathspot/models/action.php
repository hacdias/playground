<?php

namespace Model {

    class Action extends \Model {

        function __construct() {
            parent::__construct();
        }

        function actionFavLater($itemId = 0, $user, $thing, $action) {
            global $person;

            $result = array();

            do {

                if (!$person->loggedIn() && !$_SESSION['user_user'] == $user) {
                    $result['status'] = 5;

                    //$error = 'User error: "' . $user . '" is not logged in in models/action.php.';
                    //error_log($error);
                    break;
                }

                if ($itemId < 1) {
                    $result['status'] = 4;
                    break;
                }

                if (!\Person::exists($user)) {
                    $result['status'] = 1;
                    break;
                }

                $query = $this->db->query("SELECT {$thing} FROM users WHERE user ='{$user}'");

                if (!$query) {
                    $result['status'] = 3;
                    break;
                }

                $new = null;

                foreach ($query as $item) {
                    $new = $item[$thing];
                }

                $confirm = explode(',', $new);

                $alsoExists = false;

                for ($i = 0; $i < count($confirm); $i++) {

                    if ($confirm[$i] === $itemId) {

                        $alsoExists = true;

                    }

                }

                if (!$alsoExists) {

                    if ($action == 'add') {

                        $new .= $itemId . ',';

                        $result['status'] = ($this->db->query("UPDATE users SET {$thing}  ='{$new}' WHERE user ='{$user}';")) ? 0 : 3;

                    } else if ($action == 'rem') {

                        $result['status'] = 6;

                    }


                } else {

                    if ($action == 'add') {

                        $result['status'] = 2;

                    } else if ($action == 'rem') {

                        $new = str_replace($itemId . ',', '', $new);

                        if(empty($new)) {
                            $new = "NULL";
                        } else {
                            $new = "'" . $new . "'";
                        }

                        $result['status'] = ($this->db->query("UPDATE users SET {$thing} ={$new} WHERE user ='{$user}';")) ? 0 : 3;

                    } else {

                        $result['status'] = 6;

                    }
                }

            } while (0);

            ob_end_clean();
            header('Content-type: application/json');
            echo json_encode($result);

        }

    }
}