<?php /* CLIENTES */
include("conexion.php");

$correo = $_POST['correo'];
$clave  = $_POST['clave'];

// Primero verificamos si el correo existe
$sql = "SELECT * FROM clientes WHERE CORREO = '$correo' LIMIT 1";
$res = mysqli_query($conexion, $sql);

if (mysqli_num_rows($res) > 0) {
    $cliente = mysqli_fetch_assoc($res);

    if ($cliente['CLAVE'] === $clave) {

        // Redirigir a la Pagina Principal
        echo "<script>
                alert('✅ ¡Bienvenido, nuestr@ Cliente Frecuente {$cliente['NOMBRE']} {$cliente['APELLIDOS']}!');
                window.location.href = '../index.html';
              </script>";
    } else {
        echo "<script>
                alert('❌ Contraseña Incorrecta.');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('❌ El Correo no está Registrado. Por Favor Regístrate.');
            window.history.back();
          </script>";
}

mysqli_close($conexion);

?>