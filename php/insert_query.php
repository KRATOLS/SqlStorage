<?php

    if($_POST['query_name'] & $_POST['query_string']) {
        require_once 'db_connect.php';
        
        $query = $db_connect->prepare( 
        "SELECT u.id
        FROM PUBLIC.user u
        WHERE u.user_name = ?");
        $query->execute(array("{$db_config['user']}"));
        $arr = $query->fetchAll(PDO::FETCH_ASSOC);

        $user_id = $arr[0]['id'];
        $query_string = $_POST['query_string'];
        $query_name = $_POST['query_name'];

        $query = $db_connect->prepare( 
        "INSERT INTO public.query (user_id, name, query_string)
        VALUES (:id, :name, :query)");
        $query->execute(array('id' => $user_id, 'name' => $query_name, 'query' => $query_string));

        if (!$query) {
            die ("Ошибка выполнения запроса"); 
        } else {
            echo "Запрос успешно создан!";
            exit();
        }
            
    } else {
        echo "Ошибка! Незаполнены обязательный поля";
        exit();
    }
?>