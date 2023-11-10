<?php

namespace myClss;

use PDO;
use PDOException;
use PDOStatement;
class Db
{
    private PDO $connect;
    private PDOStatement $stmt;
    private static ?Db $instance = null;

    public static function getInstance(): Db
    {
        if (is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function connection(array $db_config): static
    {
        $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};port={$db_config['port']}";
        try {
            $this->connect = new PDO($dsn, $db_config['username'], $db_config['password'], $db_config['options']);
        } catch (PDOException) {
            abort(500);
        }
        return $this;
    }

    public function rawSql(string $query, array $params = []): static
    {
        try {
            $this->stmt = $this->connect->prepare($query);
            $this->stmt->execute($params);
        } catch (PDOException) {
            abort(500);
        }
        return $this;
    }

    public function findAll(): bool|array
    {
        return $this->stmt->fetchAll();
    }

    public function find(): bool|array
    {
        return $this->stmt->fetch();
    }

    public function getColumn()
    {
        return $this->stmt->fetchColumn();
    }

    private function __clone(): void
    {

    }

    private function __construct()
    {
    }

    public function __wakeup(): void
    {

    }

}