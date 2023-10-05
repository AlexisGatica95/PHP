<?php
    $inicio=($pagina>0) ? (($pagina*$registros)-$registros): 0 ;
    $tabla='';
    if (isset($busqueda) && $busqueda!="") {
        $consulta_datos="SELECT * FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_usr LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%' )) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(usuario_id) FROM usuario  WHERE ((usuario_id!='".$_SESSION['id']."') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_usr LIKE '%$busqueda%' OR usuario_email LIKE '%$busqueda%' ))";
    } else {
        $consulta_datos= "SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."'ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id!='".$_SESSION['id']."'";
    }
    
    $conexion= conexion();

    $datos=$conexion->query($consulta_datos);
    $datos=$datos->fetchAll();//hago un array de todos los registros

    $total=$conexion->query($consulta_total);
    $total= (int) $total->fetchColumn();//devuelve una columna de los resultados

    $Npaginas=ceil($total/$registros);

    $tabla.='<div class="table-container">
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <thead>
            <tr class="has-text-centered">
                <th>#</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Email</th>
                <th colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>
    ';
    //si hay registro && si existe la pagina
    if ($total>=1 && $pagina<=$Npaginas) {
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;

        foreach($datos as $usuario){
            $tabla.='
            <tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$usuario["usuario_nombre"].'</td>
                    <td>'.$usuario["usuario_apellido"].'</td>
                    <td>'.$usuario["usuario_usr"].'</td>
                    <td>'.$usuario["usuario_email"].'</td>
                    <td>
                        <a href="index.php?vista=user_update&user_id_up='.$usuario["usuario_id"].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&user_id_del='.$usuario["usuario_id"].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final=$contador-1;
    } else {
        if ($total>=1) {
            $total.=' 
            <tr class="has-text-centered" >
            <td colspan="7">
                <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic acá para recargar el listado
                </a>
            </td>
            </tr>';
        } else {
            $total.='
            <tr class="has-text-centered" >
            <td colspan="7">
                No hay registros en el sistema
            </td>
            </tr>';
        }
        
    }

    $tabla.=' </tbody></table></div>';

    if ($total>=1 && $pagina<=$Npaginas){
        $tabla.='
        <p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }
    $conexion=null;


    echo $tabla;
    
    if($total>=1 && $pagina<=$Npaginas){
        echo paginador_tablas($pagina,$Npaginas,$url,2);
    }
?>