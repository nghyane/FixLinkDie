<?php

chdir(__DIR__);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db.php';

//exec("$php_ver $cli_manga -s=$site >> $log_file & echo $!;");

$FixContent = (function($limit, $page){
    $DB = DB();

    $log_file = 'logs.txt';

    $query = $DB->from('chapter_data')
        ->limit($limit)
        ->where('type', 'image')
        ->offset($page * $limit)
        ->orderBy('id DESC');

    $datas = $query->asObject()->fetchAll();

    if(empty($datas)){
        return false;
    }
    foreach ($datas as $data){
        file_put_contents('pid/' . $data->id . '.txt', (json_encode($data)));
        #
        exec("php child/check-chap-die.php $data->id >> $log_file & echo $!;");
    }

    return  true;
});

$page = 0;
$running = true;

while ($running){
   $running = $FixContent(30, $page++);
   if($running){
       echo "Check to: " . $page * $running;
       sleep(30);
   } else {
       echo "Done!";
   }
}
