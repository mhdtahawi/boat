<?php


class AuthorizationException extends Exception {



    public function __construct() {
        parent::__construct("Authorization error!");

    }


    public function getErrors() {

    }

}

?>
