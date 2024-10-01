<?php
require_once("./models/User.php");

class Comment {
    private int $id;
    private int $id_post;
    private int $id_user;
    private User $user;
    private string $body;
    private string $created_at;

    public function getId(){
        return $this->id;
    }
    public function setId(int $id){
        $this->id = $id;
    }
    public function getIdPost(){
        return $this->id_post;
    }
    public function setIdPost(int $id){
        $this->id_post = $id;
    }
    public function getIdUser(){
        return $this->id_user;
    }
    public function setIdUser(int $id){
        $this->id_user = $id;
    }
    public function getBody(){
        return $this->body;
    }
    public function setBody(string $body){
        $this->body = $body;
    }
    public function getCreatedAt(){
        return $this->created_at;
    }
    public function setCreatedAt(string $date){
        $this->created_at = $date;
    }
    public function getUser(){
        return $this->user;
    }
    public function setUser(User $user){
        $this->user = $user;
    }
}

interface CommentDAO {
    public function createComment(Comment $comment) : bool;
    public function listCommentsPost(int $id_post) : Array;
    public function deleteAllCommentsPost(int $id_post): bool;

}