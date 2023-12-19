<?php

define("HOST", "localhost");
define("DATABASE", "classicmodels");
define("CHARSET", "utf8");
define("USER", "root");
define("PASSWORD", "");

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $salt = randString(40);

    $sql = "INSERT INTO users (salt, email, password, customerId) VALUES (?, ?, ?, ?);";
    $params = array($salt, $_POST["email"], $_POST["password"], $_POST["customerId"]);

    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=" . CHARSET, USER, PASSWORD);

    $result = $pdo->prepare($sql);
    $result->execute($params);

    $userId = $pdo->lastInsertId();
} else {
    include("addUser.html");
}

//echo md5(randString(40));

function randString($length = 32)
{
    $character = "0123456789abcdef";
    $randString = "";
    for ($i = 0; $i < $length; $i++) {
        $randString .= $character[random_int(0, strlen($character) - 1)];
    }
    return $randString;
}