<?php
/** @var Db $db */

use myClss\Db;
use myClss\Validator;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fillable = ['name', 'breed', 'photo_path'];
    $data = load($_POST, $fillable);

    $rules = [
        'name' => ['required', 'string'],
        'breed' => ['required', 'string'],
        'photo_path' => ['required', 'string'],
    ];
    $validator = new Validator();
    $validator->validate($data, $rules);

    if (!$validator->hasErrors()) {
        if (
            $db->rawSql("INSERT INTO Pets (`name`, `breed`, `photo_path`) VALUES (:name, :breed, :photo_path)", $data)
        ) {
            redirect("/pets/create");
        } else {
            abort(500);
        }
    }
}


require_once VIEWS . "/pets-create.tmpl.php";