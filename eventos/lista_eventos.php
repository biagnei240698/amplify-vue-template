<?php
include "configuraconDB.php";
// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener todos los eventos
$sql = "SELECT id, nombre, fecha, tipoevento FROM eventos ORDER BY fecha DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Eventos</title>
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
        <div class="table-container">
            <h2 class="mb-4">Listado de Eventos</h2>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre del Evento</th>
                        <th>Fecha</th>
                        <th>Tipo de Evento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Verificar si hay eventos
                    if ($resultado->num_rows > 0) {
                        // Mostrar cada evento en una fila
                        while($evento = $resultado->fetch_assoc()) {
                            // Formatear la fecha
                            $fecha_formateada = date("d/m/Y", strtotime($evento['fecha']));
                            
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($evento['nombre']) . "</td>";
                            echo "<td>" . $fecha_formateada . "</td>";
                            echo "<td>" . htmlspecialchars($evento['tipoevento']) . "</td>";
                            echo "<td class='action-icons'>";
                            echo "<a href='editar_evento.php?id=" . $evento['id'] . "' class='edit-icon'><i class='bi bi-pencil-square'></i></a>";
                            echo "<a href='ver_evento.php?id=" . $evento['id'] . "' class='edit-icon'><i class='bi bi-check-square'></i></a>";
                            echo "<a href='eliminar_evento.php?id=" . $evento['id'] . "' class='delete-icon' onclick='return confirm(\"¿Estás seguro de eliminar este evento?\")'><i class='bi bi-trash'></i></a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No hay eventos registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="index.html" class="btn btn-primary">Registrar Nuevo Evento</a>
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