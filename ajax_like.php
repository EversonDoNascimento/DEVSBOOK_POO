<?php
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/PostLikeDao.php");
$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();

$id_post = filter_input(INPUT_GET, "id");

if(!empty($id_post)){
    $likeDao = new PostLikeDaoMysql($config->getConn());
    $likeDao->likeToggle($id_post, $user->getId());
}
