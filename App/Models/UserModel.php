<?php

namespace App\Models;

class UserModel extends \Core\Model
{
    public function getPasswordHash(string $user_name)
    {
        $statement = $this->connection->prepare('SELECT password_hash FROM user WHERE name = :user_name');
        $statement->bindValue(':user_name', $user_name, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
    public function addUser(string $user_name, string $password_hash)
    {
        $sql = 'INSERT INTO user (name, password_hash) VALUES (:user_name, :password_hash)';
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':user_name', $user_name, \PDO::PARAM_STR);
        $statement->bindValue(':password_hash', $password_hash, \PDO::PARAM_STR);
        $statement->execute();
        return true;
    }
    public function updatePasswordHash(string $user_name, string $password_hash)
    {
        $sql = 'UPDATE user SET password_hash = :password_hash WHERE name = :user_name';
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':user_name', $user_name, \PDO::PARAM_STR);
        $statement->bindValue(':password_hash', $password_hash, \PDO::PARAM_STR);
        $statement->execute();
        return true;
    }
}