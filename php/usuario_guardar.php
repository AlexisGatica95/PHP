<?php
    require_once "main.php";
    // almacenando datos
    $nombre=limpiar_cadena($_POST['registro_nombre']);
    $apellido=limpiar_cadena($_POST['registro_apellido']);
    $usuario=limpiar_cadena($_POST['registro_usuario']);
    $email=limpiar_cadena($_POST['registro_email']);
    $clave=limpiar_cadena($_POST['registro_clave']);
    $clave_rep=limpiar_cadena($_POST['registro_clave_rep']);

    if($nombre==""||$apellido==""||$usuario==""||$clave==""||$clave_rep==""){
        echo '<div class="notification is-danger is-light">
        <strong>por favor complete todos los datos para continuar</strong>
        </div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9 ]{4-20}",$nombre)){
        echo '<div class="notification is-danger is-light">
        <strong>el nombre no coincide con el formato solicitado</strong>
        </div>';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9 ]{4-20}",$apellido)){
        echo '<div class="notification is-danger is-light">
        <strong>el apellido no coincide con el formato solicitado</strong>
        </div>';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9 ]{4-20}",$usuario)){
        echo '<div class="notification is-danger is-light">
        <strong>el usuario no coincide con el formato solicitado</strong>
        </div>';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9$@.-]{7-100}",$email)){
        echo '<div class="notification is-danger is-light">
        <strong>el email no coincide con el formato solicitado</strong>
        </div>';
        exit();
    }
    if(verificar_datos("[a-zA-Z0-9$@.-]{7-100}",$clave||"[a-zA-Z0-9$@.-]{7-100}",$clave_rep)){
        echo '<div class="notification is-danger is-light">
        <strong>el clave no coincide con el formato solicitado</strong>
        </div>';
        exit();
    }
    
    // verifico si el mail ya existe

    if($email!=""){
        // echo 'el email es vlaido';
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email= $check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
            if($check_email->rowCount()>0){
                echo '<div class="notification is-danger is-light">
                <strong>El email ya esta registrado</strong>
                </div>';
                exit();
            }
            //libero espacio en memoria 
            $check_email=null;
        }else{
            echo '<div class="notification is-danger is-light">
            <strong>ocurrio un error inesperado</strong>
            </div>';
            exit();
        }
    };

    // verifico el usuario
    $check_usuario=conexion();
    $check_usuario= $check_usuario->query("SELECT usuario_usr FROM usuario WHERE usuario_usr='$usuario'");
    if($check_usuario->rowCount()>0){
        echo '<div class="notification is-danger is-light">
        <strong>El nombre de usuario ya esta registrado</strong>
        </div>';
        exit();
    }
    //libero espacio en memoria 
    $check_usuario=null;
    
    // verifico las claves coincidan
    if($clave!=$clave_rep){
        echo '<div class="notification is-danger is-light">
        <strong>Las claves no coinciden</strong>
        </div>';
        exit();
    }else{
        $clave=password_hash($clave,PASSWORD_BCRYPT,["cost"=>10]);
    }

    // guardando datos
    $guardar_usuario=conexion();
    //uso prepare para evitar la inyeccion de codigo
    // $guardar_usuario= $guardar_usuario->query("INSERT INTO usuario(usuario_nombre,usuario_apellido,usuario_usr,usuario_clave,usuario_email) VALUES('$nombre','$apellido','$usuario','$clave','$email')");

    $guardar_usuario= $guardar_usuario->prepare("INSERT INTO usuario(usuario_nombre,usuario_apellido,usuario_usr,usuario_clave,usuario_email) VALUES(:nombre,:apellido,:usuario,:clave,:email)");

    $marcadores=[
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":usuario"=>$usuario,
        ":clave"=>$clave,
        ":email"=>$email
    ];

    $guardar_usuario->execute($marcadores);

    if($guardar_usuario->rowCount()==1){
        echo '<div class="notification is-info is-light">
        <strong>Usuario registrado correctamente</strong>
        </div>';
    }else{
        echo '<div class="notification is-danger is-light">
        <strong>Error no se pudo registrar el usuario</strong>
        </div>';
        exit();
    }

    $guardar_usuario=null;


?> 

