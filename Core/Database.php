<?php

namespace Core;

class Database
{
    protected $dsn;
    protected $user_name;
    protected $user_password;
    protected $options;
    protected $connection;

    public function __construct(
        string $db_server,
        string $db_host,
        string $db_name,
        string $db_charset,
        string $db_user_name,
        string $db_user_password,
        array $options
    )
    {
        $this->dsn = $db_server . ':host=' . $db_host . ';dbname=' . $db_name . ';charset=' . $db_charset;
        $this->user_name = $db_user_name;
        $this->user_password = $db_user_password;
        $this->options = $options;
    }

    public function getConnection()
    {
        /*if (!$this->connection instanceof \PDO) {
            $this->connection = new \PDO($this->dsn, $this->user_name, $this->user_password, $this->options);
        }*/

        $this->connection = new \PDO($this->dsn, $this->user_name, $this->user_password, $this->options);

        return $this->connection;
    }
}