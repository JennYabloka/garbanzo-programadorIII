<?php /* EMPLEADOS */
include("conexion.php");

$correo = $_POST['correo'];
$clave  = $_POST['clave'];

$sql = "SELECT * FROM empleados WHERE CORREO = '$correo' LIMIT 1";
$res = mysqli_query($conexion, $sql);

if (mysqli_num_rows($res) > 0) {
    $empleado = mysqli_fetch_assoc($res);

    if ($empleado['CLAVE'] === $clave) {

        // Redirigir a la Pagina Principal
        echo "<script>
                alert('✅ ¡Bienvenido, nuestr@ fiel Emplead@ {$empleado['TURNO']}, {$empleado['NOMBRE']} {$empleado['APELLIDOS']}!');
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
            alert('❌ El Correo no está Registrado. Por Favor Contacte al Administrador.');
            window.history.back();
          </script>";
}

mysqli_close($conexion);

?>