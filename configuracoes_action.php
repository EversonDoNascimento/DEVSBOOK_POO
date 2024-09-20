<?php
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/RelationDaoMysql.php");

$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();

$full_name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$city = filter_input(INPUT_POST, 'city');
$work = filter_input(INPUT_POST, 'work');
$birthdate = filter_input(INPUT_POST, 'birthdate');
$password = filter_input(INPUT_POST, 'password');
$confirm_pass = filter_input(INPUT_POST, 'confirm_pass');
if($full_name && $email){
    $userDao = new UserDaoMysql($config->getConn());
    $user->setName($full_name);
    $user->setCity($city);
    $user->setWork($work);
    // Fazendo a verificação se o email mudou
    if(strtolower(trim($email)) !== strtolower(trim($user->getEmail()))){
        $verifyEmail = $userDao->findByEmail($email);
        echo var_dump($verifyEmail);
        if(!$verifyEmail){
            echo "email não existe";
            $user->setEmail($email);
        }else{
            $_SESSION['error'] = "Email já existe!";
            header("Location: $base/configuracoes.php");
            exit;
        }
    }
    $birthdate_array = explode("/", $birthdate);
    if(count($birthdate_array) != 3){
        $_SESSION['error'] = "Data de aniversário inválida!";
        header("Location: $base/configuracoes.php");
        exit;
    }
    $birthdate_array = $birthdate_array[2]."-".$birthdate_array[1]."-".$birthdate_array[0];
    if(strtotime($birthdate_array) === false || strlen($birthdate_array) <= 9){
        $_SESSION['error'] = "Data de aniversário inválida!";
        header("Location: $base/configuracoes.php");
        exit;
    }
    $user->setBirthdate($birthdate_array);

    if(!empty($password)){
        if($password === $confirm_pass){
            $hash = hash("sha256",$password);
            $user->setPassword($hash);
        }
        else{
            $_SESSION['error'] = "Senhas não correspondem!";
            header("Location: $base/configuracoes.php");
            exit;
        }
    }
  
    //Avatar

    if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])){
        $newAvatar = $_FILES['avatar'];
        if(in_array($newAvatar['type'], ["image/png", "image/jpg", "image/jpeg"])){
            $avatarWidth = 200;
            $avatarHeight = 200;
            list($widthOrig, $heightOrig) = getimagesize($newAvatar['tmp_name']);
            $ratio = $widthOrig / $heightOrig;
            $newWidth = $avatarWidth;
            $newHeight = $newWidth / $ratio;

            if($newHeight < $avatarHeight){
                $newHeight = $avatarHeight;
                $newWidth = $newHeight * $ratio;
            }
            $x = $avatarWidth - $newWidth;
            $y  = $avatarHeight - $newHeight;
            $x = $x < 0 ? $x / 2 : $x;
            $y = $y < 0 ? $y / 2 : $y;
            
            $finalImage = imagecreatetruecolor($avatarWidth, $avatarHeight);
            switch($newAvatar['type']){
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($newAvatar['tmp_name']);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($newAvatar['tmp_name']);
                    break;
            }
            imagecopyresampled(
                $finalImage, $image,
                $x, $y, 0, 0,
                $newWidth, $newHeight, $widthOrig, $heightOrig
            );
            $avatarName = md5(time().rand(0,9999)).".jpg";
            imagejpeg($finalImage, "./media/avatars/$avatarName", 100);
            $user->setAvatar($avatarName);
    
        };
    }


    //Capa

    if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])){
        $newCover = $_FILES['cover'];
        if(in_array($newCover['type'], ["image/png", "image/jpg", "image/jpeg"])){
            $coverWidth = 800;
            $coverHeight = 313;
            list($widthOrig, $heightOrig) = getimagesize($newCover['tmp_name']);
            $ratio = $widthOrig / $heightOrig;
            $newWidth = $coverWidth;
            $newHeight = $newWidth / $ratio;

            if($newHeight < $coverHeight){
                $newHeight = $coverHeight;
                $newWidth = $newHeight * $ratio;
            }
            $x = $coverWidth - $newWidth;
            $y  = $coverHeight - $newHeight;
            $x = $x < 0 ? $x / 2 : $x;
            $y = $y < 0 ? $y / 2 : $y;
            
            $finalImage = imagecreatetruecolor($coverWidth, $coverHeight);
            switch($newCover['type']){
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($newCover['tmp_name']);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($newCover['tmp_name']);
                    break;
            }
            imagecopyresampled(
                $finalImage, $image,
                $x, $y, 0, 0,
                $newWidth, $newHeight, $widthOrig, $heightOrig
            );
            $coverName = md5(time().rand(0,9999)).".jpg";
            imagejpeg($finalImage, "./media/covers/$coverName", 100);
            $user->setCover($coverName);
    
        };
    }
 
    $updated = $userDao->update($user);
    if(!$updated){
        $_SESSION['error'] = "Erro ao atualizar dados!";
        header("Location: $base/configuracoes.php");
        exit;
    } 
}

header("Location: $base/configuracoes.php");
exit;