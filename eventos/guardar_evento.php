<?php
// Configuración de conexión a la base de datos
include "configuraconDB.php";

// Crear conexión
$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Capturar datos del formulario
$nombre_evento = $_POST['nombre_evento'];
// Usar strip_tags para limpiar contenido HTML
$descripcion_evento = strip_tags($_POST['descripcion_evento'], '<p><strong><em><u><h1><h2><h3><ul><ol><li><a>');
$fecha_evento = $_POST['fecha_evento'];
$ubicacion = $_POST['ubicacion'];
$direccion = $_POST['direccion'];
$cantidad_invitados = $_POST['cantidad_invitados'];
$tipo_evento = $_POST['tipo_evento'];

// Preparar consulta SQL con sentencia preparada
$sql = "INSERT INTO eventos (
    nombre, 
    descripcion, 
    fecha, 
    ubicacion, 
    direccion, 
    cantinvitados, 
    tipoevento
) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

// Vincular parámetros
$stmt->bind_param(
    "sssssss", 
    $nombre_evento, 
    $descripcion_evento, 
    $fecha_evento, 
    $ubicacion, 
    $direccion, 
    $cantidad_invitados, 
    $tipo_evento
);

// Ejecutar consulta
if ($stmt->execute()) {
    echo "Evento registrado exitosamente.";
} else {
    echo "Error al registrar el evento: " . $stmt->error;
}

// Cerrar conexión
$stmt->close();
$conexion->close();
?>