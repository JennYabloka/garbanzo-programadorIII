<?php /* PROVEEDORES */
// Conexión a la Base de Datos
include("conexion.php");

// Captura de datos desde formulario
$empresa        = $_POST['empresa'];
$nombre         = $_POST['nombre'];
$apellidos      = $_POST['apellido'];
$tipo_documento = $_POST['tipo_documento'];
$no_documento   = $_POST['no_documento'];
$correo         = $_POST['correo'];
$clave          = $_POST['clave'];
$celular        = $_POST['celular'];
$direccion      = $_POST['direccion'];
$telefono       = $_POST['telefono'];
$codigoPostal   = $_POST['codigo_postal'];

// =======================
// Mapeo de documentos largos a siglas
// =======================
$documentos_map = [
    "Cédula de Ciudadanía (CC)" => "CC",
    "Tarjeta de Identidad (TI)" => "TI",
    "Cédula de Extranjería (CE)" => "CE",
    "Registro Civil (RC)" => "RC",
    "Permiso Especial de Permanencia (PEP)" => "PEP",
    "NIT (Número de Identificación Tributaria)" => "NIT",
    "Pasaporte (PA)" => "PA"
];

// Si el documento no está en el mapa, lo dejamos igual (Para curarnos en salud)
if (isset($documentos_map[$tipo_documento])) {
    $tipo_documento = $documentos_map[$tipo_documento];
}

// =======================
// Verificar si el cliente ya existe (Por correo o documento, pss se suponen que son irrepetibles)
// =======================
$sql_check = "SELECT * FROM clientes 
              WHERE CORREO = '$correo' 
              OR (TIPO_DOCUMENTO = '$tipo_documento' AND NO_DOCUMENTO = '$no_documento')
              LIMIT 1";

$res_check = mysqli_query($conexion, $sql_check);

if (mysqli_num_rows($res_check) > 0) {
    echo "<script>
            alert('❌ El Usuario ya está Registrado con ese Correo o con ese Documento.');
            window.history.back();
          </script>";
    exit();
}

// =======================
// Query de inserción de los datos de la Empresa y el Proveedor
// =======================
$sql = "INSERT INTO proveedores (EMPRESA, NOMBRE, APELLIDOS, TIPO_DOCUMENTO, NO_DOCUMENTO, CORREO, CLAVE, CELULAR, DIRECCION, TELEFONO, CODIGO_POSTAL)
                         VALUES ('$empresa', '$nombre', '$apellidos', '$tipo_documento', '$no_documento', '$correo', '$clave', '$celular', '$direccion', '$telefono', '$codigoPostal')";

// Ejecutar (Con JS para que se vea más bonito)
if (mysqli_query($conexion, $sql)) {
    echo "<script>
            alert('✅ Proveedor Registrado Exitosamente.');
            window.location.href = '../form_proveedores.html';
          </script>"; // El "window.location.href" hace que el formulario quede vacio más facil y rápido
} else {
    echo "<script>
            alert('❌ Error al Registrar: " . mysqli_error($conexion) . "');
            window.history.back(); 
          </script>";
}

mysqli_close($conexion);

?>