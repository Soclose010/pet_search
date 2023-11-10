<!doctype html>
<html lang="en">
<head>
    <?php require_once VIEWS . "/templates/head.php"?>
    <title>Регистрация</title>
</head>
<body>
<?php require_once VIEWS . "/templates/navbar.php" ?>
<main class="mt-4 mx-auto" style="width: 600px;">
    <?php getAlerts(['success'])?>
    <form class="row mx-5" action="/register" method="post">
        <h3>Регистрация</h3>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Имя</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Имя" value="<?=old('name')?>">
            <?php
            printErrors('name');
            ?>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Фамилия</label>
            <input type="text" name="surname" class="form-control" id="exampleFormControlInput1" placeholder="Фамилия" value="<?=old('surname')?>">
            <?php
            printErrors('surname');
            ?>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Телефон</label>
            <input type="tel" pattern="[0-9]{11}" name="phone" class="form-control" id="exampleFormControlInput1" placeholder="Телефон" value="<?=old('phone')?>">
            <?php
            printErrors('phone');
            ?>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="Пароль" value="">
            <?php
            printErrors('password');
            ?>
        </div>
        <input type="submit" class="btn btn-primary">
    </form>
</main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</html>