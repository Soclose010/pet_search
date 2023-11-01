<?php
/** @var Db $db */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fillable = ['name', 'breed', 'photo_path'];
    $data = load($_POST, $fillable);

    $errors = [];
    if (empty($data['name'])) {
        $errors['name'] = 'Поле обязательно';
    }

    if (empty($errors)) {
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