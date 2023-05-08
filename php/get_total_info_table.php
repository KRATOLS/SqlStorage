<?php
    $db_config = file_get_contents('settings.json');
    $db_config = json_decode($db_config, true);

    require_once 'classes.php';
    $con = new Connect($db_config);
    $db_connect = $con->setConnect();

    $query = $db_connect->prepare( 
    "SELECT u.user_name, q.name, q.query_string
    FROM public.user u
    JOIN public.query q ON q.user_id = u.id
    ORDER BY u.user_name");
    $query->execute();
    $array = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$query) {
        die ("Ошибка выполнения запроса");
    } else {
        $table = new QueriesTable($array, ['Пользователь', 'Название', 'Текст запроса']);
        echo $table->getTable();
    }
?>