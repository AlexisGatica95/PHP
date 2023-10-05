<div class="main-container">
    <div class="form-rest"></div>
    <form action="" method="POST" id="form_login"  autocomplete="off">
        <h2 class="titulo">Login</h2>
        <label class="d-flex d-column">
            <span>Usuario</span>
            <input type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4-20}" required>
        </label>
        <label class="d-flex d-column">
            <span>Contraseña</span>
            <input type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7-100}"  max-length="100" required>
        </label>
        <button type="submit">Login</button>
    </form>

    <?php
       
        if(isset($_POST['login_usuario'])&& isset($_POST['login_clave'])){
            include_once './php/main.php';
            include_once './php/iniciar_sesion.php';
        }else{
            echo 'salio por else';
        }
        

    ?>
    </div>
</div>