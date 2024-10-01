<?php

require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/PostDaoMysql.php");
$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();

$id = filter_input(INPUT_GET, "id");

if(!empty($id)){
    $postDao = new PostDaoMysql($config->getConn());
    $postDao->deletePost($id, $user->getId());

}

// header("Location: $base");
// exit;

?>
<script>
    window.history.back();
</script>

