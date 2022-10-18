<?php

use Envms\FluentPDO\Query;

$DB_NAME = "truyen";
$DB_HOST = "localhost";
$DB_PASS = "Xix4BRtx5kWCRyA5";
$DB_USER = "truyen";

try {
    $REMOTE_CONN = new PDO(
        "mysql:dbname=$DB_NAME;host=$DB_HOST;port=3306;charset=utf8mb4",
        $DB_USER,
        $DB_PASS
    );
}
catch (PDOException $e){
    die($e);
}

function DB(): Query {
    global $REMOTE_CONN;
    return new Query($REMOTE_CONN);
}

function image_url_exists($url): bool
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($code == 200);
}