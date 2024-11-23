<?php
include 'db.php';

if (!isset($conn)) {
    die("Error: La conexión a la base de datos no está disponible.");
}
// Agregar vaca
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_vaca'])) {
    $id_corral = $_POST['id_corral'];
    $nombre = $_POST['nombre'];
    $peso = $_POST['peso'];
    $edad = $_POST['edad'];
    $estado_salud = $_POST['estado_salud'];

    $sql = "INSERT INTO vaca (id_corral, nombre, peso, edad, estado_salud) 
            VALUES ('$id_corral', '$nombre', '$peso', '$edad', '$estado_salud')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Vaca agregada correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Eliminar vaca
if (isset($_GET['delete'])) {
    $id_vaca = $_GET['delete'];
    $sql = "DELETE FROM vaca WHERE id_vaca = $id_vaca";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Vaca eliminada correctamente');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener vacas
$sql = "SELECT v.id_vaca, v.nombre AS vaca_nombre, v.peso, v.edad, v.estado_salud, c.nombre AS corral_nombre, v.id_corral 
        FROM vaca v 
        INNER JOIN corral c ON v.id_corral = c.id_corral";
$result = $conn->query($sql);

// Obtener corrales
$corrales = $conn->query("SELECT * FROM corral");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vacas</title>
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
        <h1>Gestión de Vacas</h1>
    </header>
    <main>
        <form method="POST">
            <h2>Agregar Vaca</h2>
            <label for="id_corral">Corral</label>
            <select name="id_corral" id="id_corral" required>
                <?php while ($row = $corrales->fetch_assoc()): ?>
                    <option value="<?= $row['id_corral'] ?>"><?= $row['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="peso">Peso (kg)</label>
            <input type="number" name="peso" id="peso" step="0.01" required>
            <label for="edad">Edad</label>
            <input type="number" name="edad" id="edad" required>
            <label for="estado_salud">Estado de Salud</label>
            <input type="text" name="estado_salud" id="estado_salud" required>
            <button type="submit" name="add_vaca">Agregar</button>
        </form>

        <h2 style="text-align: center;">Listado de Vacas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Peso (kg)</th>
                    <th>Edad</th>
                    <th>Estado</th>
                    <th>Corral</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_vaca'] ?></td>
                            <td><?= $row['vaca_nombre'] ?></td>
                            <td><?= $row['peso'] ?></td>
                            <td><?= $row['edad'] ?></td>
                            <td><?= $row['estado_salud'] ?></td>
                            <td><?= $row['corral_nombre'] ?></td>
                            <td>
                                <a href="editar_vaca.php?id=<?= $row['id_vaca'] ?>">Editar</a> |
                                <a href="?delete=<?= $row['id_vaca'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta vaca?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">No hay datos disponibles</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
