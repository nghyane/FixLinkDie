<?php

chdir(__DIR__);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db.php';

//exec("$php_ver $cli_manga -s=$site >> $log_file & echo $!;");

$FixContent = (function($limit, $page){
    $DB = DB();

    $log_file = 'logs.txt';
    $pid = [];

    $query = $DB->from('chapter_data')
        ->limit($limit)
        ->where('type', 'image')
        ->offset($page * $limit)
        ->orderBy('id DESC');

    $datas = $query->asObject()->fetchAll();

    foreach ($datas as $data){
        file_put_contents('pid/' . $data->id . '.txt', (json_encode($data)));
        #>> $log_file & echo $!;
        system("php child/check-chap-die.php $data->id");

        exit();
    }

});


$FixContent(10, 0);