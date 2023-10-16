<?php

namespace Src\Model;

use Src\Database\Database;
use PDO;
class Pet extends Database
{
    private string $table = 'Pets';
    private string $withTable = 'Users';
    private string $withKey = 'users_id';
    private array $fillable = ['name', 'breed', 'photo', 'users_id'];
    public function __construct()
    {
        parent::__construct($this->table, $this->fillable);
    }

    public function allWithUser(): bool|array
    {
        return $this->allQuery()->leftJoin($this->withTable, $this->withTable . '.id', $this->table . "." . $this->withKey)->get(PDO::FETCH_NAMED);
    }

    public function whereWithUsers(array $params): bool|array
    {
        $res = $this->allQuery()->leftJoin($this->withTable, $this->withTable . '.id', $this->table . "." . $this->withKey);
        foreach ($params as $item) {
            if (isset($item[2]))
            {
                $res = $res->where($item[0],$item[1],$item[2]);
            }
            else
            {
                $res = $res->where($item[0],$item[1]);
            }
        }
        return $res->get(PDO::FETCH_NAMED);
    }
}