<?php
include 'db.php';

// Agregar relación entre reporte e historial
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_reportehistorial'])) {
    $id_reporte = $_POST['id_reporte'];
    $id_historial = $_POST['id_historial'];

    $sql = "INSERT INTO reportehistorial (id_reporte, id_historial) VALUES ('$id_reporte', '$id_historial')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Relación agregada correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener lista de reportes
$sql_reportes = "SELECT * FROM reporte";
$result_reportes = $conn->query($sql_reportes);

// Obtener lista de historiales
$sql_historiales = "SELECT * FROM historialsalud";
$result_historiales = $conn->query($sql_historiales);

// Obtener lista de relaciones existentes entre reporte e historial
$sql_reportehistorial = "SELECT * FROM reportehistorial";
$result_reportehistorial = $conn->query($sql_reportehistorial);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reporte-Historial</title>
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
        select, button {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #5d8aa8;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #4a6c8a;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestión de Relación Reporte-Historial</h1>
    </header>
    <main>
        <form method="POST">
            <h2>Agregar Relación Reporte-Historial</h2>
            <label for="id_reporte">Seleccionar Reporte</label>
            <select name="id_reporte" id="id_reporte" required>
                <option value="">Seleccionar Reporte</option>
                <?php while ($reporte = $result_reportes->fetch_assoc()): ?>
                    <option value="<?= $reporte['id_reporte'] ?>"><?= $reporte['id_reporte'] ?> - <?= $reporte['fecha_creacion'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="id_historial">Seleccionar Historial</label>
            <select name="id_historial" id="id_historial" required>
                <option value="">Seleccionar Historial</option>
                <?php while ($historial = $result_historiales->fetch_assoc()): ?>
                    <option value="<?= $historial['id_historial'] ?>"><?= $historial['id_historial'] ?> - <?= $historial['estado'] ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="add_reportehistorial">Agregar</button>
        </form>

        <h2 style="text-align: center;">Relaciones Reporte-Historial Existentes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Reporte</th>
                    <th>ID Historial</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_reportehistorial->num_rows > 0): ?>
                    <?php while ($row = $result_reportehistorial->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_reporte'] ?></td>
                            <td><?= $row['id_historial'] ?></td>
                            <td>
                                <a href="?delete=<?= $row['id_reporte'] ?>&id_historial=<?= $row['id_historial'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta relación?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3">No hay relaciones disponibles</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
