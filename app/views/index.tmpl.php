<!doctype html>
<html lang="en">
<head>
    <?php require_once VIEWS . "/templates/head.php"?>
    <title>Document</title>
</head>
<body>
<?php require_once VIEWS . "/templates/navbar.php" ?>
<form class="row mx-5 align-items-center" action="/" method="get">
    <h3>Добавление питомца</h3>
    <div class="mb-3" style="width: 200px">
        <label for="exampleFormControlInput1" class="form-label">Имя</label>
        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Имя">
        <?php
        printErrors('name');
        ?>
    </div>
    <div class="mb-3" style="width: 200px">
        <label for="exampleFormControlInput1" class="form-label">Порода</label>
        <input type="text" name="breed" class="form-control" id="exampleFormControlInput1" placeholder="Порода">
        <?php
        printErrors('breed');
        ?>
    </div>
    <div class="mb-3" style="width: 200px">
        <label for="exampleFormControlInput1" class="form-label">Телефон</label>
        <input type="text" name="phone" class="form-control" id="exampleFormControlInput1" placeholder="Телефон">
        <?php
        printErrors('phone');
        ?>
    </div>
    <input type="submit" class="btn btn-primary" value="Поиск" style="width: 200px; height: 40px">
    <a href="/" class="" style="width: 200px">Сбросить фильтры</a>
</form>
<main class="mt-4">
    <?= $pagination->getHtml() ?>
    <?php
    foreach ($pets as $pet) {
        ?>
        <div class="card m-5" style="width: 18rem;">
            <img src="<?= HOST . $pet['photo_path']?>" class="card-img-top" alt="..." style="width: 40px">
            <div class="card-body">
                <h5 class="card-title"><?= $pet['name'][0]?></h5>
                <p class="card-text"><?= $pet['breed']?></p>
                <p class="card-text"><?= "{$pet['name'][1]} {$pet['surname']} {$pet['phone']}"?></p>
            </div>
        </div>
    <?php
        }
    ?>

</main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</html>