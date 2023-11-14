<?php
/**
 * @var \myClss\Db $db
 */

use myClss\Validator;

$db = db();
$data = $_GET;
$validator = new Validator();
$validator->validate($data, [
    'id' => ['required', 'number'],
]);
if (!$validator->hasErrors())
{
    $pet = $db->rawSql("SELECT * FROM Pets WHERE id = ? AND user_id = ?", [$data['id'],$_SESSION['user']['id']])->find();
    require_once VIEWS . "/pets/edit.tmpl.php";
}
else
{
    $_SESSION['updateError'] = 'Ошибка при обновлении';
    redirect('/pets');
}
