<?php

namespace Src\Model;
use Src\Database\Database;
class User extends Database
{
    private string $table = 'Users';
    private array $fillable = ['name', 'surname', 'phone', 'password'];
    public function __construct()
    {
        parent::__construct($this->table, $this->fillable);
    }

}