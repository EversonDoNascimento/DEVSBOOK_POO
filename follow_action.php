<?php
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/RelationDaoMysql.php");
require_once("./dao/UserDaoMysql.php");
require_once("./models/User.php");
$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();

$id = filter_input(INPUT_POST, 'user_to');

if(!empty($id)){
    $userTo = new User();
    $relationDao = new RelationDaoMysql($config->getConn());
    $userDao = new UserDaoMysql($config->getConn());
    $findUser = $userDao->findUserById($id);

    if($findUser){
        $userTo->setId($findUser->getId());
        $userTo->setEmail($findUser->getEmail());
        $relationDao->createRelation($user,$userTo);
    }
}

header("Location: $base/perfil.php?id=".$id);
exit;