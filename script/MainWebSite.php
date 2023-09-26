<?php
require __DIR__ . "/CoordinatesValidator.php";
require __DIR__ . "/AreaChecker.php";

 session_start();
 if (!isset($_SESSION["data"])) {
 $_SESSION["data"] = array();
}

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo 'Incorrect, try again) Only GET method accepted.';
    return;
}


   
    date_default_timezone_set('Europe/Moscow');
    $current_time = date('Y-m-d H:i:s');
    $start_time = microtime(true);
    $x = (float)$_GET["x"];
    $y = (float)$_GET["y"];
    $r = isset($_GET["r"]) ? $_GET["r"] : array();
    $result = array();
    $validator = new CoordinatesValidator($x, $y, $r);
    if ($validator->checkData()){
        
        foreach($r as $currentR){
        
        $isInArea = AreaChecker::isInArea($x, $y, (float)$currentR);
        $coordsStatus = $isInArea
            ? "<span class = 'hit-in'>Попадание</span>"
            : "<span class = 'hit-out'>Нет попадания</span>";
        array_push($result, $coordsStatus);
        $currentTime = date('Y-m-d H:i:s');
        $scriptTime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    
        }

    $_SESSION["data"][] = array("x" => $x, 
    "y" => $y, 
    "r" => $r,
    "result" => $result,
    "currentTime" => $currentTime, 
    "scriptTime" => $scriptTime);    
    $table_html = "<table class=\"table\" border = '1'>
    <tr>
    <th>X</th>
    <th>Y</th>
    <th>R</th>
    <th>Результат</th>
    <th>Время выполнения</th>
    <th>Время скрипта</th>
    </tr>";
    foreach ($_SESSION["data"] as $entry) {
        $i = 0;
        foreach($entry["r"] as $current_r){
            $x =  $entry["x"];
            $y =  $entry["y"];
            $r =  $current_r;
            $result = $entry["result"][$i];
            $currentTime = $entry["currentTime"];
            $scriptTime = $entry["scriptTime"];
            $table_html .= 
            "<tr>
            <th>$x</th>
            <th>$y</th>
            <th>$current_r</th>
            <th>$result</th>
            <th>$currentTime</th>
            <th>$scriptTime</th>
            </tr>";
            $i += 1;
        }
    }
    echo $table_html;
    echo "<button class='glow-on-hover' id='submit' type='button'>Очистить</button>";
}
else {
    http_response_code(422);
    echo 'Invalid data, try again :)';
    return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../client/css/mainWebSite.css">
    <title>Лабораторная 1</title>
</head>
<body>
    
    <script>
        document.getElementById("submit").addEventListener("click", clear);
        function clear(){
            var table = document.querySelector('.table');
            table.innerHTML = '<tr><th>X</th><th>Y</th><th>R</th><th>Результат</th><th>Время выполнение</th><th>Время скрипта</th></tr>';
            fetch('Clear.php') // Создайте файл clear.php для обработки запроса
                .then(response => response.text())
                .then(data => {
                    // Обработка ответа, если необходимо
                    // Например, можно вывести сообщение об успешной очистке
                    alert('Таблица очищена');
                })
                .catch(error => {
                    console.error('Произошла ошибка', error);
                });
        }
        
    </script>

</body>
</html>
