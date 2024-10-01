<?php

class PostLike {
    private int $id;
    private int $id_post;
    private int $id_user;
    private string $created_at;

    public function getId(){
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getUserId(){
        return $this->id_user;
    }

    public function setUserId(int $userId){
        $this->id_user = $userId; 
    }

    public function getPostId(){
        return $this->id_post;
    }

    public function setPostId(int $postId){
        $this->id_post = $postId;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

    public function setCreatedAt(string $created){
        $this->created_at = $created;
    }

}

interface PostLikeDAO {
    public function getLikes($id_post): int;
    public function isLiked($id_post, $id_user): bool;
    public function likeToggle($id_post, $id_user);
    public function deleteAllLikesPost($id_post): bool;
}