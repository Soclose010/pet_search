<?php


function dump(mixed $data): void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function dd(mixed $data = null): void
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

function old(string $name): void
{
    if (isset($_SESSION['inputs'][$name]))
    {
        echo h($_SESSION['inputs'][$name]);
        unset($_SESSION['inputs'][$name]);
    }
}
function h (string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function redirect (string $url = '')
{
    $redirect = $url == '' ? HOST : $url;
    header("Location: {$redirect}");
    die();
}

function printErrors(string $name): void
{
    if (empty($_SESSION['errors'][$name]))
        return;
    $output = include VIEWS . "/templates/validationError.php";
    foreach ($_SESSION['errors'][$name] as $error)
    {
        echo str_replace(':message:', $error, $output);
    }
    unset($_SESSION['errors'][$name]);

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

function db()
{
    return \myClss\App::getContainer()->getService(\myClss\Db::class);
}