<?php
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

function insert_track($db, $table, $file)
{
    $query = "INSERT INTO {$table} (title, album, genre, duration)
      VALUES ('{$file->title}', '{$file->album}', '{$file->genre}', {$file->duration});";

    $out = mysqli_query($db, $query);

    return $out;
}
