<?php

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

    public function rawSql(string $query, array $params = []): bool|static
    {
        try {
            $this->stmt = $this->connect->prepare($query);
            $this->stmt->execute($params);
        }
        catch (PDOException)
        {
            return false;
        }
        return $this;
    }

    public function findAll(): bool|array
    {
        return $this->stmt->fetchAll();
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