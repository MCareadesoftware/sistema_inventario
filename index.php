<?php

if (!empty($_SESSION['active'])) {
    header('location: sistema/');
} else {

    if (!empty($_POST)) {


        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';

        require "conexion.php";

        $conection = conectarBD();

        $user = mysqli_real_escape_string($conection, $_POST['usuario']);
        $pass = mysqli_real_escape_string($conection, $_POST['clave']);


        $query = "SELECT * FROM usuario WHERE usuario = '{$user}' AND clave = '{$pass}'";

        $query_result = mysqli_query($conection, $query);

        $result = mysqli_num_rows($query_result);

        echo '<pre>';
        var_dump($result);
        echo '</pre>';

        if ($result) {

            echo "Si exite";

            echo '<pre>';
            var_dump($result);
            echo '</pre>';

            $data = mysqli_fetch_assoc($query_result);
            $_SESSION['active'] = true;
            $_SESSION['usuario_id'] = $data['usuario_id'];
            $_SESSION['nombre'] = $data['nombre'];
            $_SESSION['email'] = $data['correo'];
            $_SESSION['user'] = $data['usuario'];
            $_SESSION['rol_id'] = $data['rol_id'];


            session_start();
            header('location: sistema/');
        } else {
            $alert = 'Usuario o clave incorrecto';
            session_destroy();
        }


    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Invetario</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!--
    <div class="container w-75 bg-warning mt-5 rounded shadow">
        <div class="row align-items-md-stretch">
            <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">

            </div>
            <div class="col bg-white p-5 rounded-end">
                <div class="text-end">
                    <img src="images/logo.png" width="48" alt="">
                </div>
                <h2 class="fw-bold text-center py-5">Bienvenido</h2> -->
                
                <!--Login-->
                <!--
                <form action="#">
                    <div class="mb-4">
                        <label for="email" class="form-label">Usuario :</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña :</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" name="connected" class="form-check-input" id="">
                        <label for="connected" class="form-check-label">Mantenerme conectado</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">Iniciar Sesión</button>
                    </div>
                    <div class="mt-3 mb-4">
                        <span>¿Olvidaste tu contraseña?</span> <br>
                        <span><a href="#">Comunicarse con Soporte</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    -->

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
                <div class="col-md-6 right">
                <form class="input-box" method="POST" action="#">
                        <header>Iniciar Sesión</header>
                        <div class="input-field">
                            <input type="text" name="usuario" id="email" class="input" required autocomplete="off">
                            <label for="email">Usuario</label>
                        </div>
                        <div class="input-field">
                            <input type="password" name="clave" id="password" class="input" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="input-field">
                            <input type="submit" id="" class="submit" value="INGRESAR">
                        </div>
                        <div class="signin">
                            <span>Olvidaste tu contraseña <a href="#">Comunicarse con Soporte</a></span>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>