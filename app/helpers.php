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

function load (array $data, array $fillable): array
{
    $res = [];
    foreach ($data as $key => $item) {
        if (in_array($key,$fillable))
        {
            $res[$key] = trim($item);
        }
    }
    return $res;
}

function old(string $name): string
{
    return isset($_POST[$name]) ? h($_POST[$name]) : '';
}
function h (string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function redirect (string $url = '')
{
    if ($url == '')
    {
        $redirect = HOST;
    }
    else
    {
        $redirect = $url;
    }

    header("Location: {$redirect}");
    die();
}

function printErrors($errors): void
{
    if (is_null($errors))
        return;
    $output = include VIEWS . "/templates/validationError.php";
    foreach ($errors as $error)
    {
        echo str_replace(':message:', $error, $output);
    }
}

function getAlerts(array $alerts): void
{
    foreach ($alerts as $alert) {
        if (!empty($_SESSION[$alert])) {
            include VIEWS . "/templates/{$alert}Alert.php";
            unset($_SESSION[$alert]);
        }
    }
}