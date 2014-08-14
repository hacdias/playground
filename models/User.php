<?php

namespace Model;

class User extends \Model {

    function __construct() {
        parent::__construct();
    }

    function profile($user) {

        if (!\Person::exists($user)) {
            return false;
        }

        $sth = array(
            'color' =>  \Person::getColor($user),
            'name'  =>  \Person::getInfo($user, 'name'),
            'bio'   =>  \Person::getInfo($user, 'bio'),
            'img'   =>  \Person::getPhoto($user)
        );

        return $sth;

    }

}