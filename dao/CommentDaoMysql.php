<?php

require_once("./models/Comment.php");
require_once("./models/User.php");
require_once("./dao/UserDaoMysql.php");

class CommentDaoMysql implements CommentDAO {
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function createComment(Comment $comment) : bool{
        if($comment){
            $sql = $this->pdo->prepare("INSERT INTO postscomments(id_post, id_user, created_at, body) VALUES(:id_post, :id_user, NOW(), :body)");
            $sql->bindValue(":id_post", $comment->getIdPost());
            $sql->bindValue(":id_user", $comment->getIdUser());
            $sql->bindValue(":body", $comment->getBody());
            $sql->execute();
            return true;
        }
        return false;
    }
    public function listCommentsPost(int $id_post) : Array{
        $listComments = [];
        $userDao = new UserDaoMysql($this->pdo);
        if(!empty($id_post)){
            $sql = $this->pdo->prepare("SELECT * FROM postscomments WHERE id_post = :id_post");
            $sql->bindValue(":id_post", $id_post);
            $sql->execute();
            if($sql->rowCount() > 0){
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
             
                
                foreach($data as $c){  
                    $user = new User();
                    $comment = new Comment();                 
                    $findUser = $userDao->findUserById($c['id_user']);
                    if($findUser){
                        $user->setId($findUser->getId());
                        $user->setAvatar($findUser->getAvatar());
                        $user->setName($findUser->getName());
                        $comment->setUser($user);
                    }
                    $comment->setId($c['id']);
                    $comment->setIdPost($c['id_post']);
                    $comment->setIdUser($c['id_user']);
                    $comment->setBody($c['body']);
                    $comment->setCreatedAt($c['created_at']);
                    array_push($listComments, $comment);
                }
            }
        }
        // print_r($listComments);
        return $listComments;
    }
}