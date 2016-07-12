<?php

class RadioDb
{
    protected $dbuser;
    protected $dbpassword;
    protected $dbname;
    protected $dbhost;
    private $use_mysqli = false;

    public $conf;
    public $sql_prefix;
    public $db_error;
    public $db;

    public function __construct()
    {
        if (function_exists('mysqli_connect')) {
            $this->use_mysqli = true;
        }

        $conf = file_get_contents(CSTMR_DIR . '/radio.json');
        $conf = json_decode($conf);

        $this->conf = $conf;

        $this->dbuser     = $conf->user;
        $this->dbpassword = $conf->pass;
        $this->dbname     = $conf->base;
        $this->dbhost     = $conf->host;
        $this->db         = null;
        $this->db_error   = null;

        $this->dbConnect();
    }

    public function dbConnect()
    {
        $sql_prefix = $this->use_mysqli ? 'mysqli' : 'mysql';
        $this->sql_prefix = $sql_prefix . '_connect';
        $connect_func = $this->sql_prefix;

        $db = $connect_func($this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname);

        $error = $this->use_mysqli ? mysqli_connect_error() : mysql_error();

        if (!$db) {
            $this->db_error = 'DB connect error: ' . $error;
        } else {
            $this->db = $db;
        }
    }
}
