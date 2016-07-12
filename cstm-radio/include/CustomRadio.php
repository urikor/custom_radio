<?php

class CustomRadio
{
    public function __construct()
    {
        echo '<div id="customRadio">';
        echo '<div class="title param"><span class="label">Track:</span><span id="title">Track name</span></div>';
        echo '<div class="album param"><span class="label">Album: </span><span id="album">Album</span></div>';
        echo '<div class="genre param"><span class="label">Genre: </span><span id="genre">Genre</span></div>';
        echo '<div class="duration param"><span class="label">Duration: </span><span id="duration"></span> s</div>';
        echo '<div class="next-song param"><span class="label">Next:</span><span id="next"></span> s</div>';
        echo '</div>';

//        $db = new RadioDb();
//        $db->dbConnect();
//        if (!$db->db) {
//            echo $db->db_error . "<br />";
//            echo "Please, check DB credentials in 'radio.json'";
//        } else {
//            $dbase = $db->db;
//            $xml_file = new radioXML($db->conf);
//            $xml = $xml_file->getXmlFile();
//            if ($xml) {
//                echo 'DB Connect successful<br />';
//                mysqli_select_db($dbase, 'd1');
//                $result = mysqli_query($dbase, "SELECT * FROM t1");
//                while ($row = mysqli_fetch_array($result)) {
//                    echo "ID:" . $row{'id'} . " Name:" . $row{'name'} . " Category: " . $row{'category'} . "<br>";
//                }
//            }
//        }
    }
}
