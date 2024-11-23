<?php
include 'db.php';

// Agregar reporte
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_reporte'])) {
    $fecha_creacion = $_POST['fecha_creacion'];

    $sql = "INSERT INTO reporte (fecha_creacion) VALUES ('$fecha_creacion')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Reporte agregado correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Eliminar reporte
if (isset($_GET['delete'])) {
    $id_reporte = $_GET['delete'];
    $sql = "DELETE FROM reporte WHERE id_reporte = $id_reporte";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Reporte eliminado correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener lista de reportes
$sql_reportes = "SELECT * FROM reporte";
$result_reportes = $conn->query($sql_reportes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reportes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background: #5d8aa8;
            color: white;
            padding: 1rem 0;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 2rem auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 1rem;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #5d8aa8;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        form {
            width: 80%;
            margin: 2rem auto;
            padding: 1rem;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 0.5rem 1rem;
            background: #5d8aa8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #4a6c8a;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Reportes</h1>
    </header>
    <main>
        <form method="POST">
            <h2>Agregar Reporte</h2>
            <label for="fecha_creacion">Fecha de Creación</label>
            <input type="date" name="fecha_creacion" id="fecha_creacion" required>
            <button type="submit" name="add_reporte">Agregar</button>
        </form>

        <h2 style="text-align: center;">Lista de Reportes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_reportes->num_rows > 0): ?>
                    <?php while ($reporte = $result_reportes->fetch_assoc()): ?>
                        <tr>
                            <td><?= $reporte['id_reporte'] ?></td>
                            <td><?= $reporte['fecha_creacion'] ?></td>
                            <td>
                                <a href="?delete=<?= $reporte['id_reporte'] ?>" onclick="return confirm('¿Estás seguro de eliminar este reporte?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3">No hay datos disponibles</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
