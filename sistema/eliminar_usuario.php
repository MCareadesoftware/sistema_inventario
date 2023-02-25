<?php
include "../conexion.php";
if(!empty($_POST))
{
    $idusuario = $_POST['idusuario'];

    // Cambia el estado del usuario a inactivo para que deje de mostrarse en la lista de usuarios
    $query_delete = mysqli_query($conection, "CALL sp_eliminar_usuario($idusuario)");

    if($query_delete){
        header('location: lista_usuarios.php');
    }else{
        echo "Error al eliminar";
    }
}
if(empty($_REQUEST['id']) || $_REQUEST['id'] == 1)
{
    header("location: lista_usuarios.php");
}else{
    
    $idusuario = $_REQUEST['id'];

    // Recopila los datos del usuario a eliminar
    $query = mysqli_query($conection, "SELECT u.nombre,u.usuario,r.rol
                                        FROM usuario u
                                        INNEr JOIN rol r
                                        on u.rol = r.idrol
                                        WHERE idusuario = $idusuario");
    $result = mysqli_num_rows($query);

    if($result > 0){
        while ($data = mysqli_fetch_array($query)) {
            // Asigna los datos recopilados a variables
            $nombre = $data['nombre'];
            $usuario = $data['usuario'];
            $rol = $data['rol'];
        }
    }else{
        header("location: lista_usuarios.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
            <h2>¿Eliminar usuario</h2>
            <p>Nombre: <span><?php echo $nombre; ?></span></p>
            <p>Usuario: <span><?php echo $usuario ?></span></p>
            <p>Tipo Usuario: <span><?php echo $rol ?></span></p>
            <form method="post" action="">
                <!-- Indicador oculto del id del usuario a eliminar (solo para verificación en modo desarrollador) -->
                <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
                <a href="lista_usuarios.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Aceptar" class="btn_ok">
            </form>
        </div>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>