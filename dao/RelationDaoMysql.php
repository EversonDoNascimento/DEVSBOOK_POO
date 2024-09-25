<?php
require("./models/User-relation.php");

class RelationDaoMysql implements UserRelationDAO{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function createRelation(User $id_user_from, User $id_user_to): bool
    {
        $userDao = new UserDaoMysql($this->pdo);
        $find_user_from = $userDao->findByEmail($id_user_from->getEmail());
        $find_user_to = $userDao->findByEmail($id_user_to->getEmail());
        if(!$find_user_to && !$find_user_from) return false;
        $findRelation = $this->findRelation($id_user_from, $id_user_to);
        if($findRelation){
            $sql = $this->pdo->prepare("DELETE FROM userrelations WHERE user_from = :user_from AND user_to = :user_to");
            $sql->bindValue(":user_from", $id_user_from->getId());
            $sql->bindValue(":user_to", $id_user_to->getId());
            $sql->execute();
            return true;
        } 
        if($id_user_from->getId() && $id_user_to->getId()){
            $sql = $this->pdo->prepare("INSERT INTO userrelations (user_from, user_to) VALUES(:user_from, :user_to)");
            $sql->bindValue(":user_from", $id_user_from->getId());
            $sql->bindValue(":user_to", $id_user_to->getId());
            $sql->execute();
            return true;

        }
        return false;
    }

    public function findRelations() 
    {

        $sql = $this->pdo->prepare("SELECT * FROM userrelations");
        $sql->execute();
        $list = [];
        if($sql->rowCount() > 0){
            $relations = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach($relations as $r){
                array_push($list, $r["user_from"]);
            }
            
        }
        return $list; 
    }

    public function findRelation(User $id_user_from, User $id_user_to): bool
    {
      
        if($id_user_from->getId() && $id_user_to->getId()){
            $sql = $this->pdo->prepare("SELECT * FROM userrelations WHERE user_from = :id_user_from AND user_to = :id_user_to");
            $sql->bindValue(":id_user_from", $id_user_from->getId());
            $sql->bindValue(":id_user_to", $id_user_to->getId());
            $sql->execute();
            if($sql->rowCount() > 0){
                return true;
            }
        }
        return false;
    }
    public function Ifollow(User $id_user)
    {
        $userDao = new UserDaoMysql($this->pdo);
        $find_user_from = $userDao->findByEmail($id_user->getEmail());
        if(!$find_user_from) return false;
        $list = [];
        if($id_user->getId()){
            $sql = $this->pdo->prepare("SELECT * FROM userrelations WHERE user_from = :id_user");
            $sql->bindValue(":id_user",$id_user->getId());
            $sql->execute();
            if($sql->rowCount() > 0){
                $temp = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($temp as $t){
                    array_push($list, $t['user_to']);
                }
            }
            return $list;
        }
        return false;
    }
    public function getFollowers(User $id_user){
        $userDao = new UserDaoMysql($this->pdo);
        $find_user_from = $userDao->findByEmail($id_user->getEmail());
        if(!$find_user_from) return false;
          $list = [];
        if($id_user->getId()){
            $sql = $this->pdo->prepare("SELECT * FROM userrelations WHERE user_to = :id_user");
            $sql->bindValue(":id_user",$id_user->getId());
            $sql->execute();
            if($sql->rowCount() > 0){
                $temp = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($temp as $t){
                    array_push($list, $t['user_to']);
                }
            }
            return $list;
        }
        return false;
    }



}