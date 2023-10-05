<?php

            
    $usuario=limpiar_cadena($_POST['login_usuario']);
    $clave=limpiar_cadena($_POST['login_clave']); 

        if($usuario==""||$clave==""){
        echo '<div class="notification is-danger is-light">
        <strong>por favor complete todos los datos para continuar</strong>
        </div>';
        exit();
     }

    //  verificar la integridad de datos
    if(verificar_datos("[a-zA-Z0-9]{4-20}",$usuario)){
        echo '<div class="notification is-danger is-light">
        <strong>el usuario no coincide con el formato solicitado</strong>
        </div>';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9$@.-]{7-100}",$clave)){
        echo '<div class="notification is-danger is-light">
        <strong>el clave no coincide con el formato solicitado</strong>
        </div>';
        exit();
    }

    $check_user = conexion();
    $check_user = $check_user->query("SELECT * FROM usuario WHERE usuario_usr='$usuario'");

    if($check_user->rowCount()==1){
        //escribo para hacer la consulta, para hacer un array de datos de la base de datos 

        $check_user=$check_user->fetch();
  

        // //compuevo si un texto coincide con una clave procesada con passwordhash
        if ($check_user['usuario_usr']==$usuario){
            // && password_verify(,$usuario,$check_user['usuario_clave'])
            
            $_SESSION["id"]=$check_user["usuario_id"];
            $_SESSION["nombre"]=$check_user["usuario_nombre"];
            $_SESSION["apellido"]=$check_user["usuario_apellido"];
            $_SESSION["usuario"]=$check_user["usuario_usr"];
            // primero me fijo si envie encabezados
          
            if (headers_sent()) {
                echo "<script>window.location.href='index.php?vista=home'</script>";
            } else {
                header('Location:http://localhost/inventario/index.php?vista=home');
        
            }
        }else{
            echo '<div class="notification is-danger is-light">
            <strong>el usuario o la clave son incorrectos</strong>
            </div>';
        exit();
        }
    }else{
        echo '<div class="notification is-danger is-light">
        <strong>el usuario o clave son incorrectos</strong>
        </div>';
    }

    $check_user=null;
?>