<?php

namespace App\Classes;

use App\Interfaces\DatabaseConnectionInterface;
use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private DatabaseConnectionInterface $connection;

    // Сделаем конструктор приватным, чтобы инстанцировать только через getInstance
    private function __construct(DatabaseConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->connection->connect();
    }

    // Метод для получения единственного экземпляра Database (Синглтон)
    public static function getInstance(DatabaseConnectionInterface $connection): Database
    {
        if (self::$instance === null) {
            self::$instance = new self($connection);
        }
        return self::$instance;
    }

    // Возвращаем объект подключения
    public function getConnection(): DatabaseConnectionInterface
    {
        return $this->connection;
    }

    // Выполнение произвольного запроса
    public function query(string $query): array
    {
        try {
            $stmt = $this->getConnection()->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Обработка исключений при выполнении запроса
            throw new \Exception('Query failed: ' . $e->getMessage());
        }
    }

    // Метод для получения всех записей из таблицы с возможностью фильтрации
    public function findAll(string $table, array $conditions = []): array
    {
        // Строим основной SQL запрос
        $query = "SELECT * FROM $table";

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        }

        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute($conditions);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Failed to fetch records: ' . $e->getMessage());
        }
    }

    // Метод для выполнения INSERT-запроса с подготовленными выражениями
    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        try {
            $stmt = $this->getConnection()->prepare($query);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new \Exception('Insert failed: ' . $e->getMessage());
        }
    }

    // Метод для выполнения UPDATE-запроса с подготовленными выражениями
    public function update(string $table, array $data, array $conditions): bool
    {
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $where = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));

        $query = "UPDATE $table SET $set WHERE $where";

        try {
            $stmt = $this->getConnection()->prepare($query);
            return $stmt->execute(array_merge($data, $conditions));
        } catch (PDOException $e) {
            throw new \Exception('Update failed: ' . $e->getMessage());
        }
    }

    // Метод для выполнения DELETE-запроса с подготовленными выражениями
    public function delete(string $table, array $conditions): bool
    {
        $where = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));

        $query = "DELETE FROM $table WHERE $where";

        try {
            $stmt = $this->getConnection()->prepare($query);
            return $stmt->execute($conditions);
        } catch (PDOException $e) {
            throw new \Exception('Delete failed: ' . $e->getMessage());
        }
    }
    public function find($table,$id)
    {
        $query = "SELECT * FROM $table WHERE id = $id";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Failed to fetch records: ' . $e->getMessage());
        }
    }
}
