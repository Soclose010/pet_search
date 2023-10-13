<?php

namespace Src\Model;
use Src\Database\Connect;
class Model implements ModelInterface
{
    private $db;
    public function __construct()
    {
        $this->db = Connect::connect();
    }

    public function all($table): array
    {
        $sql = "select * from :table";
        $query = $this->db->prepare($sql);
        $query->bindValue(':table', $table);
        $query->execute();
        return $query->fetchAll();
    }

}