<?php
require_once("./models/PostLike.php");
require_once("./dao/UserDaoMysql.php");
class PostLikeDaoMysql implements PostLikeDAO{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function getLikes($id_post): int{
        $sql = $this->pdo->prepare("SELECT COUNT(*) as c FROM postslikes WHERE id_post = :id_post");
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        return $data['c'];
    }
    public function isLiked($id_post, $id_user): bool{
        $sql = $this->pdo->prepare("SELECT * FROM postslikes WHERE id_post = :id_post AND id_user = :id_user");
        $sql->bindValue(":id_user", $id_user);
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();
        if($sql->rowCount() > 0){
            return true;
        }
   
        return false;
    }
    public function likeToggle($id_post, $id_user) {
       
            if($this->isLiked($id_post, $id_user)){
              $sql = $this->pdo->prepare("DELETE FROM postslikes WHERE id_post = :id_post AND id_user = :id_user");  
            }else{
              $sql = $this->pdo->prepare("INSERT INTO postslikes(id_post, id_user, created_at) VALUES (:id_post, :id_user, NOW())");
            }
            $sql->bindValue(":id_user", $id_user);
            $sql->bindValue(":id_post", $id_post);
            $sql->execute();
    }
} 