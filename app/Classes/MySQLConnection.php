<?php

namespace App\Classes;

use App\Interfaces\DatabaseConnectionInterface;
use PDO;

class MySQLConnection implements DatabaseConnectionInterface
{
    private PDO $connection;

    public function connect(): void
    {
        try {
            $dsn = "mysql:host=MySQL-8.2;dbname=MyNotes;charset=utf8";
            $this->connection = new PDO($dsn, 'root', '');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }
    public function query($query): \PDOStatement
    {
        return $this->connection->query($query);
    }
    public function prepare($query): \PDOStatement
    {
        return $this->connection->prepare($query);
    }
}