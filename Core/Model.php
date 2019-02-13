<?php

namespace Core;

class Model
{
    protected $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }
}