<?php
/**
 * Misc functions.
 */

/**
 * Gets configuration from config file.
 *
 * @return mixed
 */
function get_config()
{
    $conf = file_get_contents('../config.json');
    return json_decode($conf);
}

/**
 * Creates database table for storing radio tracks.
 *
 * @param mysqli object $db
 *   db object
 * @param string $table
 *   table name
 * @return bool|mysqli_result
 */
function create_table($db, $table)
{
    $query = "CREATE TABLE {$table} (
      id int NOT NULL AUTO_INCREMENT,
      title varchar(128),
      artist varchar(128),
      album varchar(128),
      genre varchar(128),
      duration int,
      datetime int,
      PRIMARY KEY(id, title)
    ) DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_general_ci;";

    $out = mysqli_query($db, $query);

    return $out;
}

/**
 * Inserts track record in table.
 *
 * @param mysqli object $db
 *   db object
 * @param string $table
 *   table name
 * @param object $file
 *   object of track xml file
 * @return bool|mysqli_result
 */
function insert_track($db, $table, $file)
{
    $time = time();
    $query = "INSERT INTO {$table} (title, artist, album, genre, duration, datetime)
      VALUES ('{$file->title}', '{$file->artist}', '{$file->album}', '{$file->genre}', {$file->duration}, {$time});";

    $out = mysqli_query($db, $query);

    return $out;
}

/**
 * Gets track statistic from db.
 *
 * @param mysqli object $db
 *   db object
 * @param string $table
 *   table name
 * @param string $most_kind
 *   kind of statistic (title,genre,artist,longest,shortest)
 * @param $period
 *
 * @return bool|mysqli_result
 */
function get_statistic($db, $table, $most_kind, $period)
{
    // Prepare period values.
    $hour = 60 * 60;
    $day = $hour * 24;
    $week = $day * 7;
    $month = $day * 30;
    $year = $day * 365;
    $period = $$period;
    $current_time = time();
    $range = $current_time - $period;
    $period_condition = "WHERE datetime < {$current_time} AND datetime >= {$range}";

    switch ($most_kind) {
        case 'title':
        case 'genre':
        case 'artist':
            $query = "SELECT {$most_kind}, datetime, COUNT({$most_kind}) AS 'number' FROM {$table}
              " . $period_condition . "
              GROUP BY {$most_kind} ORDER BY 'number' DESC LIMIT 1";
            break;

        case 'longest':
            $query = "SELECT artist, title, duration, datetime, MAX(duration) AS value FROM {$table}
                " . $period_condition . "
                GROUP BY title ORDER BY value DESC LIMIT 1";
            break;

        case 'shortest':
            $query = "SELECT artist, title, duration, datetime, MIN(duration) AS value FROM {$table}
                " . $period_condition . "
                GROUP BY title ORDER BY value ASC LIMIT 1";
            break;

        default:
            $query = false;
            break;
    }

    $out = $query ? mysqli_query($db, $query) : false;

    return $out;
}
