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
    if ($_SESSION['user']['id'] == $db->rawSql("SELECT user_id FROM Pets WHERE id = :id", $data)->getColumn())
    {
        $db->rawSql("DELETE FROM Pets WHERE id = :id",$data);
        $_SESSION['deleteSuccess'] = 'Удалено';
        redirect('/pets');
    }
}
$_SESSION['deleteError'] = 'Ошибка при удалении';
redirect('/pets');

