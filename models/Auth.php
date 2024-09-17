<?php
require_once("./dao/UserDaoMysql.php");
class Auth{
    private $pdo;
    private $base;
    private $userDao;
    public function __construct(PDO $pdo, $base) {
        $this->base = $base;
        $this->pdo = $pdo;
        $this->userDao = new UserDaoMysql($this->pdo);
    }

    public function checkToken(){
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];
            //$userDao = new UserDaoMysql($this->pdo);
            $user = $this->userDao->findByToken($token);
            if($user){
                return $user;
            }       
            
        }
        header("Location: ".$this->base."/login.php");
        exit;
    }

    public function validateLogin(string $email, string $pass): bool{
        $user = $this->userDao->findByEmail($email);
        if($user){
          
            if(hash("sha256", $pass) === $user->getPassword()){                
                $token = md5(time().rand(0, 9999));
                $_SESSION['token'] = $token;
                $user->setToken($token);
                $this->userDao->update($user);    
                return true;
            }
            $_SESSION['error'] = "Email e/ou senha incorretos!";
            return false;
        }
        $_SESSION['error'] = "Erro usuário não encontrado!";
        return false;
    }

    public function getBase(){
        return $this->base;
    }

    public function userExist(String $email): bool {
        $user = $this->userDao->findByEmail($email);
        if($user){
            return true;
        }
        return false;
    }

    public function registerUser (User $user): bool {
        $hash = hash("sha256",$user->getPassword());
        $token = md5(time().rand(0, 9999));
        $user->setPassword($hash);
        $user->setToken($token);
        if($user->getName() && $user->getEmail() && $user->getBirthdate() && $user->getPassword()){
            // Converter a data de nascimento para o formato YYYY-MM-DD
            $birthdate = DateTime::createFromFormat('d/m/Y', $user->getBirthdate());
            if ($birthdate === false) {
                // Data inválida
                return false;
            }
            $formattedBirthdate = $birthdate->format('Y-m-d');
            $user->setBirthdate($formattedBirthdate);
            $result = $this->userDao->createUser($user);
            if($result){
                $_SESSION['token'] = $token;
                return true;
                }         
        }
    return false;
    }

}