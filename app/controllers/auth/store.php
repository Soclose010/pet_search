<?php

/**
 * @var \myClss\Db $db
 */
use myClss\Validator;

$fillable = [
    'phone',
    'password',
];

$data = load($_POST, $fillable);
$validator = new Validator();
$rules = [
    'phone' => ['required'],
    'password' => ['required'],
];
$validator->validate($data, $rules);

if (!$validator->hasErrors()) {
    $db = db();
    $user = $db->rawSql("SELECT * FROM Users WHERE phone = ?", [$data['phone']])->find();
    if ($user != [])
    {
        if (password_verify($data['password'], $user['password']))
        {
            $_SESSION['user'] = $user;
            unset($_SESSION['user']['password']);
            redirect('/');
        }
    }
    $_SESSION['loginError'] = 'Пользователь с таким сочетанием логина и пароля не найден';
}
else
{
    $_SESSION['inputs'] = $_POST;
    $_SESSION['errors'] = $validator->getErrors();
}
redirect("/login");