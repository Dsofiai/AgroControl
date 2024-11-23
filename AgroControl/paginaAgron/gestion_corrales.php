<?php
include 'db.php';

// Agregar corral
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_corral'])) {
    $nombre = $_POST['nombre'];
    $id_dueno = $_POST['id_dueno'];

    $sql = "INSERT INTO corral (nombre, id_dueno) VALUES ('$nombre', '$id_dueno')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Corral agregado correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Eliminar corral
if (isset($_GET['delete'])) {
    $id_corral = $_GET['delete'];
    $sql = "DELETE FROM corral WHERE id_corral = $id_corral";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Corral eliminado correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener lista de corrales
$sql_corrales = "SELECT c.id_corral, c.nombre, d.nombre AS dueno_nombre 
                 FROM corral c 
                 INNER JOIN dueno d ON c.id_dueno = d.id_dueno";
$result_corrales = $conn->query($sql_corrales);

// Obtener lista de dueños
$sql_duenos = "SELECT * FROM dueno";
$result_duenos = $conn->query($sql_duenos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Corrales</title>
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
        input, select {
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
        <h1>Gestión de Corrales</h1>
    </header>
    <main>
        <form method="POST">
            <h2>Agregar Corral</h2>
            <label for="nombre">Nombre del Corral</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="id_dueno">Dueño</label>
            <select name="id_dueno" id="id_dueno" required>
                <?php while ($dueno = $result_duenos->fetch_assoc()): ?>
                    <option value="<?= $dueno['id_dueno'] ?>"><?= $dueno['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="add_corral">Agregar</button>
        </form>

        <h2 style="text-align: center;">Lista de Corrales</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dueño</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result_corrales->num_rows > 0): ?>
                    <?php while ($corral = $result_corrales->fetch_assoc()): ?>
                        <tr>
                            <td><?= $corral['id_corral'] ?></td>
                            <td><?= $corral['nombre'] ?></td>
                            <td><?= $corral['dueno_nombre'] ?></td>
                            <td>
                                <a href="?delete=<?= $corral['id_corral'] ?>" onclick="return confirm('¿Estás seguro de eliminar este corral?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">No hay datos disponibles</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
