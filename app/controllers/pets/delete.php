<?php

/**
 * @var \myClss\Db $db
 */
use myClss\Validator;

$data = $_POST;
$db = db();
$validator = new Validator();
$validator->validate($data, [
    'id' => ['required', 'number'],
]);
if (!$validator->hasErrors())
{
    $pet = $db->rawSql("SELECT user_id, photo_path FROM Pets WHERE id = :id", $data)->find();
    if ($_SESSION['user']['id'] == $pet['user_id'])
    {
        if($db->rawSql("DELETE FROM Pets WHERE id = :id",$data))
        {
            delete($pet['photo_path']);
            $_SESSION['deleteSuccess'] = 'Удалено';
            redirect('/pets');
        }

    }
}
$_SESSION['deleteError'] = 'Ошибка при удалении';
redirect('/pets');

