<?php

namespace Src\Database;
use PDO;
class Database
{
    private PDO $db;
    private string $table;
    private array $fillable;
    public function __construct(string $table, array $fillable)
    {
        $this->db = Connect::connect();
        $this->table = $table;
        $this->fillable = $fillable;
    }

    public function all()
    {
        return $this->db->query("select * from " . $this->table)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function where(string $param, string $value, string $operator = '=')
    {
        $sql = "select * from " . $this->table . " where {$param} {$operator} :{$param}";
        $res = $this->db->prepare($sql);
        $res->execute([$param => $value]);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $params)
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

    public function update(int $id, array $params)
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

    public function delete(int $id)
    {
        $sql = "delete from {$this->table} where id = :id";
        return $this->db->prepare($sql)->execute(['id'=> $id]);
    }
}