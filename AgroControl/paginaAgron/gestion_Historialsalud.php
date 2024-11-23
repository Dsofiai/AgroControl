<?php
include 'db.php';

// Agregar historial de salud
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_historial'])) {
    $id_vaca = $_POST['id_vaca'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO historialsalud (id_vaca, fecha, descripcion, estado) 
            VALUES ('$id_vaca', '$fecha', '$descripcion', '$estado')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Historial de salud agregado correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Eliminar historial de salud
if (isset($_GET['delete'])) {
    $id_historial = $_GET['delete'];
    $sql = "DELETE FROM historialsalud WHERE id_historial = $id_historial";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Historial de salud eliminado correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener lista de historiales de salud
$sql_historiales = "SELECT * FROM historialsalud";
$result_historiales = $conn->query($sql_historiales);

// Obtener lista de vacas (para el formulario)
$sql_vacas = "SELECT * FROM vaca";
$result_vacas = $conn->query($sql_vacas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Historiales de Salud</title>
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
        input, select, textarea {
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
        <h1>Gestión de Historiales de Salud</h1>
    </header>
    <main>
        <form method="POST">
            <h2>Agregar Historial de Salud</h2>
            
            <label for="id_vaca">Vaca</label>
            <select name="id_vaca" id="id_vaca" required>
                <?php while ($vaca = $result_vacas->fetch_assoc()): ?>
                    <option value="<?= $vaca['id_vaca'] ?>"><?= $vaca['nombre'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" required>

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

            <label for="estado">Estado</label>
            <input type="text" name="estado" id="estado" required>

            <button type="submit" name="add_historial">Agregar</button>
        </form>

        <h2 style="text-align: center;">Lista de Historiales de Salud</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vaca</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_historiales->num_rows > 0): ?>
                    <?php while ($historial = $result_historiales->fetch_assoc()): ?>
                        <tr>
                            <td><?= $historial['id_historial'] ?></td>
                            <td><?= $historial['id_vaca'] ?></td>
                            <td><?= $historial['fecha'] ?></td>
                            <td><?= $historial['descripcion'] ?></td>
                            <td><?= $historial['estado'] ?></td>
                            <td>
                                <a href="?delete=<?= $historial['id_historial'] ?>" onclick="return confirm('¿Estás seguro de eliminar este historial de salud?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6">No hay datos disponibles</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
