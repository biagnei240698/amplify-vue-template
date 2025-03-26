<?php
include "configuraconDB.php";
// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$id=$_GET['id'];
// Consulta para obtener todos los eventos
$sql = "SELECT * FROM eventos WHERE id=".$id;
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Eventos</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f4f4;
            padding: 20px;
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .action-icons a {
            margin-right: 10px;
            text-decoration: none;
        }
        .edit-icon {
            color: #28a745;
        }
        .delete-icon {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div calss="col-lg-6 col-6">
                    <?php 
                    // Verificar si hay eventos
                    if ($resultado->num_rows > 0) {
                        // Mostrar cada evento en una fila
                        while($evento = $resultado->fetch_assoc()) {
                            // Formatear la fecha
                            $fecha_formateada = date("d/m/Y", strtotime($evento['fecha']));
                            
                            echo "<h2>" . htmlspecialchars($evento['nombre']) . "</h2>";
                            echo "<p>" . htmlspecialchars($evento['descripcion']) . "</p>";
                            echo "<p>" . htmlspecialchars($evento['direccion']) . "</p>";
                            echo "<h2>" . htmlspecialchars($evento['fecha']) . "</h2>";
                            echo '<iframe src="https://embed.waze.com/iframe?zoom=12&'.$evento['ubicacion'].'&ct=livemap" width="600" height="450" allowfullscreen></iframe>';
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No hay eventos registrados</td></tr>";
                    }
                    ?>
            </div>
            <div calss="col-lg-6 col-6">

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar conexión
$conexion->close();
?>