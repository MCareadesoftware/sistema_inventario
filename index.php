<?php
$alert = '';
session_start();
if(!empty($_SESSION['active']))
{
    header('location: sistema/');
}else{
    if(!empty($_POST))
    {
        if(empty($_POST['usuario']) || empty($_POST['clave']))
        {
            $alert = 'Ingrese usuario y contraseña';
        }else{
            require_once "conexion.php";

            $user = mysqli_real_escape_string($conection,$_POST['usuario']);
            $pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));

            $query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$pass'");
            $result = mysqli_num_rows($query);

            if($result > 0)
            {
                $data = mysqli_fetch_array($query);
                session_start();
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $data['idusuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['user'] = $data['usuario'];
                $_SESSION['rol'] = $data['rol'];

                header('location: sistema/');
            }else{
                $alert = 'Usuario o clave incorrecto';
                session_destroy();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema Facturación</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <div class="wrapper">
        <div class="container main">
            <div class="row shadow">
                <div class="col-md-6 side-image">
                    <!--Image-->
                    <img src="images/logo.png" alt="">
                    <div class="text">
                        <p>Siendo parte del cambio.</p>
                    </div>
                </div>
                <form action="" method="post" class="col-md-6 right">
                    <div class="input-box">
                        <header>Iniciar Sesión</header>
                        <div class="input-field">
                            <input type="text" name="usuario" id="email" class="input" required autocomplete = "off">
                            <label for="email">Usuario</label>
                        </div>
                        <div class="input-field">
                            <input type="password" name="clave" id="password" class="input" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="alert">
                            <?php echo isset($alert) ? $alert : ''; ?>
                        </div>
                        <div class="input-field">
                            <input type="submit" name="" id="" class="submit" value="Iniciar Sesión">
                        </div>
                        <div class="signin">
                            <span>Olvidaste tu contraseña <a href="#">Comunicarse con Soporte</a></span>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>