<?php

require_once("./config.php");
require_once("./dao/UserDaoMysql.php");
require_once("./models/User.php");
require_once("./models/Auth.php");
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$pass = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
$birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_SPECIAL_CHARS);

if($name && $email && $pass && $birthdate){
    $config = new Config();
    $userDao = new UserDaoMysql($config->getConn());
    $auth = new Auth($config->getConn(), $base);
    $birthdate_array = explode("/", $birthdate);
    if(count($birthdate_array) != 3){
        $_SESSION['error'] = "Data de aniversário inválida!";
        header("Location: $base/signup.php");
        exit;
    }
    $birthdate_array = $birthdate_array[2]."-".$birthdate_array[1]."-".$birthdate_array[0];
    if(strtotime($birthdate_array) === false){
        $_SESSION['error'] = "Data de aniversário inválida!";
        header("Location: $base/signup.php");
        exit;
    }

    $verify_email = $auth->userExist($email);
    if($verify_email){
        $_SESSION['error'] = "Email já possui um cadastro!";
        header("Location: $base/signup.php");
        exit;
    }
    $user = new User();
    $user->setEmail($email);
    $user->setName($name);
    $user->setPassword($pass);
    $user->setBirthdate($birthdate);
    $user->setAvatar("default");
    // echo "<pre>";
    // print_r($user);
    // echo "</pre>";
    $register = $auth->registerUser($user);

    if($register){
        // $_SESSION['success'] = "Cadastro realizado com sucesso!";
        header("Location: $base/");
        exit;           
    }
    echo $register;


    // $createUser = $userDao->createUser($user);
    // if($createUser){
    //     $_SESSION['success'] = "Cadastro realizado com sucesso!";
    //     header("Location: $base/login.php");
    //     exit;
    // }
    // $_SESSION['error'] = "Erro ao cadastrar usuário!";
    // header("Location: $base/signup.php");
    // exit;
    return null;
}

$_SESSION['error'] = "Preencha todas as informações";
header("Location: $base/signup.php");
exit;

