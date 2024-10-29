<?php
define('HOST_NAME', 'localhost');
define('USER_NAME', 'root');
define('PASSWORD', '');
define('DB_NAME', 'expense_tracker');

$connection = mysqli_connect(HOST_NAME, USER_NAME, PASSWORD, DB_NAME);

session_start();

$host = 'localhost';
$db = 'expense_tracker';
$user = 'root'; // sesuaikan dengan username MySQL Anda
$pass = ''; // sesuaikan dengan password MySQL Anda


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}
?>