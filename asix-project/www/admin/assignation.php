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
if ($_POST) {
    $usb = $_POST['usb'];
    $grupo = $_POST['grupo'];
    $user = $_POST['usuario'];


    require_once("../s4f3/config.php");
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $update = "UPDATE usb SET propietario='$user', grupo='$grupo' WHERE id_usb='$usb'";
    if (mysqli_query($conn, $update)){ 
            header('Location: groups.php');
            exit;
            echo "Register entered";
    }
    /*if (mysqli_query($conn, $update)){
            
    }
    */
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
tr:hover {background-color: black; color: white}
th {
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
      echo '<a href="../user/login.php">Log in</a>';
  } else {
      echo '<a href="../user/logout.php">Log out</a>';
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
    echo "<a href='groups.php'>Groups</a>"; 
    echo "<a href='assignation.php'>USB Assignation</a> ";
    echo "<a href='seefiles.php'>View all the files</a>";
  }
  ?>
</div>
</div>
<center>
<br>
    <br>
    <br>
    <div id="container" style="background-color:#555">
    <img src="/pictures/png.png" title="USB" alt="USB" width="60" height="60" class="center"/>
        <h1 style="color:white">USB Assignation</h1>
        <form method="post">
            <div class="form-group">
                <label for="username" style="color:white">USB</label>
                <select name="usb" id="usb" >
				<?php
                    require_once("../s4f3/config.php");

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

    				// Check connection
    				if ($conn->connect_error) {
        				die("Connection failed: " . $conn->connect_error); 
    				} 
				    $sql = "SELECT id_usb, nombre FROM usb WHERE propietario IS NULL OR grupo IS NULL";
    				$result = $conn->query($sql);
                    echo "<option value= 'NULL'>-------</option>";
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_usb"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value= 'NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
				</select>
            </div>
            <div class="form-group">
                <label for="username" style="color:white">Username</label>
                <select name="usuario" id="usuario" >
				<?php
                    require_once("../s4f3/config.php");

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

    				// Check connection
    				if ($conn->connect_error) {
        				die("Connection failed: " . $conn->connect_error);
    				} 
				    
    				$sql = "SELECT id_usu, nombre FROM usuarios";
    				$result = $conn->query($sql);
				    echo "<option value= 'NULL'>-------</option>";
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_usu"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value= 'NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
                </select>
                <div class="form-group">
                <label for="username" style="color:white">Group</label>
                <select name="grupo" id="grupo" >
				<?php
                    require_once("../s4f3/config.php");

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

    				// Check connection
    				if ($conn->connect_error) {
        				die("Connection failed: " . $conn->connect_error);
    				} 
				    
    				$sql = "SELECT id_gr, nombre FROM grupo";
    				$result = $conn->query($sql);
				    echo "<option value= 'NULL'>-------</option>";
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_gr"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value= 'NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
				</select>
            </div>
            <div class="form-group">
                <br>
                <input type="submit" value="ASSIGN" class="btn-default" />
            </div>
        </form>
    </div>                    
    <?php
require_once("../s4f3/config.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT id_usb, nombre, propietario, grupo FROM usb WHERE propietario IS NULL";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table style='margin: 0 auto; cellpadding: 25px; color: white'><tr><th>ID</th><th>Name</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["id_usb"]."</td><td>".$row["nombre"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>

</body>
</html>
