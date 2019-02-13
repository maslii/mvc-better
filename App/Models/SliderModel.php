<?php

namespace App\Models;

class SliderModel extends \Core\Model
{
    public function getImages() : array
    {
        $statement = $this->connection->query('SELECT * FROM slider');

        return $statement->fetchAll();
    }

    public function getImage(int $image_id)
    {
        $statement = $this->connection->prepare('SELECT * FROM slider WHERE id=:image_id');
        $statement->bindValue(':image_id', $image_id, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function insertImage(string $image_path)
    {
        $statement = $this->connection->prepare('INSERT INTO slider (image) VALUES (:image_path)');
        $statement->bindValue(':image_path', $image_path, \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function removeImage(int $id)
    {
        $statement = $this->connection->prepare('DELETE FROM slider WHERE id=:id');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        return $statement->execute();
    }
}