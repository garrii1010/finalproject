<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}

require_once("../s4f3/config.php");

$usuario = $_SESSION['user'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ID, nombre, direccion, MD5 FROM archivos WHERE usb IN (SELECT id_usb FROM usb WHERE propietario = (SELECT id_usu FROM usuarios WHERE id_usu = '$usuario'))";
$result = $conn->query($sql);
?>

<style>
        .btn {
            background-color: #525252;
            color: white;
            padding: 10px;
            border: 0;
            cursor: pointer;
            font-size: 16px;
        }
</style>

<html>
<head>
<center>
    <br>   
    <br>
    <input type="submit" value="CLOSE WINDOW"  class="btn"  onclick="closeWindow()">
<script>
  function closeWindow() {
    window.close(); // Close the current window or tab
  }
</script>
</center>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            font-family: Courier;
            background-color: grey;
        }
        
        table {
            border: 1px;
            padding: 35px;
            text-align: center;
            color: white;
            width: 100%;
        }
        
        th, td {
            border-bottom: 1px solid #ddd;
        }
        
        tr:hover {
            background-color: black;
            color: white;
        }
        
        th {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Name</th>
            <th>Download link</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["nombre"] . "</td><td><a href=" . $row["direccion"] . " download>Download</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No personal files found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
