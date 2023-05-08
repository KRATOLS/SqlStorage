<?php
     $db_config = file_get_contents('../settings.json');
     $db_config = json_decode($db_config, true);

     require_once 'classes.php';
     $con = new Connect($db_config);
     $db_connect = $con->setConnect();
?>