<?php
require_once 'functions.php';

$out = array();
$table = 'custom_radio';
$conf = get_config();
$db = mysqli_connect($conf->host, $conf->user, $conf->pass, $conf->base);

$error = null;
if (!$db) {
    $error = mysqli_connect_error();
}

$file = simplexml_load_file($conf->xml);
if (!$file && !$error) {
    $error = "Can't read xml file";
}

if ($file and $db) {
    if (!mysqli_query($db, "DESCRIBE $table")) {
        create_table($db, $table);
    }

    $old_title = trim($_POST['title']);
    $new_title = trim($file->title);
    if (($old_title !== '...') && ($old_title !== $new_title)) {
        insert_track($db, $table, $file);
    }
}
mysqli_close($db);

$ticker = $_POST['ticker'];
$ticker++;
if ($ticker == 11) {
    $ticker = 1;
}

if ($error) {
    $error = $error . '. Please, check "config.json" file.';
}

$out = array(
    'title'    => $file->title,
    'album'    => $file->album,
    'genre'    => $file->genre,
    'duration' => $file->duration,
    'next'     => $file->next,
    'ticker'   => $ticker,
    'error'    => $error,
);
$out = json_encode($out);

echo $out;
die;
