<?php
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/CommentDaoMysql.php");
require_once("./models/Comment.php");
$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS);
$body = filter_input(INPUT_GET, "body", FILTER_SANITIZE_SPECIAL_CHARS);

if(!empty($id) && !empty($body)){
    $comment = new Comment();
    $comment->setIdPost($id);
    $comment->setIdUser($user->getId());
    $comment->setBody($body);
    $commentDao = new CommentDaoMysql($config->getConn());
    $commentDao->createComment($comment);
}

