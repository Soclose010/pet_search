<?php

namespace Src\Database;
use PDO;
use PDOException;

class Connect
{
    public static function connect()
    {
        try {
            return new PDO('mysql:host=localhost;dbname=pseudo_pet;port=3306','root','');
        }
        catch (PDOException $e) {
            echo "подключение не выполнено: " . $e->getMessage();
        }


    }
}