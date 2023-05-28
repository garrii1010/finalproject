<?php
session_start();

$username = '';
$error = '';
if ($_POST) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    require_once("../s4f3/config.php");
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Use prepared statements to prevent SQL injection
    $query = "SELECT id_usu FROM usuarios WHERE nombre = ? AND pass = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['id_usu'];
        
        if ($_SESSION['user'] == 2) {
            header('Location: ../index.php');
            exit;
        } else {
            header('Location: ../files/index2.php');
            exit;
        }   
    } else {
        $error = 'Incorrect username or password.';
        echo "<script> alert('Incorrect username or password'); </script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: Courier;
            background-color: black;
        }
        #container {
            width: 350px;
            margin: 0 auto;
            background-color: #333;
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
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 20%;
}



input[type=text]:focus {
    border: 3px solid #555; 
}
input[type=password]:focus {
    border: 3px solid #555;
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
  if (isset($_SESSION['user']) && $_SESSION['user'] == 2){
    echo "<a href='../admin/groups.php'>Groups</a>"; 
    echo "<a href='../admin/assignation.php'>USB Assignation</a> ";
    echo "<a href='../admin/seefiles.php'>View all the files</a>";
  }
?>
</div>
</div>
    <br>
    <br>
    <br>
    <div id="container">
    <img src="/pictures/user.png" title="User" alt="User" width="60" height="60" class="center"/>
        <h2 style="color:white;text-align:center">LOG IN</h2>
        <form method="post">
            <div class="form-group" style="text-align: center">
                <label for="username" style="color:white">Username</label>
                <input type="text" name="username" id="username" style="text-align: center" />
            </div>
            <div class="form-group" style="text-align: center">
                <label for="password" style="color:white">Password</label>
                <input type="password" name="password" id="password" style="text-align: center" />
            </div>
            <div class="form-group">
                <input type="submit" value="LOG IN" class="btn-default" />
            </div>
        </form>
        <center>
         <a style="text-align: center; color: white" href="signin.php">Are you new? Sign in</a> 
    </div>
</body>
</html>
