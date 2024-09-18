<?php
require_once("./config.php");
require_once("./models/Auth.php");
require_once("./dao/RelationDaoMysql.php");

$config = new Config();
$auth = new Auth($config->getConn(), $base);
$user = $auth->checkToken();
$activeMenu = "Config";
require_once("./partials/header.php");


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base?>/assets/css/style.css" />
</head>
<body>
  <style>
    .config-form {
        margin-top: 10px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        
    }

    .config-form label {
        display: flex;
        flex-direction: column;
        padding: 10px 0;
        width: 80%;
        font-size: 0.9rem;
        font-weight: bold;
        gap: 2px;
    }
    .config-form label input {
        border-radius: 10px;
        border: 1px solid #4A76A8 ;
        padding: 5px;
  
    }

    .config-form button {
        background-color: #4A76A8;
        color: white;
        border-radius: 10px;
        padding: 2px 10px;
        border: none;
        font-size: 1rem;
        margin-top: 15px;
    }
    .config-form button:hover {
        transition: all;
        transition-duration: .2s;
        scale: 105%;
        cursor: pointer;
    }
    .input-file {
        opacity: 0;
    }
    .style-input-file {
        position: absolute;
        width: 100%;
        text-align: center;
        border-radius: 10px;
        border: 1px solid #4A76A8;
        padding: 5px;
        z-index: 2;
    }
    .style-input-file:hover {
        background-color: #4A76A8;
        scale: 102%;
        cursor: pointer;
        transition: all;
        transition-duration: 0.5s;
        color: white;
    }
    .line {
        width: 80%;
        border: 0.5px solid #D1D9E0;
        margin: 20px 0;
        
    }
  </style>
    <section class="container main">
       <?php require_once("./partials/menu.php")?>
        <section class="feed mt-10">
            <h1>Configurações</h1>
            <form  method="POST" enctype="multipart/form-data" class="config-form" action="<?=$base?>/configuracoes_action.php">
                <label >
                    Novo Avatar:
                    <div style="position: relative; width: 100%">
                         <span class="style-input-file">Clique aqui para selecionar o foto do perfil</span>
                         <input class="input-file" type="file" name="avatar"/>
                    </div>
       
                </label>
                <label>
                    Nova Capa:
                    <div style="position: relative; width: 100%">
                        <span class="style-input-file">Clique aqui para selecionar o foto de capa</span>
                        <input class="input-file"   type="file" name="cover"/>
                    </div>
                </label>
                <div class="line"></div>
                <label>
                    Nome Completo:
                    <input type="text" name="name" placeholder="Nome">
                </label>
                <label >
                    Email:
                    <input type="email" name="email" placeholder="Email">
                </label>
                <label >
                    Cidade:
                    <input type="text" name="city" placeholder="Cidade">
                </label>
                <label >
                    Trabalho:
                    <input type="text" name="work" placeholder="Trabalho">
                </label>
                <label >
                    Data de Aniversário:
                    <input type="text" name="birthdate" placeholder="Data de aniversário">
                </label>
                <div class="line"></div>
                <label >
                    Senha:
                    <input type="password" name="password" placeholder="Senha" >
                </label>
                <label>
                    Confirmar Senha:
                    <input type="password" name="confirm_pass" placeholder="Confirmar senha">
                </label>
                <button  class="button">Salvar</button>
            </form>         

        </section>
    </section>
    <?php require_once("./partials/footer.php")?>
</body>
</html>
