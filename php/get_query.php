<?php
    if($_POST['id']) {
        require_once 'db_connect.php';

        $query = $db_connect->prepare( 
        "SELECT q.query_string
        FROM public.user u
        JOIN public.query q ON q.user_id = u.id
        WHERE u.user_name = '{$db_config['user']}'
        AND q.id = ?");
        $query->execute(array($_POST['id']));
        $arr = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if($query) {
            if($arr[0]){
                echo $arr[0]['query_string'];
                exit();
            }
        } else {
            die ("Ошибка выполнения запроса"); 
        }
    }
?>