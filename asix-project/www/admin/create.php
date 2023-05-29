<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['user'] != 2) {
    header('Location: index.php');
    exit;
}
$error = '';

if ($_POST) {
    $userxd = $_SESSION['user']; // Usar el número de sesión del usuario actual como variable
    $grupo = $_POST['grupo'];

    require_once("../s4f3/config.php");
    
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Verificar la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $query = "SELECT nombre FROM grupo WHERE nombre = '$grupo'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
	    echo "<script> alert('This group name is already in use, please select another'); </script>";
    } else {
        $insert = "INSERT INTO grupo (nombre, propietario) VALUES ('$grupo', '$userxd')";
	    if (mysqli_query($conn, $insert)){
            $query = "SELECT id_gr FROM grupo WHERE nombre = '$grupo' AND propietario = '$userxd'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $fin = $row['id_gr'];
            $insert = "INSERT INTO ubic (id_gr, id_usu) VALUES ('$fin', '$userxd')";
            if (mysqli_query($conn, $insert)){
                header('Location: groups.php');
                exit;
                echo "Registered correctly";
            }
        }
    }

    mysqli_close($conn);
}
?>
