<?php

class Post {
    private int|null $id;
    private string|null $type;
    private string|null $body;
    private DateTime|null $created_at;
    private int|null $id_user;
    private bool|null $mine;
    private User|null $user;
    private int|null $likeCount;
    private bool|null $liked;
    private array|null $comments;
    public function getId(){
        return $this->id;
    }
    public function setId(int $id){
        $this->id = $id;
    }
    public function getType(){
        return $this->type;
    }
    public function setType(string $type){
        $this->type = $type;
    }
    public function getBody(){
        return $this->body;
    }
    public function setBody(string $body){
        $this->body = $body;
    }
    public function getCreated_at(){
        return $this->created_at;
    }
    public function setCreated_at(DateTime $date){
        $this->created_at = $date;
    }
    public function getIdUser(){
        return $this->id_user;
    }
    public function setIdUser(int $user_id){
        $this->id_user = $user_id;
    }
    public function setMine(bool $value){
        $this->mine = $value;
    }
    public function getMine(){
        return $this->mine;
    }
    public function getUser(){
        return $this->user;
    }
    public function setUser(User $user){
        $this->user = $user;
    }
    public function setLikeCount(int $qtdLike){
        $this->likeCount = $qtdLike;
    }
    public function getLikeCount(){
        return $this->likeCount;
    }
    public function setLiked(bool $liked){
        $this->liked = $liked;
    }
    public function getLiked(){
        return $this->liked;
    }
    public function setComments($comment){
        $this->comments = $comment;
    }
    public function getComments(){
        return $this->comments;
    }

}


interface PostDAO {
    public function createPost(Post $post);
    public function findPost(int $id): Post|null;
    public function findPostByUserId(int $userId);
    public function getHomePosts(User $userId);
    public function findPosts(): Post|null;
    public function deletePost(int $postId, int $userId): bool;
}

