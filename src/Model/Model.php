<?php

namespace Src\Model;
use Src\Database\Connect;
use PDO;
abstract class Model implements ModelInterface
{
    protected static $db;
    protected $table;
    function __construct()
    {
        self::$db = Connect::connect();
    }

    public static function all($table)
    {
        $sql = "select * from " . $table;
        $query = self::$db->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}