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

switch ($_POST['action']) {
    case 'xml':
        $file = simplexml_load_file($conf->xml);

        if (!$file && !$error) {
            $error = "Can't read xml file";
        }

        if ($file and $db) {
            if (!mysqli_query($db, "DESCRIBE $table")) {
                create_table($db, $table);
            }

            $title_array = explode('-', $file->title);
            $file->artist = $title_array[0];
            $file->title = $title_array[1];
            foreach ($file as $key => $item) {
                $item[$key] = trim($item);
            }
            $old_title = trim($_POST['title']);
            $new_title = trim($file->title);
            if ($old_title != '...' && $old_title != $new_title) {
                insert_track($db, $table, $file);
            }
        }

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
        break;

    case 'stat':
        $most_kind = $_POST['most_kind'];
        $period = $_POST['period'];
        $most = choose_stat($db, $table, $most_kind, $period);
        if ($most) {
            $row = mysqli_fetch_assoc($most);
            $name = trim($row[$most_kind]);
            $kind = $most_kind;
            switch ($most_kind) {
                case 'genre':
                    $most_kind = 'Most played music style';
                    break;

                case 'title':
                    $most_kind = 'Most played song';
                    break;

                case 'artist':
                    $most_kind = 'Most played artist';
                    break;

                case 'longest':
                    $most_kind = 'Longest song';
                    break;

                case 'shortest':
                    $most_kind = 'Shortest song';
                    break;
            }

            $out = array(
                'kind' => $kind,
                'most_kind' => $most_kind,
                'name'      => $name,
                'number'    => $row['number'],
                'artist'    => $row['artist'],
                'title'     => $row['title'],
                'duration'  => $row['duration'],
                'datetime'  => $row['datetime'],
            );
        }

        break;
}

mysqli_close($db);

if ($error) {
    $error = $error . '. Please, check "config.json" file.';
}

$out = json_encode($out);

echo $out;
die;
