<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../db.php';

$id = $argv[1];

$file  = __DIR__ . '/../pid/' . $id . '.txt';
if(!file_exists($file)){
    die;
}

$data = json_decode(file_get_contents($file));
$images = json_decode($data->content);
$die = 0;

foreach ($images as $url){
    if(image_url_exists($url)){
        continue;
    }

    $die++;
    if($die >= 1){
        try {
            $DB = DB()->deleteFrom('chapter_data', $data->id)->execute();
            $DB = DB()->deleteFrom('chapters', $data->chapter_id)->execute();
        } catch (\Envms\FluentPDO\Exception $e){

        }

        echo "Removed $data->id of source: $data->source";
    }
// Done!
}

unlink(__DIR__ . '/../pid/' . $id . '.txt');