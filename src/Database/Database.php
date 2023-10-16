<?php

namespace Src\Database;
use PDO;
use Symfony\Component\VarDumper\Cloner\Data;

class Database
{
    private PDO $db;
    private string $table;
    private array $fillable;
    private array $whereParams;
    private string $whereSql;
    public function __construct(string $table, array $fillable)
    {
        $this->db = Connect::connect();
        $this->table = $table;
        $this->fillable = $fillable;
        $this->whereSql = "select * from {$this->table} where ";
    }

    public function all(): bool|array
    {
        return $this->db->query("select * from " . $this->table)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $params): bool
    {
        $columsString = implode(', ', $this->fillable);
        $paramsString = implode(', :',$this->fillable);
        $sql = "insert into {$this->table} ({$columsString}) values (:$paramsString)";
        $res = $this->db->prepare($sql);
        foreach ($this->fillable as $key => $item) {
            $res->bindValue($item, $params[$key]);
        }
        return $res->execute();
    }

    public function update(int $id, array $params): bool
    {
        $sql = "update {$this->table} set ";
        $setParamsString = [];
        foreach ($this->fillable as $key => $item)
        {
            $setParamsString[] = "{$item} = :{$item}";
        }
        $sql.= implode(", ", $setParamsString);
        $sql.= " where id = :id";
        $res = $this->db->prepare($sql);
        foreach ($this->fillable as $key => $item) {
            $res->bindValue($item, $params[$key]);
        }
        $res->bindValue('id', $id);
        return $res->execute();
    }

    public function delete(int $id): bool
    {
        $sql = "delete from {$this->table} where id = :id";
        return $this->db->prepare($sql)->execute(['id'=> $id]);
    }

    public function where(string $param, string $value, string $operator = '=') : Database
    {
        $this->whereParams[] = [$param, $value, $operator];
        return $this;
    }

    public function get(): bool|array
    {
        $this->whereSql.= implode(" AND ", $this->createWhereParamsArray());
        $res = $this->db->prepare($this->whereSql);
        foreach ($this->whereParams as $whereParam) {
            $res->bindValue($whereParam[0], $whereParam[1]);
        }
        $res->execute();
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    private function clear(): void
    {
        $this->whereParams= [];
    }

    private function createWhereParamsArray() : array
    {
        $res = [];
        foreach ($this->whereParams as $whereParam) {
            $res[] = "{$whereParam[0]} {$whereParam[2]} :{$whereParam[0]}";
        }
        return $res;
    }
}