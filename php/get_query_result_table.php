<?php

    if(!empty($_POST['query'])) {
        require_once 'db_connect.php';
        
        //$query = pg_query($db_connect, $_POST['query']);
        $query = $db_connect->prepare($_POST['query']);
        $query->execute();
        $arr = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$query) {
            die ("Ошибка выполнения запроса");
        } else {
            if (!empty($arr)) {
                $table = new QueryResultTable($arr);
                echo $table->getTable();
            } 
        }
    }
    
?>