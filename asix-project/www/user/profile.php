<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
if ($_POST) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];


    require_once("../s4f3/config.php");
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>Inicio de sesión</title>
    <style>
        table {
        margin: 0 auto;
    }
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        .dropbtn {
        background-color: #525252;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        font-family: Courier;
        
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
        font-family: Courier;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {background-color: #858585; color: white}

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
        display: block;
        }

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover .dropbtn {
        background-color: #303030;
        }

        #container {
            width: 350px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .btn {
            background-color: #337ab7;
            color: #fff;
            padding: 10px;
            border: 0;
            cursor: pointer;
            font-size: 16px;
        }
        body {
        margin: 0;
        font-family: Courier;
        }

        .topnav {
        overflow: hidden;
        background-color: #333;
        }

        .topnav a {
        float: right;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 20px;
        position: relative;
        left: -38%;
        }

        .topnav a:hover {
        background-color: #ddd;
        color: black;
        }

        .topnav a.active {
        background-color: #04AA6D;
        color: white;
        }
        .nav2 {
        overflow: hidden;
        background-color: black;
        }

.nav2 a {
  float: right;
  color: white;
  text-align: center;
  padding: 10px 16px;
  text-decoration: none;
  font-size: 17px;
  position: relative;
  left: -43%;
}

.nav2 a:hover {
  background-color: #ddd;
  color: black;
}

.nav2 a.active {
  background-color: black;
  color: white;
}

table {
  border: 1px;
  padding: 35px;
  text-align: center;
  color: white;
  width: 100%;
}
    </style>
</head>
<body style="background-color:grey">
<img src="/pictures/usb.png" title="safeUSB" alt="safeUSB" />

<div class="topnav">
  <a href="profile.php">My profile</a>
  <?php
  if (!isset($_SESSION['user'])) {
      echo '<a href="login.php">Log in</a>';
  } else {
      echo '<a href="logout.php">Log out</a>';
  }
  ?>
  <a href="../files/index2.php">Files</a>
  <a href="../index.php">About us</a>
</div>
<div class='dropdown'>
  <button class="dropbtn">Administrative Menu</button>
  <div class="dropdown-content">
  <?php
  if ($_SESSION['user'] == 2){
    echo "<a href='../admin/groups.php'>Groups</a>"; 
    echo "<a href='../admin/assignation.php'>USB Assignation</a> ";
    echo "<a href='../admin/seefiles.php'>View all the files</a>";
  }
  ?>
</div>
</div>
                    <?php
                    require_once("../s4f3/config.php"); 

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

    				// Check connection
    				if ($conn->connect_error) {
        				die("Connection failed: " . $conn->connect_error);
    				} 
				    
                    if (isset($_SESSION['user'])) {
                        $currentUser = $_SESSION['user'];
                
                        // Obtener la contraseña actual del usuario
                        $sql = "SELECT nombre FROM usuarios WHERE id_usu = '$currentUser'";
                        $result = $conn->query($sql);
                
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $currentUsername = $row['nombre'];
                        } else {
                            echo "No se encontró el usuario en la base de datos.";
                            exit;
                        }
                    }
    			?>
                <?php
                    require_once("../s4f3/config.php");

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

    				// Check connection
    				if ($conn->connect_error) {
        				die("Connection failed: " . $conn->connect_error);
    				} 
                    if (isset($_POST['submit'])) {
                        $newPassword = $_POST['new_password'];
                        $currentUser = $_SESSION['user'];
                
                        // Actualizar la contraseña del usuario en la base de datos
                        $sql = "UPDATE usuarios SET pass = '$newPassword' WHERE id_usu = '$currentUser'";
                        if ($conn->query($sql) === TRUE) {
                            echo "Contraseña actualizada correctamente.";
                        } else {
                            echo "Error al actualizar la contraseña: " . $conn->error;
                        }
                    }
                    if (isset($_SESSION['user'])) {
                        $currentUser = $_SESSION['user'];
                
                        // Obtener la contraseña actual del usuario
                        $sql = "SELECT pass FROM usuarios WHERE id_usu = '$currentUser'";
                        $result = $conn->query($sql);
                
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $currentPassword = $row['pass'];
                        } else {
                            echo "No se encontró el usuario en la base de datos.";
                            exit;
                        }
                    }
    			?>
                <?php	
                if ($_POST) {
                    $currentPassword = $_POST['current_password'];
                    $newPassword = $_POST['new_password'];
                
                    require_once("../s4f3/config.php");
                
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } 
                    
                    // Verificar la contraseña actual del usuario
                    $currentUser = $_SESSION['user'];
                    $verifyQuery = "SELECT pass FROM usuarios WHERE id_usu = '$currentUser'";
                    $result = $conn->query($verifyQuery);
                
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $currentPasswordDB = $row['pass'];
                        
                        // Verificar si la contraseña actual ingresada por el usuario coincide con la de la base de datos
                        if ($currentPassword === $currentPasswordDB) {
                            // Actualizar la contraseña del usuario en la base de datos
                            $updateQuery = "UPDATE usuarios SET pass = '$newPassword' WHERE id_usu = '$currentUser'";
                            
                            if (mysqli_query($conn, $updateQuery)) {
                                exit;
                            } else {
                                echo "<script> alert('Error changing the password.'); </script>" . $conn->error;
                            }
                        } else {
                            echo "<script> alert('Actual password is not valid. Please try again.'); </script>";
                        }
                    } else {
                        echo "<script> alert('The user do not exist.'); </script>";
                        exit;
                    }
                }
                ?>
<center>
<br>
    <br>
    <br>
    <div id="container" style="background-color:#555">
    <img src="/pictures/user.png" title="My Profile" alt="My Profile" width="60" height="60" class="center"/>
        <form method="POST" action="">
            <table>
            <h1 style="color:white">My profile</h1>
                <tr>
                <td><label for="username" style="color:white">Username:</label></td>
                <td> <?php echo $currentUsername; ?></td>
                </tr>
                <tr>
                    <td><label for="current_password">Current password:</label></td>
                    <td><input type="password" name="current_password" id="current_password" required></td>
                </tr>
                <tr>
                    <td><label for="new_password">New password:</label></td>
                    <td><input type="password" name="new_password" id="new_password" required></td>
                </tr>
                </table>
                <div class="form-group">
                <input type="submit" value="CHANGE PASSWORD" class="btn-default" />
            </div>
        </form>
    </div>                    
</body>
</html>