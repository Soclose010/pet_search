<?php

namespace Src\Model;
use Src\Database\Database;
class User
{
    private static $table = 'Users';
    private static $db;

    public function __construct()
    {
        self::$db = new Database(self::$table);
    }

    public static function all()
    {
        return self::$db->all();
    }

}