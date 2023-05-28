<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit;
}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Courier;
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
  width: 50%;
  left:0;
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

.dropbtn2 {
  background-color: #525252;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  font-family: Courier;
}

.dropdown2 {
  position: relative;
  display: inline-block;
  float:right;
  font-family: Courier;
}

/* Dropdown Content (Hidden by Default) */
.dropdown2-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown2-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown2-content a:hover {background-color: #858585; color: white}

/* Show the dropdown menu on hover */
.dropdown2:hover .dropdown2-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown2:hover .dropbtn2 {
  background-color: #303030;
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
th, td {
  border-bottom: 1px solid #ddd;
}
tr:hover {background-color: black; color: white}
th {
  background-color: black;
  color: white;
}
</style>
</head>
<body style="background-color:grey">
<img src="/pictures/usb.png" title="safeUSB" alt="safeUSB" />

<div class="topnav">
    <a href="../user/profile.php">My profile</a>
    <?php
  if (!isset($_SESSION['user'])) {
      echo '<a href="../user/login.php">Log in</a>';
  } else {
      echo '<a href="../user/logout.php">Log out</a>';
  }
  ?>
    <a href="index2.php">Files</a>
    <a href="../index.php">About us</a>
</div>

<div class='dropdown'>
  <button class="dropbtn">Administrative Menu</button>
  <div class="dropdown-content">
  <?php
  if (isset($_SESSION['user']) && $_SESSION['user'] == 2){
    echo "<a href='../admin/groups.php'>Groups</a>"; 
    echo "<a href='../admin/assignation.php'>USB Assignation</a> ";
    echo "<a href='../admin/seefiles.php'>View all the files</a>";
  }
  ?>
  </div>

</div>
<div class='dropdown2'>
  <button class="dropbtn2">Filter files</button>
  <div class="dropdown2-content">
    <a href="personalfiles.php" target="_blank">Personal Files</a>
    <a href="groupfiles.php" target="_blank">Group Files</a>
    <a href="groupfiles.php" target="_blank">Quarantine Files</a>
  </div>
  </div>
    <?php
    require_once("../s4f3/config.php");
    
    $usuario = $_SESSION['user'];
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $sql = "SELECT ID, nombre, direccion, MD5 FROM archivos WHERE usb IN (SELECT id_usb FROM usb WHERE propietario = (SELECT id_usu FROM usuarios WHERE id_usu = '$usuario')) OR usb IN (SELECT id_usb FROM usb WHERE grupo = (SELECT id_gr FROM ubic WHERE id_usu = '$usuario'))";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Name</th><th>Download link</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row["nombre"]."</td><td><a href='".$row["direccion"]."' download>Download</a></td><td>".$row["usb"]."</td><td><a href='".$row["report"]."' download>Download report</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</body>

</html>
