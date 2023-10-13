<?php

require_once __DIR__ . '/vendor/autoload.php';

use Src\Model\User;
dd(User::all());

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
<form action="">
    <h2>Войти в аккаунт</h2>
    <input type="text" placeholder="Телефон">
    <input type="text" placeholder="Пароль">
    <input type="submit">
    <a href="">Зарегестрироваться</a>
</form>
<br>
<br>
<form action="">
    <input type="text" placeholder="Имя">
    <input type="text" placeholder="Фамилия">
    <input type="text" placeholder="Телефон">
    <input type="submit">
</form>

<div>
    <div>
        <h3>Имя</h3>
        <p>Порода</p>
        <img src="https://media.istockphoto.com/id/1470130937/photo/young-plants-growing-in-a-crack-on-a-concrete-footpath-conquering-adversity-concept.webp?b=1&s=170667a&w=0&k=20&c=IRaA17rmaWOJkmjU_KD29jZo4E6ZtG0niRpIXQN17fc=" alt="" width="100px" height="100px">
        <p>Хозяин</p>
    </div>

</div>
</body>
</html>