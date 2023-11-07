<?php
/** @var Db $db */

use myClss\Db;
use myClss\Validator;

$db = db();
$fillable = ['name', 'breed', 'photo_path'];
$data = load($_POST, $fillable);

$rules = [
    'name' => ['required', 'string', 'number', 'max:15'],
    'breed' => ['required', 'string'],
    'photo_path' => ['required', 'string'],
];
$validator = new Validator();
$validator->validate($data, $rules);
if (!$validator->hasErrors()) {
    if (
        $db->rawSql("INSERT INTO Pets (`name`, `breed`, `photo_path`) VALUES (:name, :breed, :photo_path)", $data)
    ) {
        $_SESSION['success'] = "Добавление успешно";
        redirect("/pets/create");
    } else {
        abort(500);
    }
}
else
{
    $_SESSION['inputs'] = $_POST;
    $_SESSION['errors'] = $validator->getErrors();
    redirect("/pets/create");
}