<?php

class UserRelation {
  private int $id;
  private int $user_from;
  private int $user_to;

  public function getId(){
    return $this->id;
  }

  public function setId(int $id){
    $this->id - $id;
  }

  public function getUserFrom(){
    return $this->user_from;
  }

  public function setUserFrom(int $user_from){
    $this->user_from = $user_from;
  }
  public function getUserTo(){
    return $this->user_to;
  }
  public function setUserTo(int $user_to){
    $this->user_to = $user_to;
  }

}

interface UserRelationDAO {
    public function createRelation(User $id_user_from, User $id_user_to): bool;
    public function findRelations();
    public function findRelation(User $id_user_from, User $id_user_to): bool;
    public function Ifollow(User $id_user);
}

