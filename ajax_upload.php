<?php
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/PostDaoMysql.php");
require_once("./models/Post.php");
require_once("./models/Comment.php");
$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();

$array = ['error' => ''];
$postDao = new PostDaoMysql($config->getConn());
$maxWidth = 800;
$maxHeight = 800;
if(isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
    $photo = $_FILES['photo'];

    if(in_array($photo['type'], ['image/png','image/jpeg','image/jpg'])){

        list($widthOrigin, $heightOrigin) = getimagesize($photo['tmp_name']);
        $ratio = $widthOrigin / $heightOrigin;

        $newWidth = $maxWidth;
        $newHeight = $maxHeight;
        $ratioMax = $maxWidth / $newHeight;
        if($ratioMax < $ratio){
            $newWidth = $newHeight * $ratio;
        }else{
            $newHeight = $newWidth / $ratio;
        }

        $finalImage = imagecreatetruecolor($newWidth, $newHeight);
        switch($photo['type']){
            case "image/jpeg":
            case "image/jpg":
                $image = imagecreatefromjpeg($photo['tmp_name']);
            case "image/png":
                $image =  imagecreatefrompng($photo['tmp_name']);
        }

        imagecopyresampled(
            $finalImage,
            $image,
            0,0,0,0,
            $newWidth, $newHeight, $widthOrigin, $heightOrigin
        );

        $photoName = md5(time().rand(0,9999).".jpg");
        imagejpeg($finalImage, 'media/uploads/'.$photoName);
        $post = new Post;

        $post->setIdUser($user->getId());
        $post->setType("photo");
        $post->setBody($photoName);
        $date = new DateTime;
        $post->setCreated_at($date);

        $postDao->createPost($post);

    }else{
        $array['error'] = ['Imagem não suportada'];
    }

}else{
    $array['error'] = ["Nenhuma imagem enviada!"];
}

header("Content-Type: application/json");
echo json_encode($array);
exit;