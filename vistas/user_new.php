<div class="main-container">

    <div class="form-rest"></div>

    <form action="./php/usuario_guardar.php" method="POST" id="form_registro" class="FormularioAjax" autocomplete="off">
        <h2 class="titulo">Registro</h2>
        <label class="d-flex d-column">
            <span>Nombre</span>
            <input type="text" name="registro_nombre" pattern="[a-zA-Z0-9 ]{4-20}" required>
        </label>
        <label class="d-flex d-column">
            <span>Apellido</span>
            <input type="text" name="registro_apellido" pattern="[a-zA-Z0-9 ]{4-20}" required>
        </label>
        <label class="d-flex d-column">
            <span>Usuario</span>
            <input type="text" name="registro_usuario" pattern="[a-zA-Z0-9 ]{4-20}" required>
        </label>
        <label class="d-flex d-column">
            <span>email</span>
            <input type="email" name="registro_email"  pattern="[a-zA-Z0-9$@.-]{7-100}"  max-length="100" required>
        </label>
        <label class="d-flex d-column">
            <span>Clave</span>
            <input type="password" name="registro_clave" pattern="[a-zA-Z0-9$@.-]{7-100}"  max-length="100" required>
        </label>
        <label class="d-flex d-column">
            <span>Repetir Clave</span>
            <input type="password" name="registro_clave_rep" pattern="[a-zA-Z0-9$@.-]{7-100}"  max-length="100" required>
        </label>
        <button type="submit">registro</button>
    </form>
</div>