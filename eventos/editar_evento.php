<?php
include "configuraconDB.php";

// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Variable para almacenar datos del evento
$evento = null;

// Verificar si se recibió un ID de evento
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_evento = $_GET['id'];

    // Preparar consulta para obtener datos del evento
    $sql = "SELECT * FROM eventos WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_evento);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $evento = $resultado->fetch_assoc();
    } else {
        // Redirigir si no se encuentra el evento
        header("Location: listar_eventos.php?error=evento_no_encontrado");
        exit();
    }
}

// Procesar actualización si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $nombre_evento = $_POST['nombre_evento'];
    $descripcion_evento = strip_tags($_POST['descripcion_evento'], '<p><strong><em><u><h1><h2><h3><ul><ol><li><a>');
    $fecha_evento = $_POST['fecha_evento'];
    $ubicacion = $_POST['ubicacion'];
    $direccion = $_POST['direccion'];
    $cantidad_invitados = $_POST['cantidad_invitados'];
    $tipo_evento = $_POST['tipo_evento'];

    // Preparar consulta de actualización
    $sql = "UPDATE eventos SET 
            nombre = ?, 
            descripcion = ?, 
            fecha = ?, 
            ubicacion = ?, 
            direccion = ?, 
            cantinvitados = ?, 
            tipoevento = ? 
            WHERE id = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "sssssssi", 
        $nombre_evento, 
        $descripcion_evento, 
        $fecha_evento, 
        $ubicacion, 
        $direccion, 
        $cantidad_invitados, 
        $tipo_evento,
        $id_evento
    );

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: listar_eventos.php?mensaje=actualizado");
        exit();
    } else {
        $error = "Error al actualizar el evento";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tiny.cloud/1/z0m822rw2vprprhb2maqxw38xq3i8pzi4z81fp3zx3tg5kvk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#descripcion_evento',
            language: 'es_MX',
            height: 300,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 
                'charmap', 'preview', 'anchor', 'searchreplace', 
                'visualblocks', 'code', 'fullscreen', 
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic underline | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help'
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Editar Evento</h1>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="" method="POST" novalidate>
            <div class="form-group">
                <label for="nombre_evento">Nombre del Evento:</label>
                <input type="text" id="nombre_evento" name="nombre_evento" 
                       value="<?php echo htmlspecialchars($evento['nombre_evento']); ?>" required>
            </div>

            <div class="form-group">
                <label for="descripcion_evento">Descripción del Evento:</label>
                <textarea id="descripcion_evento" name="descripcion_evento" required>
                    <?php echo $evento['descripcion_evento']; ?>
                </textarea>
            </div>

            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" id="fecha_evento" name="fecha_evento" 
                       value="<?php echo $evento['fecha_evento']; ?>" required>
            </div>

            <div class="form-group">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" id="ubicacion" name="ubicacion" 
                       value="<?php echo htmlspecialchars($evento['ubicacion']); ?>" required>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" 
                       value="<?php echo htmlspecialchars($evento['direccion']); ?>" required>
            </div>

            <div class="form-group">
                <label for="cantidad_invitados">Cantidad de Invitados:</label>
                <input type="number" id="cantidad_invitados" name="cantidad_invitados" 
                       value="<?php echo $evento['cantidad_invitados']; ?>" min="1" required>
            </div>

            <div class="form-group">
                <label for="tipo_evento">Tipo de Evento:</label>
                <select id="tipo_evento" name="tipo_evento" required>
                    <option value="corporativo" <?php echo ($evento['tipo_evento'] == 'corporativo') ? 'selected' : ''; ?>>Corporativo</option>
                    <option value="social" <?php echo ($evento['tipo_evento'] == 'social') ? 'selected' : ''; ?>>Social</option>
                    <option value="academico" <?php echo ($evento['tipo_evento'] == 'academico') ? 'selected' : ''; ?>>Académico</option>
                    <option value="cultural" <?php echo ($evento['tipo_evento'] == 'cultural') ? 'selected' : ''; ?>>Cultural</option>
                    <option value="deportivo" <?php echo ($evento['tipo_evento'] == 'deportivo') ? 'selected' : ''; ?>>Deportivo</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Actualizar Evento</button>
                <a href="listar_eventos.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar conexión
$conexion->close();
?>