<?php

// Datos de conexión obtenidos desde Docker Compose
$host = getenv('DB_HOST');
$database = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

// Desactivar excepciones automáticas para controlar los errores
mysqli_report(MYSQLI_REPORT_OFF);

// Conectar con MySQL
$connection = new mysqli(
    $host,
    $username,
    $password,
    $database
);

// Comprobar la conexión
$error = null;
$data = null;

if ($connection->connect_errno) {
    $error = $connection->connect_error;
} else {
    $connection->set_charset("utf8mb4");

    // Consultar información de la base de datos
    $result = $connection->query(
        "SELECT DATABASE() AS nombre_bd, NOW() AS fecha"
    );

    if ($result) {
        $data = $result->fetch_assoc();
    } else {
        $error = $connection->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola Mundo - PHP y MySQL</title>
</head>
<body>

    <h1>¡Hola Mundo!</h1>

    <?php if ($error === null && $data !== null): ?>

        <h2>Conexión exitosa a MySQL</h2>

        <p>La aplicación se conectó correctamente a la base de datos.</p>

        <p>
            Base de datos:
            <?= htmlspecialchars($data['nombre_bd']) ?>
        </p>

        <p>
            Fecha del servidor:
            <?= htmlspecialchars($data['fecha']) ?>
        </p>

    <?php else: ?>

        <h2>Error de conexión</h2>

        <p><?= htmlspecialchars($error ?? 'No se pudo consultar la base de datos.') ?></p>

    <?php endif; ?>

</body>
</html>

<?php
if (!$connection->connect_errno) {
    $connection->close();
}
?>