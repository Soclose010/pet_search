<!doctype html>
<html lang="en">
<head>
    <?php require_once VIEWS . "/templates/head.php"?>
    <title>Мои питомцы</title>
</head>
<body>
<?php require_once VIEWS . "/templates/navbar.php" ?>
<main class="mt-4 mx-auto gap-3 row row-cols-1" style="width: 600px;">
    <div class="row">
        <?php getAlerts(['deleteSuccess', 'deleteError'])?>
    </div>
    <div class="row justify-content-between">
    <?php foreach ($myPets as $pet):?>
        <div class="card col-4" style="width: 250px;">
            <img src="<?=$pet['photo_path']?>" class="card-img-top" alt="..." style="width: 40px; height: 40px">
            <div class="card-body d-flex flex-column justify-content-between gap-3">
                <div>
                    <h5 class="card-title"><?=$pet['name']?></h5>
                    <p class="card-text"><?=$pet['breed']?></p>
                </div>
                <div>
                    <a href="pets/change" class="btn btn-primary">Изменить</a>
                    <form action="pets/delete" method="post" class="d-inline">
                        <input type="hidden" name="id" value="<?=$pet['id']?>">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    <? endforeach;?>
    </div>
</main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</html>