<?php
require_once("./models/Post.php");
require_once("./dao/RelationDaoMysql.php");
require_once("./dao/PostLikeDao.php");
require_once("./dao/CommentDaoMysql.php");
class PostDaoMysql implements PostDAO{
    private PDO $pdo;
    private function _postlike(){
        $likeDao = new PostLikeDaoMysql($this->pdo);
        return $likeDao;
    }
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function createPost(Post $post)
    {
        if($post->getBody() && $post->getIdUser() && $post->getCreated_at() && $post->getType()){
            $created_at = $post->getCreated_at()->format("Y-m-d H:i:s");
            $sql = $this->pdo->prepare("INSERT INTO posts (type, body, created_at, id_user) VALUES(:type, :body, :created_at, :id_user)");
            $sql->bindValue(":type", $post->getType());
            $sql->bindValue(":body",$post->getBody());
            $sql->bindValue(":created_at", $created_at);
            $sql->bindValue(":id_user", $post->getIdUser());
            $sql->execute();
            return $post;
        }
        return null;

    }
    public function findPost(int $id): ?Post
    {
        return null;
    }
    public function findPosts(): ?Post
    {
        return null;
    }
    public function findPostByUserId(int $userId)
    {
        
        if($userId){
            $sql = $this->pdo->prepare("SELECT * FROM posts WHERE id_user = :userId ORDER BY created_at DESC");
            $sql->bindValue(":userId", $userId);
            $sql->execute();
            if($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $post = $this->_postToObject($data, $userId);
                return $post;
            }
        }
        return [];
    }
    public function getHomePosts(User $userId, $profile = false)
    {    
        if($userId->getId()){
            // Retornando a lista de quem eu sigo
            $relationDao = new RelationDaoMysql($this->pdo);
            $iFollowList = [];
            if($profile){
                $iFollowList = [$userId->getId()];
            }else{
                $iFollowList = $relationDao->Ifollow($userId);
            } 
            // Listando posts
            $sql = $this->pdo->query("SELECT * FROM posts WHERE id_user IN (".implode(",",$iFollowList).") ORDER BY created_at DESC");
            if($sql->rowCount() > 0){
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                return $this->_postToObject($data, $userId->getId());
            }

         }          
    }

    public function getPhotosUser(User $userId) {
        if($userId->getId()){
            $sql = $this->pdo->prepare("SELECT * FROM posts WHERE id_user = :id AND type = 'photo'");
            $sql->bindValue(":id", $userId->getId());
            $sql->execute();   
            if($sql->rowCount() > 0){
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                return $this->_postToObject($data, $userId->getId());
            }
        
       }
       return [];
    }

    private function _postToObject($post_list, $id_user){
        $userDao = new UserDaoMysql($this->pdo);
        $posts = [];
        
        foreach($post_list as $p){
            $userTemp = $userDao->findUserById($p["id_user"]);
            $post = new Post();
            $commentDao = new CommentDaoMysql($this->pdo);
            $d = new DateTime($p["created_at"]); 
            $qtdLikePost = $this->_postlike()->getLikes($p['id']);
            $isLike = $this->_postlike()->isLiked($p['id'], $id_user);
            $comments = $commentDao->listCommentsPost($p['id']);
            $post->setId($p["id"]);
            $post->setBody($p["body"]);
            $post->setType($p["type"]);
            $post->setCreated_at($d);
            $post->setIdUser($p["id_user"]);
            $post->setMine(false);
            if($id_user == $post->getIdUser()){
                $post->setMine(true);
            };
            if(!$userTemp ) return null;
            $post->setUser($userTemp);
            $post->setLikeCount($qtdLikePost);
            $post->setLiked($isLike);
            $post->setComments($comments);
            array_push($posts, $post);
        }
        return $posts;
    }

    public function getPhotosPhotosProfile(User $userId){
         if($userId->getId()){
            $sql = $this->pdo->prepare("SELECT * FROM posts WHERE type = 'photo' ");
            if($sql->rowCount() > 0){
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            }
            return [];

         }   
    }
}