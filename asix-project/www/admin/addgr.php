<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}
if ($_SESSION['user'] != 2) {
    header('Location: ../index.php');
    exit;
}
$error = '';

if ($_POST) {
    $codigoUsuario = $_POST['usuario'];
    $grupo = $_POST['grupo'];

    require_once("../s4f3/config.php");
    
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $query = "SELECT id_gr, id_usu FROM ubic WHERE id_gr = '$grupo' AND id_usu = '$codigoUsuario'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script> alert('This user is already in the group'); </script>";
    } else {
        $insert = "INSERT INTO ubic (id_gr, id_usu) VALUES ('$grupo', '$codigoUsuario')";
        if (mysqli_query($conn, $insert)){ 
            mysqli_close($conn);
            header('Location: ../index.php');
            exit;
        }
    }

    mysqli_close($conn);
}
?>