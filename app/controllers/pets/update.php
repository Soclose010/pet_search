<?php

/**
 * @var \myClss\Db $db
 */
use myClss\Validator;

$fillable = ['name', 'breed', 'photo_path', 'id'];
$data = load($_POST, $fillable);
$rules = [
    'name' => ['required', 'string', 'max:15'],
    'breed' => ['required', 'string'],
    'id' => ['required', 'number'],
];
if ($_FILES['photo_path']['error'] == 0) {
    $data['photo_path'] = $_FILES['photo_path'];
    $rules['photo_path'] = ['required', 'image:jpeg|png', 'size:1'];
}
else
{
    $data['photo_path'] = [];
}
$validator = new Validator();
$validator->validate($data, $rules);

if (!$validator->hasErrors())
{
    $db = db();
    $pet = $db->rawSql("SELECT user_id, photo_path FROM Pets WHERE id = ?", [$data['id']])->find();
    if ($_SESSION['user']['id'] == $pet['user_id'])
    {
        if (!empty($data['photo_path']))
        {
            $data['photo_path'] = deleteAndUpload($pet['photo_path'],$data['photo_path']);
        }
        else
        {
            $data['photo_path'] = $pet['photo_path'];
        }

        if ($db->rawSql("UPDATE Pets SET name=:name, breed=:breed, photo_path=:photo_path WHERE id = :id",$data))
        {
            $_SESSION['updateSuccess'] = 'Изменение успешно';
            redirect("/pets");
        }
    }
    $_SESSION['updateError'] = 'Ошибка при изменении';
    redirect("/pets");
}
$_SESSION['errors'] = $validator->getErrors();
redirect("/pets/edit?id={$data['id']}");
