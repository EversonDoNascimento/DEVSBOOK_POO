<?php
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/RelationDaoMysql.php");

$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();
$activeMenu = "Home";
require_once("./partials/header.php");
$activeMenu = "Search";
$search = filter_input(INPUT_GET, "s");
$result = [];
if($search){
    $userDao = new UserDaoMysql($config->getConn());
    $usersResult = $userDao->findUserByName(strtolower($search));
    if($user){
        $result = $usersResult;

    }
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/style.css" />
</head>
<body>
   
    <section class="container main">
       <?php require_once("./partials/menu.php")?>
        <section class="feed mt-10">
            
            <div class="row">
                <div class="column pr-5">
                <?php if($result && count($result) > 0):?>   
                    <?php foreach($result as $Key => $value): ?>
                        <?php require("./partials/card-search.php")?>
                    <?php endforeach?>
                <?php endif?>
                <?php if(!$result || count($result) < 0):?>   
                    <div style="text-align: center; font-weight: bold; font-size: 14px; color:'#4A76A8'; margin-top: 15px;">Nenhuma informação encontrada!</div>
                <?php endif?>
                </div>
                <div class="column side pl-5">
                    <div class="box banners">
                        <div class="box-header">
                            <div class="box-header-text">Patrocinios</div>
                            <div class="box-header-buttons">
                                
                            </div>
                        </div>
                        <div class="box-body">
                            <a href=""><img src="https://alunos.b7web.com.br/media/courses/php-nivel-1.jpg" /></a>
                            <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel-nivel-1.jpg" /></a>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body m-10">
                            Criado com ❤️ por B7Web
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
    <?php require_once("./partials/footer.php")?>

    <script>
        const form = document.querySelectorAll(".search-card-container");
        console.log(form);
        form.forEach((item)=>{
            item.addEventListener("click", () => {
                  item.submit();
            })
          

        })

    </script>
</body>
</html>
