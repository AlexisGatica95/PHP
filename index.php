<?php
    require './layouts/session_start.php'
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de inventario</title>
    <link rel="stylesheet" href="./css/bulma.min.css">
    <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>
    <?php
        if (!isset($_GET['vista']) || $_GET['vista']=="") {
            $_GET['vista']='login';
        }

        if (is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista']!== "login" && $_GET['vista']!='404') {
            // protejo que alguien que no este logueado quiera entrar a mi home
            if(!(isset($_SESSION['id']))||$_SESSION['id']==""||!(isset($_SESSION['usuario']) || $_SESSION['usuario']=="")){
                include "./vistas/logout.php";
                exit();
            }
            

            include './layouts/navbar.php';
            include './vistas/'.$_GET["vista"].'.php';
        } else {
            if ($_GET['vista']== "login") {
                include './layouts/navbar.php';
                include './vistas/login.php';
            } else {
                include './layouts/navbar.php';
                include './vistas/404.php';
            }
            
        }
        

        
        
    ?>
    <script src="./js/ajax.js"></script>
</body>
</html>