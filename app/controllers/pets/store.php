<?php
/** @var Db $db */

use myClss\Db;
use myClss\Validator;

$db = db();
$fillable = ['name', 'breed', 'photo_path'];
$data = load($_POST, $fillable);
if ($_FILES['photo_path']['error'] == 0)
    $data['photo_path'] = $_FILES['photo_path'];
else
    $data['photo_path'] = [];
$rules = [
    'name' => ['required', 'string', 'max:15'],
    'breed' => ['required', 'string'],
    'photo_path' => ['required', 'image:jpeg|png', 'size:1']
];
$validator = new Validator();
$validator->validate($data, $rules);

if (!$validator->hasErrors()) {

    $data['photo_path'] = upload($data['photo_path']);
    $data['user_id'] = $_SESSION['user']['id'];
    if (
        $db->rawSql("INSERT INTO Pets (`name`, `breed`, `photo_path`, `user_id`) VALUES (:name, :breed, :photo_path, :user_id)", $data)
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