<?php

namespace Src\Database;
use PDO;
class Database
{
    private PDO $db;
    private string $table;
    public function __construct(string $table)
    {
        $this->db = Connect::connect();
        $this->table = $table;
    }

    public function all()
    {
        $sql = "select * from " . $this->table;
        $res = $this->db->query($sql);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
}