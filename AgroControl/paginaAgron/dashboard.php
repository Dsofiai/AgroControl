<?php
session_start();

// Verificar si el usuario ha iniciado sesión
/*if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Gestión</title>
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
            padding: 1rem;
            text-align: center;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 2rem;
        }
        .card {
            width: 250px;
            margin: 1rem;
            padding: 1.5rem;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }
        a {
            text-decoration: none;
            color: #5d8aa8;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem;
            background: #5d8aa8;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel de Gestión AgroControl</h1>
    </header>
    <div class="container">
        <div class="card">
            <h2>Gestión de Corrales</h2>
            <a href="gestion_corrales.php">Ir a Corrales</a>
        </div>
        <div class="card">
            <h2>Gestión de Vacas</h2>
            <a href="gestion_vacas.php">Ir a Vacas</a>
        </div>
        <div class="card">
            <h2>Gestión de Dueños</h2>
            <a href="gestion_duenos.php">Ir a Dueños</a>
        </div>
        <div class="card">
            <h2>Gestión de Historial de Salud</h2>
            <a href="gestion_historialsalud.php">Ir a Historial de Salud</a>
        </div>
        <div class="card">
            <h2>Gestión de Reportes</h2>
            <a href="gestion_reportes.php">Ir a Reportes</a>
        </div>
        <div class="card">
            <h2>Gestión de Reporte Historial</h2>
            <a href="gestion_reportehistorial.php">Ir a Reporte Historial</a>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 AgroControl. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
