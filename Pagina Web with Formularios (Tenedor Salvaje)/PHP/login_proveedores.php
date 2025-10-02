<?php /* PROVEEDORES */
include("conexion.php");

$correo  = $_POST['correo'];
$clave   = $_POST['clave'];
$empresa = $_POST['empresa'];

$sql = "SELECT * FROM proveedores WHERE CORREO = '$correo' LIMIT 1";
$res = mysqli_query($conexion, $sql);

if (mysqli_num_rows($res) > 0) {
    $proveedor = mysqli_fetch_assoc($res);

    if ($proveedor['EMPRESA'] !== $empresa) {
        echo "<script>
                alert('❌ La Empresa no Coincide con el Correo Proporcionado.');
                window.history.back();
              </script>";
    } elseif ($proveedor['CLAVE'] !== $clave) {
        echo "<script>
                alert('❌ Contraseña Incorrecta.');
                window.history.back();
              </script>";
    } else {

        // Redirigir a la Pagina Principal
        echo "<script>
                alert('✅ ¡Bienvenido, nuestr@ leal Proveedor {$proveedor['NOMBRE']} {$proveedor['APELLIDOS']} de la empresa {$proveedor['EMPRESA']}!');
                window.location.href = '../index.html';
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