<?php
session_start();

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя обратно на вашу страницу
header("Location: MainWebSite.php");
exit();
?>