<?php

require_once __DIR__ . '/vendor/autoload.php';

use Src\Model\Pet;
$pet = new Pet();
//dd($user->where('name','123', 'like'));
//dd($user->create(['123', '432', '55535535', 'pass']));
//dd($user->update(1,['123', '432', '555352535', 'pass']));
//dd($user->delete(3));

//dd($user->where('name', '123', 'like')->get());
//dd($pet->allWithUser())
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Поиск питомцев</title>
</head>
<body>
<h1>Сайт по поиску питомцев</h1>
<form method="post" action="">
    <h2>Войти в аккаунт</h2>
    <input type="text" placeholder="Телефон">
    <input type="text" placeholder="Пароль">
    <input type="submit">
    <a href="">Зарегистрироваться</a>
</form>
<br>
<br>
<form method ="get" action="src/FilterPets.php">
    <input type="text" placeholder="Имя" name="name">
    <input type="text" placeholder="Фамилия" name="surname">
    <input type="text" placeholder="Телефон" name="phone">
    <input type="submit">
    <a href="index.php">Показать всех</a>
</form>

<div>
    <?php
        $pets = $pet->allWithUser();
        foreach ($pets as $item) {
            ?>
            <div>
                <h3><?= $item['name'][0]?></h3>
                <p><?= $item['breed']?></p>
                <img src=<?= $item['photo']?> alt="" width="100px" height="100px">
                <p><?= $item['name'][1]?></p>
            </div>
    <?php
        }
    ?>
</div>
</body>
</html>