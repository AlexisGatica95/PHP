<?php
    $user_id_del=limpiar_cadena($_GET['user_id_del']);

    //verifico usuario

    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT usuario_id FROM usuario WHERE  usuario_id='$user_id_del'");

    if ($check_usuario->rowCount()==1) {
        $check_producto=conexion();
        //chekeo si ese usr tiene productos
        $check_producto=$check_producto->query("SELECT usuario_id FROM producto WHERE  usuario_id='$user_id_del' LIMIT 1");

        if ($check_producto->rowCount()<=0) {
            $eliminar_usuario=conexion();
            $eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM usuario WHERE  usuario_id=:id");

            $eliminar_usuario->execute([":id"=>$user_id_del]);

            if ($eliminar_usuario->rowCount()==1) {
                echo '<div class="notification is-info is-light">
                <strong>Usuario eliminado</strong>
                </div>';
            } else {
                echo '<div class="notification is-danger is-light">
                <strong>No se pudo eliminar el usuario por favor intente nuevamente</strong>
                </div>';
            }
            $eliminar_usuario=null;

        } else {
            echo '<div class="notification is-danger is-light">
            <strong>El usuario que intenta eliminar tiene productos asignados</strong>
            </div>';
        }
        $check_producto=null;
    } else {
        echo '<div class="notification is-danger is-light">
        <strong>El usuario que intenta eliminar no existe</strong>
        </div>';
    }
    //siempre cierro la conexion;
    $check_usuario=null;
?>