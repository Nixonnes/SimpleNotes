<?php

namespace App\Models;
use App\Classes\Database;
use App\Interfaces\DatabaseConnectionInterface;

class Model
{
    protected static ?string $table = null;
    protected static Database $db;


    public static function initialize(DatabaseConnectionInterface $connection): void
    {
        self::$db = Database::getInstance($connection);
    }
    protected static function getTableName(): string
    {
        $model = (new \ReflectionClass(static::class))->getShortName();
        return static::$table ?? strtolower($model) . 's';
    }
    public static function findAll(): array
    {
        $table = static::getTableName();
        return self::$db->findAll($table);
    }

    /**
     * @throws \Exception
     */
    public static function create(array $data) : void
    {
        $table = static::getTableName();
        self::$db->insert($table, $data);
    }

    /**
     * @throws \Exception
     */
    public static function update(array $data,$conditions) : void
    {
        $table = static::getTableName();
        self::$db->update($table, $data,$conditions);
    }
    public static function delete($conditions) : void
    {
        $table = static::getTableName();
        self::$db->delete($table,$conditions);
    }

    /**
     * @throws \Exception
     */
    public static function find($id)
    {
        $table = static::getTableName();
        return self::$db->find($table, $id);
    }
}