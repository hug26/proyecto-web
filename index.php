<?php
include 'conexion.php';

// Operaciones (Agregar/Eliminar)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $n = $_POST['nombre']; $p = $_POST['precio']; $s = $_POST['stock'];
    $conn->query("INSERT INTO productos (nombre, precio, stock) VALUES ('$n', '$p', '$s')");
    header("Location: index.php"); exit();
}
if (isset($_GET['eliminar'])) {
    $conn->query("DELETE FROM productos WHERE id = " . $_GET['eliminar']);
    header("Location: index.php"); exit();
}
$res = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pizzería Express | Pedidos Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root { --main: #e63946; --dark: #1d3557; --light: #f1faee; }
        body { font-family: 'Roboto', sans-serif; background: #0a0a0a; color: white; margin: 0; }
        
        /* Banner tipo Domino's */
        .hero { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1513104890138-7c749659a591?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; padding: 60px 20px; text-align: center; }
        .hero h1 { font-family: 'Montserrat'; font-size: 3rem; margin: 0; color: var(--main); }
        
        .container { max-width: 1000px; margin: -50px auto 50px; padding: 20px; }
        
        /* Tarjetas de Producto */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .product-card { background: #1a1a1a; padding: 20px; border-radius: 20px; border: 2px solid #333; transition: 0.3s; }
        .product-card:hover { border-color: var(--main); transform: translateY(-10px); }
        
        .btn-add { background: var(--main); color: white; border: none; padding: 12px 20px; border-radius: 30px; cursor: pointer; width: 100%; font-weight: bold; }
        .btn-del { color: #ff4757; font-size: 0.8rem; cursor: pointer; border: none; background: none; }
    </style>
</head>
<body>

<div class="hero">
    <h1>PIZZERÍA EXPRESS</h1>
    <p>La mejor calidad hasta tu puerta.</p>
</div>

<div class="container">
    <!-- Formulario Premium -->
    <div style="background: white; color: black; padding: 20px; border-radius: 15px; margin-bottom: 40px;">
        <h3 style="margin-top:0">Añadir al Menú</h3>
        <form method="POST" style="display:flex; gap:10px;">
            <input type="text" name="nombre" placeholder="Nombre de la pizza" style="flex:2; padding:10px;">
            <input type="number" step="0.01" name="precio" placeholder="Precio" style="flex:1; padding:10px;">
            <input type="number" name="stock" placeholder="Stock" style="flex:1; padding:10px;">
            <button type="submit" name="agregar" class="btn-add">AGREGAR</button>
        </form>
    </div>

    <!-- Catálogo -->
    <div class="menu-grid">
        <?php while($row = $res->fetch_assoc()): ?>
        <div class="product-card">
            <h3 style="color:var(--main);"><?php echo $row['nombre']; ?></h3>
            <p>Precio: <b>$<?php echo number_format($row['precio'], 2); ?></b></p>
            <p>Disponibilidad: <?php echo $row['stock']; ?> unidades</p>
            <a href="index.php?eliminar=<?php echo $row['id']; ?>" class="btn-del">❌ Quitar del menú</a>
        </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>