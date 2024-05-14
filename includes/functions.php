<?php

function runtime_prettier($time)
{
    if ($time != '' && $time > 0) {
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return "$hours hours" . " " . "$minutes minutes";
    } else {
        return 'not set';
    }
}

function movie_by_id($fild)
{
    if (!isset($_GET['movie_id'])) {
        return false;
    }

    if ($fild['id'] == $_GET['movie_id']) {
        return true;
    } else {
        return false;
    }
};

function db_connect($host = "localhost", $username = "php-user-2", $password = "Fabiedi66*", $dbname = "php-proiect-2")
{
    return mysqli_connect($host, $username, $password, $dbname);
}

?>
