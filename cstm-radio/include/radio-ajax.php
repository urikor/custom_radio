<?php
/**
 * Ajax functions.
 */

require_once 'functions.php';

$out = array();

// DB connect.
$table = 'custom_radio';
$conf = get_config();
$db = mysqli_connect($conf->host, $conf->user, $conf->pass, $conf->base);

// If connect error.
$error = null;
if (!$db) {
    $error = mysqli_connect_error();
}

switch ($_POST['action']) {
    // Read xml file action.
    case 'xml':
        $file = simplexml_load_file($conf->xml);

        // If read file error.
        if (!$file && !$error) {
            $error = "Can't read xml file";
        }

        if ($file and $db) {
            // If table doesn't exist.
            if (!mysqli_query($db, "DESCRIBE $table")) {
                create_table($db, $table);
            }

            // Parse track artist and title.
            $title_array = explode('-', $file->title);
            $file->artist = $title_array[0];
            $file->title = $title_array[1];
            foreach ($file as $key => $item) {
                $item[$key] = trim($item);
            }

            // Insert new track data to db.
            $old_title = trim($_POST['title']);
            $new_title = trim($file->title);
            if ($old_title != '...' && $old_title != $new_title) {
                insert_track($db, $table, $file);
            }
        }

        // Array for returning.
        $out = array(
            'title'    => $file->title,
            'artist'   => $file->artist,
            'album'    => $file->album,
            'genre'    => $file->genre,
            'duration' => $file->duration,
            'next'     => $file->next,
            'ticker'   => date('d/m/Y H:i:s'),
        );
        break;

    // Statistic action.
    case 'stat':
        // Get statistic for period from db.
        $most_kind = $_POST['most_kind'];
        $period = $_POST['period'];
        $most = get_statistic($db, $table, $most_kind, $period);
        if ($most) {
            $row = mysqli_fetch_assoc($most);
            $name = trim($row[$most_kind]);
            $kind = $most->num_rows == 0 ? '_none' : $most_kind;

            switch ($most_kind) {
                case 'genre':
                    $first_message_part = 'Most played music style';
                    break;

                case 'title':
                    $first_message_part = 'Most played song';
                    break;

                case 'artist':
                    $first_message_part = 'Most played artist';
                    break;

                case 'longest':
                    $first_message_part = 'Longest song';
                    break;

                case 'shortest':
                    $first_message_part = 'Shortest song';
                    break;
            }

            // Array for returning.
            $out = array(
                'kind'               => $kind,
                'first_message_part' => $first_message_part,
                'name'               => $name,
                'number'             => $row['number'],
                'artist'             => $row['artist'],
                'title'              => $row['title'],
                'duration'           => $row['duration'],
                'datetime'           => $row['datetime'],
            );
        }

        break;
}

mysqli_close($db);

if ($error) {
    $error = $error . '. Please, check "config.json" file.';
    $out['error'] = $error;
}

$out = json_encode($out);

echo $out;
die;
