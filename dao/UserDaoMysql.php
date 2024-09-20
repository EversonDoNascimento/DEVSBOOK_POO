<?php

require_once("./models/User.php");
class UserDaoMysql implements UserDAO{
    private PDO $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }
    public function findByToken(string $token): User|bool{
        // $findUser = $this->pdo->query("SELECT * FROM users WHERE token = :token");
        $user = new User();
        if(!empty($token)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if($sql->rowCount() > 0){
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user->setId($data['id']);
                $user->setName($data['name']);
                $user->setEmail($data['email']);
                $user->setBirthdate($data['birthdate']);
                $user->setPassword($data['password']);
                $user->setCity($data['city'] ?? "");
                $user->setWork($data['work'] ?? "");
                $user->setAvatar($data['avatar'] ?? "");
                $user->setCover($data['cover'] ?? "");
                $user->setToken($data['token'] ?? "");
                return $user;
            }
        }
        return false;
     
    }

    public function findByEmail(string $email): bool|User{
        $user = new User();
        if(!empty($email)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if($sql->rowCount() > 0){
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user->setId($data['id']);
                $user->setName($data['name']);
                $user->setEmail($data['email']);
                $user->setBirthdate($data['birthdate']);
                $user->setPassword($data['password']);
                $user->setCity($data['city'] ?? "");
                $user->setWork($data['work'] ?? "");
                $user->setAvatar($data['avatar'] ?? "");
                $user->setCover($data['cover'] ?? "");
                $user->setToken($data['token'] ?? "");
                return $user;
            }
        }
        return false;
    }

    public function update(User $user): bool|User{
        if(!empty($user)){
            $sql = $this->pdo->prepare("UPDATE users SET 
                token = :token, 
                email = :email, 
                password = :password,
                name = :name,
                birthdate = :birthdate,
                city = :city,
                work = :work,
                avatar = :avatar,
                cover = :cover  
                WHERE id = :id
            ");
            $sql->bindValue(":token", $user->getToken());
            $sql->bindValue(":email", $user->getEmail());
            $sql->bindValue(":password", $user->getPassword());
            $sql->bindValue(":birthdate", $user->getBirthdate());
            $sql->bindValue(":name", $user->getName());
            $sql->bindValue(":city", $user->getCity());
            $sql->bindValue(":work", $user->getWork());
            $sql->bindValue(":avatar", $user->getAvatar());
            $sql->bindValue(":cover", $user->getCover());
            $sql->bindValue(":id", $user->getId());
            $sql->execute();
            
            return $user;
        }
        return false;
    }
    public function createUser(User $user): bool{
            if ($user->getName() && $user->getEmail() && $user->getPassword() && $user->getBirthdate() && $user->getToken()) {
                $sql = $this->pdo->prepare("INSERT INTO users (name, email, password, birthdate, token) VALUES (:name, :email, :password, :birthdate, :token)");                
                $sql->bindValue(":name", $user->getName());
                $sql->bindValue(":email", $user->getEmail());
                $sql->bindValue(":password", $user->getPassword());
                $sql->bindValue(":birthdate", $user->getBirthdate());
                $sql->bindValue(":token", $user->getToken()); 
                $sql->execute();
                return true;
                } 
            return false;
           
        } 
    public function findUserById(int $id, $full = false)
    {
        if($id){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                $user = new User();
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user->setId($data['id']);
                $user->setName($data['name']);
                $user->setEmail($data['email']);
                $user->setBirthdate($data['birthdate']);
                $user->setPassword($data['password']);
                $user->setCity($data['city'] ?? "");
                $user->setWork($data['work'] ?? "");
                $user->setAvatar($data['avatar'] ?? "");
                $user->setCover($data['cover'] ?? "");
                $user->setToken($data['token'] ?? "");
                if($full){
                    $userRelations = new RelationDaoMysql($this->pdo);
                    //Quem eu sigo
                    $totalFollowing = $userRelations->Ifollow($user);       
                    $user->setFollowing($totalFollowing);
                    //Quem me segue
                    $totalFollowers = $userRelations->getFollowers($user);
                    $user->setFollowers($totalFollowers);
                  
                    //Total de fotos
                    return $user;
                }
                return $user;
            }
            return false;
        }
        return false;
    }

   public function findUserByName(string $name): User|bool|array
   {
    if(trim($name) !== ""){
        $sql = $this->pdo->prepare("SELECT id, name, email, avatar FROM users WHERE name LIKE :name");
        $sql->bindValue(":name", "%{$name}%");
        $sql->execute();
        if($sql->rowCount() > 0){
             
             $data = $sql->fetchAll(PDO::FETCH_ASSOC);
             $users = [];
             foreach ($data as $value) {
                $user = new User();
                $user->setEmail($value['email']);
                $user->setId($value['id']);
                $user->setName($value['name']);
                $user->setAvatar($value['avatar']);
                array_push($users, $user);
             }
          
             return $users;
        }
    }
    return false;
   }
}