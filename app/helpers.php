<?php

function dump(mixed $data): void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function dd(mixed $data): void
{
    dump($data);
    die();
}

function abort(int $error_code = 404): void
{
    http_response_code($error_code);
    require_once VIEWS . "/errors/{$error_code}.tmpl.php";
    die();
}