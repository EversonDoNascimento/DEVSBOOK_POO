<?php
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/PostDaoMysql.php");
require_once("./models/Post.php");
$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();

$body = filter_input(INPUT_POST, "body");
if($body){
    $PostDao = new PostDaoMysql($config->getConn());
    $post = new Post();
    $date = new DateTime;
  
    $post->setBody($body);
    $post->setType("text");
    $post->setCreated_at($date);
    $post->setIdUser($user->getId());
    // print_r($post);
    $result = $PostDao->createPost($post);
    if($result){
        $_SESSION['success'] = "Post criado com Sucesso!";
        //echo "Post criado com sucesso!";
    }else{
        $_SESSION['error'] = "Erro ao criar Post!";
        //echo "Erro ao criar Post!";

    }
   
 
}

header("Location: $base");
exit;