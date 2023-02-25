<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<h1>Dashboard de Stock</h1>
        <div class="container row px-5">
        <table>
            <tr>
                <th>ID</th>
                <th>Categoria</th>
                <th>Unidades</th>
                <th>Precio Unitario</th>
                <th>Valor Stock Total</th>
            </tr>
            <?php
                include "../conexion.php";
                $sum_unidades = 0;
                $sum_precio = 0;
                $sum_precio_total = 0;

                // Determina la cantidad total de categorias registradas
                $sql_register = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM categoria");
                $result_register = mysqli_fetch_array($sql_register);
                $total_registro = $result_register['total_registro'];

                // Recolecta informacion de la tabla categorias
                $query = mysqli_query($conection,"SELECT c.codcategoria, c.descripcion, c.unidades, c.precio
                                                    FROM categoria c
                                                    ORDER BY codcategoria ASC");
                
                $result = mysqli_num_rows($query);
                if($result > 0){
                    while ($data = mysqli_fetch_array($query)) {
                        // Realiza la suma de los datos numéricos de las categorías
                        $sum_unidades += $data["unidades"];
                        $sum_precio += $data["precio"];
                        $sum_precio_total += $data["unidades"] * $data["precio"];
            ?>
            <tr>
                <!-- Mostrar datos de categoría -->
                <td><?php echo $data["codcategoria"] ?></td>
                <td><?php echo $data["descripcion"] ?></td>
                <td><?php echo $data["unidades"] ?></td>
                <td>S/. <?php echo number_format($data["precio"],2) ?></td>
                <td>S/. <?php echo number_format($data["unidades"] * $data["precio"],2) ?></td>
            </tr>
            <?php
                    }
                }
            ?>
            <tr>
                <!-- Fila del total -->
                <td>Total</td>
                <td></td>
                <td><?php echo $sum_unidades ?></td>
                <td>S/. <?php echo number_format($sum_precio,2) ?></td>
                <td>S/. <?php echo number_format($sum_precio_total,2) ?></td>
            </tr>
        </table>
            <div class="col-6 px-5">
                <h2>Valor de categorias</h2>
                <canvas id="myChartDonut"></canvas>
            </div>
            <div class="col-6 px-5">
                <h2>Stock disponible</h2>
                <canvas id="myChartBar"></canvas>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctxD = document.getElementById('myChartDonut');

            // Gráfico de donut sobre el valor total de cada categoría
            new Chart(ctxD, {
                type: 'doughnut',
                data: {
                    labels: [<?php
                        $query = mysqli_query($conection,"SELECT c.codcategoria, c.descripcion, c.unidades, c.precio
                        FROM categoria c
                        ORDER BY codcategoria ASC");

                        $result = mysqli_num_rows($query);
                        if($result > 0){
                        while ($data = mysqli_fetch_array($query)) {
                            ?>'<?php echo $data["descripcion"]; ?>',<?php
                        }} ?>
                    ],
                    datasets: [{
                    label: ' Valor en S/.',
                    data: [<?php
                        $query = mysqli_query($conection,"SELECT c.codcategoria, c.descripcion, c.unidades, c.precio
                        FROM categoria c
                        ORDER BY codcategoria ASC");

                        $result = mysqli_num_rows($query);
                        if($result > 0){
                        while ($data = mysqli_fetch_array($query)) {
                            echo $data["unidades"] * $data["precio"]; ?>,<?php
                        }} ?>
                    ],
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
            });
        </script>
        <script>
            const ctxB = document.getElementById('myChartBar');

            // Gráfico de barras sobre la cantidad de stock de cada categoría
            new Chart(ctxB, {
                type: 'bar',
                data: {
                    labels: [<?php
                        $query = mysqli_query($conection,"SELECT c.codcategoria, c.descripcion, c.unidades, c.precio
                        FROM categoria c
                        ORDER BY codcategoria ASC");

                        $result = mysqli_num_rows($query);
                        if($result > 0){
                            while ($data = mysqli_fetch_array($query)) {
                                ?>'<?php echo $data["descripcion"]; ?>',<?php
                            }
                        } ?>
                    ],
                    datasets: [{
                    label: ' Unidades en stock',
                    data: [<?php
                        $query = mysqli_query($conection,"CALL sp_mostrar_lista_productos");

                        $result = mysqli_num_rows($query);
                        if($result > 0){
                            while ($data = mysqli_fetch_array($query)) {
                                echo $data["unidades"]; ?>,<?php
                            }
                        } ?>
                    ],
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
            });
        </script>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>