<?php

    class Token {

        private $token;
        private $action;
        private $id;
        private $exp_date;

        public function __construct($action, $id) {

            $this->action = $action;
            $this->id = $id;
            $this->token = bin2hex(mcrypt_create_iv(42, MCRYPT_DEV_URANDOM));
            $this->exp_date = time() + 120;

        }

        public function get_token() {

            return $this->token;

        }

        public function token_check($action, $id, $token) {

            if ($action == $this->action && $id == $this->id && $token == $this->token && $this->exp_date >= time()) {
                return true;
            } else {
                return false;
            }

        }

    }

?>