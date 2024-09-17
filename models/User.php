<?php

class User {
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string|null $birthdate;
    private string|null $city;
    private string|null $work;
    private string|null $avatar;
    private string|null $cover;
    private string|null $token;
    private  $followers;
    private  $following;

    public function getId(){
        return $this->id;
    }
    public function setId(int $id){
        $this->id = $id;
    }
    // Getter and Setter for $name
    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    // Getter and Setter for $email
    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    // Getter and Setter for $password
    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    // Getter and Setter for $birthdate
    public function getBirthdate(): string {
        return $this->birthdate;
    }

    public function setBirthdate(string $birthdate): void {
        $this->birthdate = $birthdate;
    }

    // Getter and Setter for $city
    public function getCity(): string {
        return $this->city;
    }

    public function setCity(string $city): void {
        $this->city = $city;
    }

    // Getter and Setter for $work
    public function getWork(): string {
        return $this->work;
    }

    public function setWork(string $work): void {
        $this->work = $work;
    }

    // Getter and Setter for $avatar
    public function getAvatar(): string {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void {
        $this->avatar = $avatar;
    }

    // Getter and Setter for $cover
    public function getCover(): string {
        return $this->cover;
    }

    public function setCover(string $cover): void {
        $this->cover = $cover;
    }

    // Getter and Setter for $token
    public function getToken(): string {
        return $this->token;
    }

    public function setToken(string $token): void {
        $this->token = $token;
    }
    public function setFollowers($followers): void{
        $this->followers = $followers;
    }
    public function getFollowers(){
        return $this->followers;
    }   
    public function setFollowing($following): void {
        $this->following = $following;
    }
    public function getFollowing(){
        return $this->following;
    }
    
}

 interface UserDAO {
//     public function createUser(User $user);
    public function findByToken(string $token): User|bool;
    public function findByEmail(string $email): User|bool;
    public function findUserById(int $id);
    public function createUser(User $user): bool;
    public function update(User $user): User|bool;
    public function findUserByName(string $name) : User|bool|array;
    // public function deleteUser(int $id);
    // public function editUser(User $user);
    // public function getUser(User $user);
}