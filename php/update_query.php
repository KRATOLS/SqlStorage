<?php
    if($_POST['name'] | $_POST['query_string']) {
        require_once 'db_connect.php';

        $query_string = $_POST['query_string'];
        $query_name = $_POST['name'];
        $query_id = $_POST['id'];

        $query = "UPDATE PUBLIC.query SET ";
        if($query_name & $query_string){
            $query .= "name = :name, query_string = :query WHERE id = :id";
            $result = $db_connect->prepare($query)->execute(array('name' => $query_name, 'query' => $query_string, 'id' => $query_id));
        } else if($query_string) {
            $query .= "query_string = :query WHERE id = :id";
            $result = $db_connect->prepare($query)->execute(array('query' => $query_string, 'id' => $query_id));
        } else {
            $query .= "name = :name WHERE id = :id";
            $result = $db_connect->prepare($query)->execute(array('name' => $query_name, 'id' => $query_id));
        }

        if (!$result) {
            die ("Ошибка выполнения запроса");
        } else {
            echo "Запрос успешно изменён!";
            exit();
        }

    } else {
        echo "Незаполнены обязательные поля";
        exit();
    }
?>