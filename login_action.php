<?php
require("./config.php");
require("./models/Auth.php");
$email = filter_input(INPUT_POST, "email",FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
$pass = filter_input(INPUT_POST, "password");

if($email && $pass){
    $config = new Config();
    $auth = new Auth($config->getConn(), $base);

    if($auth->validateLogin($email, $pass)){
        header("Location: $base");
        exit;
    }
}
header("Location: $base/login.php");
exit;