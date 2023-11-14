<!doctype html>
<html lang="en">
<head>
    <?php require_once VIEWS . "/templates/head.php"?>
    <title>Document</title>
</head>
<body>
<?php require_once VIEWS . "/templates/navbar.php" ?>

<main class="mt-4">
    <?= $pagination->getHtml() ?>
    <?php
    foreach ($pets as $pet) {
        ?>
        <div class="card m-5" style="width: 18rem;">
            <img src="<?= HOST . $pet['photo_path']?>" class="card-img-top" alt="..." style="width: 40px">
            <div class="card-body">
                <h5 class="card-title"><?= $pet['name']?></h5>
                <p class="card-text"><?= $pet['breed']?></p>
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