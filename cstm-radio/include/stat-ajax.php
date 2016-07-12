<?php
$query = "SELECT ";

$out = mysqli_query($db, $query);

$out = array(
    'title'    => $file->title,
    'artist'   => $file->artist,
    'album'    => $file->album,
    'genre'    => $file->genre,
    'duration' => $file->duration,
    'next'     => $file->next,
    'ticker'   => date('d/m/Y H:i:s'),
    'error'    => $error,
);
$out = json_encode($out);

echo $out;
die;
