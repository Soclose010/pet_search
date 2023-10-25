<?php

namespace Src\Database;
use PDO;
use Symfony\Component\VarDumper\Cloner\Data;

class Database
{
    private PDO $db;
    private string $table;
    private array $fillable;
    private array $whereParams = [];
    private string $whereSql;

    private string $sql;
    public function __construct(string $table, array $fillable)
    {
        $this->db = Connect::connect();
        $this->table = $table;
        $this->fillable = $fillable;
    }

    public function all(): bool|array
    {
        return $this->db->query("select * from " . $this->table)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function allQuery(): Database
    {
        $this->sql ="select * from {$this->table}";
        return $this;
    }

    public function create(array $params): bool
    {
        $columsString = implode(', ', $this->fillable);
        $paramsString = implode(', :',$this->fillable);
        $sql = "insert into {$this->table} ({$columsString}) values (:$paramsString)";
        $res = $this->db->prepare($sql);
        foreach ($this->fillable as $item) {
            $res->bindValue($item, $params[$item]);
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

    public function get($fetch_type = PDO::FETCH_ASSOC): bool|array
    {
        if (count($this->whereParams) != 0) {

            $this->whereSql = implode(" AND ", $this->createWhereParamsArray());
            $this->sql .= " where {$this->whereSql}";
            $res = $this->db->prepare($this->sql);
            foreach ($this->whereParams as $whereParam) {
                if ($whereParam[2] === 'like')
                {
                    $res->bindValue($whereParam[0], "%" . $whereParam[1] ."%");
                }
                else
                {
                    $res->bindValue($whereParam[0], $whereParam[1]);
                }
            }
        } else
        {
            $res = $this->db->prepare($this->sql);
        }
        $res->execute();
        $this->clear();
        return $res->fetchAll($fetch_type);
    }

    protected function leftJoin(string $table, string $key, string $foreign_key) : Database
    {
        $this->sql .= " left join {$table} on {$key} = {$foreign_key}";
        return $this;
    }

    private function clear(): void
    {
        $this->whereParams= [];
    }

    private function createWhereParamsArray() : array
    {
        $res = [];
        foreach ($this->whereParams as $whereParam) {
            $res[] = "{$this->table}.{$whereParam[0]} {$whereParam[2]} :{$whereParam[0]}";
        }
        return $res;
    }
}