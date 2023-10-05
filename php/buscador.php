<?php
    $modulo_buscador=limpiar_cadena($_POST['modulo_buscador']);

    $modulos=["usuario","categoria","producto"];

    if (in_array($modulo_buscador,$modulos)) {
        //creo un array que contiene las vistas cuando eliminemos un termino de busqueda
        $modulos_url=[
            "usuario"=>"user_search",
            "categoria"=>"category_search",
            "producto"=>"product_search"
        ];
        
        //vista donde buscamos
        $modulos_url=$modulos_url[$modulo_buscador];
        //variable de sesion que voy a usar
        $modulo_buscador="busqueda_".$modulo_buscador;
        
        //busqueda
        if (isset($_POST['txt_buscador'])) {
            $txt=limpiar_cadena($_POST['txt_buscador']);

            if ($txt=='') {
                echo '
                    <div class="notification is-danger is-light">
                    <strong>Introduce un termino de busqueda</strong>
                    </div>';
            } else {
                if (!verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}',$txt)) {
                    echo '
                    <div class="notification is-danger is-light">
                    <strong>No coincide con el formato solicitado</strong>
                    </div>';
                } else {
                    $_SESSION[$modulo_buscador]=$txt;
                    //me manda a la vista de manera dinamica
                    header("Location: index.php?vista=$modulos_url",true,303);
                    exit();
                }
                
            }
            
        }

        //eliminar busqueda
        if (isset($_POST['eliminar_buscador'])) {
            echo'se esta intentando elimiar la variable de sesion wacho';
            unset($_SESSION[$modulo_buscador]);
      
            header("Location: index.php?vista=$modulos_url",true,303);
        } 
        
    } else {
        //el codigo solo permite hacer enviarse si el valor conincide con el input vacio
        echo '<div class="notification is-danger is-light">
        <strong>Ocurrio un error inesperado</strong>
        </div>';
    }
    
?>