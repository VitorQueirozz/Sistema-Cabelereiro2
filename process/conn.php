<?php 

    $user = 'root';
    $pass = '';
    $db = 'reguacorte';
    $host = 'localhost';

    $conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);

?>