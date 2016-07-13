- Radio script placed in "cstm-radio" directory.

- It needs included jQuery on page.

- Script config file placed in "cstm-radio/config.json".
In config file necessary to input .xml file address and database credentials.

- The script can be added to any page by two ways:
1)     <script>
           $("selector").load("cstm-radio/cstm-radio.php");
       </script>

2)     <?php include "cstm-radio/cstm-radio.php"; ?>
