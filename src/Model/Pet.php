<?php

namespace Src\Model;

use Src\Database\Database;

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

    public function allWithUser()
    {
        return $this->leftJoin($this->withTable, $this->withTable . '.id', $this->table . "." . $this->withKey);
    }
}