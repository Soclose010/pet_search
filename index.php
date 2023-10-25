<?php

require_once __DIR__ . '/vendor/autoload.php';
use Src\Model\Pet;
$pet = new Pet();
session_start();
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
<?php if(!isset($_SESSION['phone'])) {
    if (isset($_SESSION['errors']['login']))
    {
        foreach ($_SESSION['errors']['login'] as $error)
        {?>
            <p> <?= $error[0] ?></p>
<?php
        }
    }

    if (isset($_SESSION['errors']['register']))
    {
        foreach ($_SESSION['errors']['register'] as $error)
        {
            foreach ($error as $message) {
            ?>
            <p> <?= $message ?></p>
            <?php
            }
        }
    }
?>
<form method="post" action="src/Login.php">
    <h2>Войти в аккаунт</h2>
    <input type="text" placeholder="Телефон" name="phone">
    <input type="text" placeholder="Пароль" name="password">
    <input type="submit" value="Войти">
</form>
<form method="post" action="src/Register.php">
    <h2>Зарегистрироваться</h2>
    <input type="text" placeholder="Имя" name="name">
    <input type="text" placeholder="Фамилия" name="surname">
    <input type="text" placeholder="Телефон" name="phone">
    <input type="text" placeholder="Пароль" name="password">
    <input type="submit" value="Зарегистрироваться">
</form>
<?php }
else
{
    ?>
    <h3>Здравствуйте, <?= $_SESSION['name'] ?></h3>
    <a href="src/Logout.php">Выйти</a>
    <form method="POST" action="">
        <fieldset style="width:300px">
            <legend>Добавить питомца</legend>
            <input type="text" placeholder="Имя">
            <input type="text" placeholder="Порода">
            <input type="file" accept=".jpg, .png" placeholder="Фото">
            <input type="text" hidden value=<?= $_SESSION['phone']?>>
            <input type="submit">
        </fieldset>
    </form>
<?php
}
?>
<br>
<br>
<form method ="get" action="src/FilterPets.php">
    <?php
        if (isset($_SESSION['errors']['filter']))
        {
            foreach ($_SESSION['errors']['filter'] as $error)
            {?>
                    <p> <?= $error ?></p>
    <?php
            }
        }
    ?>
    <input type="text" placeholder="Имя" name="name">
    <input type="text" placeholder="Порода" name="breed">
    <input type="submit">
    <?php if (isset($_SESSION['filtered'])){ ?>
    <a href="src/FilterPets.php">Показать всех</a>
    <?php }?>
</form>

<div style="display: flex; width: 500px; justify-content: space-between">
    <div>
    <?php
        if (isset($_SESSION['filtered']))
        {
            $pets = $_SESSION['filtered'];
        }
        else
        {
            $pets = $pet->allWithUser();
        }
        foreach ($pets as $item) {
            ?>
            <div>
                <h3><?= $item['name'][0]?></h3>
                <p><?= $item['breed']?></p>
                <img src=<?= $item['photo']?> alt="" width="100px" height="100px">
                <p><?= $item['name'][1] . " " . $item['phone']?></p>
            </div>
    <?php
        }
    ?>
    </div>
    <div>
        <h3>Мои питомцы</h3>

    </div>
</div>
</body>
</html>