<?php
include 'db.php';

// Agregar dueño
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_dueno'])) {
    $nombre = $_POST['nombre'];

    $sql = "INSERT INTO dueno (nombre) VALUES ('$nombre')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Dueño agregado correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Eliminar dueño
if (isset($_GET['delete'])) {
    $id_dueno = $_GET['delete'];
    $sql = "DELETE FROM dueno WHERE id_dueno = $id_dueno";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Dueño eliminado correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener lista de dueños
$sql_duenos = "SELECT * FROM dueno";
$result_duenos = $conn->query($sql_duenos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Dueños</title>
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
        <h1>Gestión de Dueños</h1>
    </header>
    <main>
        <form method="POST">
            <h2>Agregar Dueño</h2>
            <label for="nombre">Nombre del Dueño</label>
            <input type="text" name="nombre" id="nombre" required>
            <button type="submit" name="add_dueno">Agregar</button>
        </form>

        <h2 style="text-align: center;">Lista de Dueños</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_duenos->num_rows > 0): ?>
                    <?php while ($dueno = $result_duenos->fetch_assoc()): ?>
                        <tr>
                            <td><?= $dueno['id_dueno'] ?></td>
                            <td><?= $dueno['nombre'] ?></td>
                            <td>
                                <a href="?delete=<?= $dueno['id_dueno'] ?>" onclick="return confirm('¿Estás seguro de eliminar este dueño?')">Eliminar</a>
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
