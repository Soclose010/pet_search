<?php

use myClss\Validator;

$fillable = [
    'name',
    'surname',
    'phone',
    'password',
];

$data = load($_POST, $fillable);
$validator = new Validator();
$rules = [
    'name' => ['required', 'string'],
    'surname' => ['required', 'string'],
    'phone' => ['required', 'number', 'min:11', 'max:11', 'unique:Users'],
    'password' => ['required', 'string', 'min:6', 'hasCap', 'hasUncap', 'hasNum'],
];
$validator->validate($data, $rules);

if (!$validator->hasErrors()) {
    $db = db();
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    if (
        $db->rawSql("INSERT INTO Users (`name`, `surname`, `phone`, `password`) VALUES (:name, :surname, :phone, :password)", $data)
    ) {
        $_SESSION['success'] = "Добавление успешно";
        redirect("/register");
    } else {
        abort(500);
    }
}
else
{
    $_SESSION['inputs'] = $_POST;
    $_SESSION['errors'] = $validator->getErrors();
    redirect("/register");
}