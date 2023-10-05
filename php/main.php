<?php
    //este archivo tiene los archivos que se repiten en el sistema
    //hago una instacioa para conexion a la DB

    function conexion(){
        $host = 'localhost';
        $dbname = 'inventario';
        $username = 'root';
        $password = '';


        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            return $pdo;
        } catch (PDOException $e) {
            echo "Lo siento, hubo un problema al conectarse a la base de datos. Por favor, inténtelo de nuevo más tarde.";
            return null;
        }
    }

    function verificar_datos($reg_exp,$cadena){
        if(preg_match("/^".$reg_exp."$/",$cadena)){
            return true;
        }else{
            return false;
        }

        
    }

    function limpiar_cadena($cadena){
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        // evito inyeccion SQL
        $cadena=str_ireplace("<script>", "", $cadena);
		$cadena=str_ireplace("</script>", "", $cadena);
		$cadena=str_ireplace("<script src", "", $cadena);
		$cadena=str_ireplace("<script type=", "", $cadena);
		$cadena=str_ireplace("SELECT * FROM", "", $cadena);
		$cadena=str_ireplace("DELETE FROM", "", $cadena);
		$cadena=str_ireplace("INSERT INTO", "", $cadena);
		$cadena=str_ireplace("DROP TABLE", "", $cadena);
		$cadena=str_ireplace("DROP DATABASE", "", $cadena);
		$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
		$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
		$cadena=str_ireplace("<?php", "", $cadena);
		$cadena=str_ireplace("?>", "", $cadena);
		$cadena=str_ireplace("--", "", $cadena);
		$cadena=str_ireplace("^", "", $cadena);
		$cadena=str_ireplace("<", "", $cadena);
		$cadena=str_ireplace("[", "", $cadena);
		$cadena=str_ireplace("]", "", $cadena);
		$cadena=str_ireplace("==", "", $cadena);
		$cadena=str_ireplace(";", "", $cadena);
		$cadena=str_ireplace("::", "", $cadena);

        return $cadena;
        
    }

    function renombrar_fotos($nombre){
        $nombre = str_ireplace(" ","_",$nombre);
        $nombre = str_ireplace("/","_",$nombre);
        $nombre = str_ireplace("#","_",$nombre);
        $nombre = str_ireplace("-","_",$nombre);
        $nombre = str_ireplace("$","_",$nombre);
        $nombre = str_ireplace(".","_",$nombre);
        $nombre = str_ireplace(",","_",$nombre);
        $nombre =$nombre."_".rand(0,100);

        return $nombre;
    }

    function paginador_tablas($pagina,$n_pag,$url,$cant_botones){
        $tabla='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';
        
        if($pagina<=1){
         
            $tabla.='
            <a class="pagination_previus is-disabled" disabled>Anterior</a>
            <ul class="pagination_list">';
        }else{
          
            $tabla.='
            <a class="pagination_previus"  href="'.$url.($pagina-1).'" >Anterior</a>
            <ul class="pagination_list">
            <li><a href="'.$url.'1" class="pagination_link">1</a></li>';
        }

        $ci=0;

        for($i=$pagina;$i<=$n_pag;$i++){
            if($ci>=$cant_botones){
                break;
            }
            if ($pagina==$i) {
                $tabla.='
                <li><a href="'.$url.$i.'" class="pagination_link is-current">'.$i.'</a></li>';
            } else {
                $tabla.='
                <li><a href="'.$url.$i.'" class="pagination_link">'.$i.'</a></li>';
            }

            $ci++;
            
        }

        if($pagina==$n_pag){
            
            $tabla.='
            </ul>
            <a class="pagination_next is-disabled" disabled>Siguiente</a>
            ' ;
        }else{
            $tabla.='
            <li><a href="'.$url.$n_pag.'" class="pagination-link">'.$n_pag.'</a></li>
            </ul>
            <a class="pagination_next"  href="'.$url.($pagina+1).'" >Siguiente</a>
            ' ;
        }     

        $tabla.='</nav>';
        return $tabla;

    }
    // $pdo->query("INSERT INTO categoria(categoria_nombre,categoria_ubicacion) VALUES('prueba','texto ubicacion') ");

?>

