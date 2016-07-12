<?php

if (!class_exists('cstmRadio')) :

    class CSTMRadio
    {
        private static $instance;

        public static function instance()
        {

            if (!isset(self::$instance) && !(self::$instance instanceof cstmRadio)) {
                self::$instance = new cstmRadio;
                self::$instance->setup_constants();
                self::$instance->includes();
            }

            return self::$instance;
        }

        private function includes()
        {
            require_once 'include/radioDB.php';
            require_once 'include/radioXML.php';
            require_once 'include/CustomRadio.php';
            require_once 'include/load.php';
        }

        private function setup_constants()
        {
            if (!defined('CSTMR_DIR')) {
                define('CSTMR_DIR', dirname(__FILE__));
            }
        }
    }

endif;

function cstmR() {
    return CSTMRadio::instance();
}

cstmR();
