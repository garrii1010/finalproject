<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
.topnav {
  overflow: hidden;
  background-color: #333;
  width: 100%;
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
</style>
</head>
<body style="background-color:grey">
<img src="/pictures/usb.png" title="safeUSB" alt="safeUSB" />

<div class="topnav">
  <a href="user/profile.php">My profile</a>
  <?php
  if (!isset($_SESSION['user'])) {
      echo '<a href="user/login.php">Log in</a>';
  } else {
      echo '<a href="user/logout.php">Log out</a>';
  }
  ?>
  <a href="files/index2.php">Files</a>
  <a href="index.php">About us</a>
</div>
<div class='dropdown'>
  <button class="dropbtn">Administrative Menu</button>
  <div class="dropdown-content">
<?php
  if (isset($_SESSION['user']) && $_SESSION['user'] == 2){
    echo "<a href='admin/groups.php'>Groups</a>"; 
    echo "<a href='admin/assignation.php'>USB Assignation</a> ";
    echo "<a href='admin/seefiles.php'>View all the files</a>";
  }
?>
</div>
</div>
<div style="text-align:center">
<big><h1 style="color:white; text-align: center">Keep your USB safe.</h1></big>
  <h3 style="color:white">Tired of employees with bad cyber-security practices? Don't worry, we got you! Try us.</h3>
</div>
<br>
<br>
<br>
<br>
<div style="text-align: center">
  <big><h1 style="color:white">How it works?</h1></big>
  <h3 style="color:white">Just plug your USB into the machine and it will start the scan.</h3>
</div>
</body>
</html>
