<?php
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

//    $out['title'] = $file->title;
//    $out['album'] = $file->album;
//    $out['genre'] = $file->genre;
//    $out['duration'] = $file->duration;
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
    'title' => $file->title,
    'album' => $file->album,
    'genre' => $file->genre,
    'duration' => $file->duration,
    'ticker' => $ticker,
    'error' => $error,
);
$out = json_encode($out);

echo $out;
die;

function get_config()
{
    $conf = file_get_contents('../config.json');
    return json_decode($conf);
}

function create_table($db, $table)
{
    $query = "CREATE TABLE {$table} (
      id int NOT NULL AUTO_INCREMENT,
      title varchar(128),
      album varchar(128),
      genre varchar(128),
      duration int,
      PRIMARY KEY(id, title)
    ) DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;";

    $out = mysqli_query($db, $query);

    return $out;
}
