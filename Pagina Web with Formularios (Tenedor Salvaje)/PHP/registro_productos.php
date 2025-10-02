<?php /* PRODUCTOS */
// Conexión a la Base de Datos
include("conexion.php");

// Captura de datos desde formulario
$nombre     = $_POST['producto'];
$desc       = !empty($_POST['descripcion']) ? $_POST['descripcion'] : "-"; // Si viene vacío → "-"
$precio     = $_POST['precio'];
$categoria  = $_POST['categoria'];  // Desde el formulario viene con el dato "DESCRIPCION" de la tabla de "categorias"
$proveedor  = $_POST['proveedor'];  // Desde el formulario viene con el dato "EMPRESA" de la tabla de "proveedores"
$gramaje    = $_POST['gramos'];
$calorias   = $_POST['calorias'];
$veg_ano    = $_POST['veg_ano'];
$picor      = $_POST['picor'];
$azucar     = $_POST['azucar'];

// =======================
// Mapeo de PICOR, de emojis a números
// =======================
$picor_map = [
    "🚫" => 0,
    "🔥" => 1,
    "🔥🔥" => 2,
    "🔥🔥🔥" => 3,
    "🔥🔥🔥🔥" => 4,
    "🔥🔥🔥🔥🔥" => 5,
];
// Si el picor seleccionado no está en el mapa, lo dejamos igual (Para curarnos en salud)
if (isset($picor_map[$picor])) {
    $picor = $picor_map[$picor];
}

// =======================
// Mapeo de AZÚCAR, de texto a números
// =======================
$azucar_map = [
    "Alto en Azúcar"   => 3,
    "Azúcar Moderada"  => 2,
    "Bajo en Azúcar"   => 1,
    "Sin Azúcar"       => 0,
];
// Si el nivel de azucar seleccionado no está en el mapa, lo dejamos igual (Para curarnos en salud)
if (isset($azucar_map[$azucar])) {
    $azucar = $azucar_map[$azucar];
}

// =======================
// Manejo/Inserción de la imagen en la carpeta "Comida" del "IMG" y la ruta en la BD
// =======================
$directorio = "../IMG/Comida/";
$archivoDestino = $directorio . basename($_FILES["imagenProducto"]["name"]);
$rutaBD = "IMG/Comida/" . basename($_FILES["imagenProducto"]["name"]); // ruta que va en la BD

if (!move_uploaded_file($_FILES["imagenProducto"]["tmp_name"], $archivoDestino)) {
    echo "<script>
            alert('❌ Error al Subir la Imagen.');
            window.history.back();
          </script>";
    exit();
}

// =======================
// Manejo del ID del Proveedor
// =======================
$sql_prov = "SELECT ID_PROVEEDOR FROM proveedores WHERE EMPRESA = '$proveedor' LIMIT 1";
$res_prov = mysqli_query($conexion, $sql_prov);
if ($row = mysqli_fetch_assoc($res_prov)) {
    $id_proveedor = $row['ID_PROVEEDOR'];
} else {
    echo "<script>
            alert('❌ El Proveedor Seleccionado No Existe.');
            window.history.back();
          </script>";
    exit();
}

// =======================
// Manejo del ID de la Categoria
// =======================
$sql_cat = "SELECT ID_CATEGORIA FROM categorias WHERE DESCRIPCION = '$categoria' LIMIT 1";
$res_cat = mysqli_query($conexion, $sql_cat);
if ($row = mysqli_fetch_assoc($res_cat)) {
    $id_categoria = $row['ID_CATEGORIA'];
} else {
    echo "<script>
            alert('❌ La Categoría Seleccionada No Existe.');
            window.history.back();
          </script>";
    exit();
}

// =======================
// Verificar si el producto ya existe (Por nombre)
// =======================
$sql_check = "SELECT * FROM productos 
              WHERE NOMBRE = '$nombre' 
              LIMIT 1";
$res_check = mysqli_query($conexion, $sql_check);

if (mysqli_num_rows($res_check) > 0) {
    echo "<script>
            alert('❌ El Producto ya está Registrado.');
            window.history.back();
          </script>";
    exit();
}

// =======================
// Query de inserción del Producto
// =======================
$sql = "INSERT INTO productos 
        (NOMBRE, DESCRIPCION, PRECIO, IMAGEN, PESO_PORCION, CALORIAS, VEG_ANO, PICOR, AZUCAR, ID_PROVEEDOR, ID_CATEGORIA)
        VALUES 
        ('$nombre', '$desc', '$precio', '$rutaBD', '$gramaje', '$calorias', '$veg_ano', '$picor', '$azucar', '$id_proveedor', '$id_categoria')";

// Ejecutar (Con JS para que se vea más bonito)
if (mysqli_query($conexion, $sql)) {
    echo "<script>
            alert('✅ Producto Registrado Exitosamente.');
            window.location.href = '../form_productos.html';
          </script>";
} else {
    echo "<script>
            alert('❌ Error al Registrar: " . mysqli_error($conexion) . "');
            window.history.back(); 
          </script>";
}

mysqli_close($conexion);
?>