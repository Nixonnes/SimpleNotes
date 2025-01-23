<?php

namespace App\Interfaces;

interface DatabaseConnectionInterface
{
    public function connect() : void;
    public function query(string $query): \PDOStatement;
    public function prepare(string $query): \PDOStatement;
}