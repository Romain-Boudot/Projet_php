<?php

    class Token {

        private $token;
        private $action;
        private $id;
        private $expiration_time;

        public function __construct($action, $id) {

            $this->action = $action;
            $this->id = $id;

            $this->token = bin2hex(mcrypt_create_iv(42, MCRYPT_DEV_URANDOM));

            $this->expiration_time = time() + 120;

        }

        public function token_verify() {

            

        }

    }

?>