<?php
    header("HTTP/1.1 200 OK");
    date_default_timezone_set('Europe/Moscow');

    $domain = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'];
    $path = "/prs/nedv/";
    $botUrl = $domain.$path;

    $millitime = round(microtime(true) * 1000);
    $hash = sha1(rand(0,10000000).$millitime.rand(0,10000000));
    $time = time();

    $whUrl = "http://www.realty01.ru/webhook/source/";
?>