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

if(isset($_POST['form1'])) {
  echo "<script> alert('Username or password incorrect'); </script>";
}

if(isset($_POST['form2'])) {
  // Aquí va el código para el formulario 2
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
body {
            font-family: Courier;
            background-color: #f3f3f3;
        }
        /* #formulario1 {
            width: 350px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        } */
		#formulario2 {
            width: 350px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
		#formulario1 {
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
        .btn.drp {
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

        .dropdrp {
        background-color: #525252;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        
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
body {
  font-family: Courier;
}
/*
h1 {
  text-align: center;
}
*/
#botones {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

button.oscar {
  padding: 10px 20px;
  font-size: 18px;
  border-radius: 5px;
  border: none;
  background-color: white;
  color: black;
  cursor: pointer;
  margin: 0 90px;
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
  <button class="dropdrp">Administrative Menu</button>
  <div class="dropdown-content">
  <?php
  if (isset($_SESSION['user']) && $_SESSION['user'] == 2){
    echo "<a href='groups.php'>Groups</a>"; 
    echo "<a href='assignation.php'>USB Assignation</a> ";
    echo "<a href='seefiles.php'>View all the files</a>";
  }
  ?>
</div>
</div>
<br>
<br>
    <div id="botones">
      <button class="oscar" id="boton1">Add Group</button>
      <button  class="oscar" id="boton2">Add user to an existing group</button>
    </div>
    <center>
    <div id="formulario1" style="display: none;">
	    <form action="create.php" method="post" name="form1" id="form1" style="background-color:#555">
      <img src="/pictures/group.png" title="Group" alt="Group" width="60" height="60" class="center"/>
            <div class="form-group" style="text-align: center">
                <label for="username" style="color:white">Group Name</label>
                <input type="text" name="grupo" id="grupo" style="text-align: center"/>
            </div>
            <div class="form-group" style="text-align: center">
                <label for="username" style="color:white">Owner</label>
        <select name="username" id="username" >
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
				    
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_usu"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value='NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
          </select>
                
            </div>
            <div class="form-group">
                <input type="submit" value="NEW GROUP" class="btn-default" />
            </div>
        </form>
    </div>
          <div id="formulario2" style="display: none;">
	<form action="addgr.php" method="post" name="form2" id="form2" style="background-color:#555">
  <img src="/pictures/group.png" title="Group" alt="Group" width="60" height="60" class="center"/>
            <div class="form-group">
                <label for="username" style="color:white">Group Name</label>
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
				    
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_gr"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value='NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
				</select>
            </div>
            <div class="form-group">
                <label for="usuario" style="color:white">Username</label>
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
				    
    				if ($result->num_rows > 0) {
        				while($row = $result->fetch_assoc()) {
							echo "<option value=".$row["id_usu"].">".$row["nombre"]."</option>";
        				}
    				} else {
        				echo "<option value='NULL'>-------</option>";
    				}
    				$conn->close();
    			?>
          </select>
            </div>
            <div class="form-group">
                <input type="submit" value="INSERT" class="btn-default" />
            </div>
        </form>
        </center>
    <script type="text/javascript">
      var boton1 = document.getElementById("boton1");
      var boton2 = document.getElementById("boton2");
      var formulario1 = document.getElementById("formulario1");
      var formulario2 = document.getElementById("formulario2");

      boton1.addEventListener("click", function() {
        formulario1.style.display = "block";
        formulario2.style.display = "none";
      });

      boton2.addEventListener("click", function() {
        formulario1.style.display = "none";
        formulario2.style.display = "block";
      });
    </script>
</body>
</html>
