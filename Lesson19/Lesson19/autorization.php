<?php

define("HOST", "localhost");
define("DATABASE", "classicmodels");
define("CHARSET", "utf8");
define("USER", "root");
define("PASSWORD", "");

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $sql = "SELECT email, SHA1(CONCAT(salt, MD5(?))) as hash, password FROM users WHERE email = ?";
    $params = array($_POST["password"], $_POST["email"]);

    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=" . CHARSET, USER, PASSWORD);

    $result = $pdo->prepare($sql);
    $result->execute($params);
    if ($result->rowCount() > 0) {
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        
        if ($data[0]["hash"] == $data[0]["password"]) {
            echo "Correct";
        } else {
            echo "Wrong password";
        }
    }
} else {
    echo "No data";
}


function log($login, $actionId){
    $ip = $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $sql = "INSERT INTO logs (userId, actionId, ip, userAgent) VALUES ?, ?, ?, ?";

    $params = array($login, $actionId, $ip, $browser);
    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE . ";charset=" . CHARSET, USER, PASSWORD);

    $result = $pdo->prepare($sql);
    $result->execute($params);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="autorization.php" method="post" name="addUser">
        <input type="email" name="email" placeholder="Email">
        <br>
        <input type="password" name="password" placeholder="Password">
        <br>
        <button type="submit">Login</button>
    </form>
</body>

</html>