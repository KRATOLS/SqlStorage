<?php
    require_once 'db_connect.php';
    
    $query = $db_connect->prepare(
    "SELECT q.id, q.name
    FROM public.user u
    JOIN public.query q ON q.user_id = u.id
    WHERE u.user_name = ?");
    $query->execute(array($db_config['user']));
    $arr = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$query) {
        die ("Ошибка выполнения запроса");
    } else {
        $select = new Select($arr, 'Выбор запроса');
        echo $select->getSelect();
    }
?>