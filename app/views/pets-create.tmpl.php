<?php

/**
 * @var \myClss\Validator $validator
 */
?>

<!doctype html>
<html lang="en">
<head>
    <?php require_once VIEWS . "/templates/head.php" ?>
    <title>Добавление питомца</title>
</head>
<body>
<?php require_once VIEWS . "/templates/navbar.php" ?>
<main class="mt-4">
    <?php getAlerts(['success'])?>
    <form class="row mx-5" action="/pets/create" method="post">
            <h3>Добавление питомца</h3>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Имя</label>
                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Имя" value="<?=old('name')?>">
                <?php
                    if (isset($validator))
                     printErrors($validator?->listErrors('name'));
                ?>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Порода</label>
                <input type="text" name="breed" class="form-control" id="exampleFormControlInput1" placeholder="Порода" value="<?=old('breed')?>">
                <?php
                if (isset($validator))
                    printErrors($validator?->listErrors('breed'));
                ?>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Фото</label>
                <input type="text" name="photo_path" class="form-control" id="exampleFormControlInput1" placeholder="Фото" value="<?=old('photo_path')?>">
                <?php
                if (isset($validator))
                    printErrors($validator?->listErrors('photo_path'));
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