<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiemtra";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['submit-login'])){

    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);
  
    if($user == '' || $pass == ''){
      $messageError = 'Please check again !';
    }else{
      $sql = "SELECT * FROM `users` WHERE user='".$user."' AND passwordd='".$pass."'";
      $conn->query($sql);

      $result = $conn->query($sql);

      if(mysqli_num_rows($result) > 0){
        $_SESSION['user'] = $user;
        header('Location: index.php');
      }else{
        $messageError = 'Please check again !';
      }
      
      
    }

  }else if(isset($_POST['submit-logout'])){
    unset($_SESSION['user']);
    $messageSuccess = 'Log out success !';
  }
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
  if(isset($_SESSION['user'])){
    header('Location: index.php');
  }else{
    // header('Location: login.php');
  }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container my-2">

    <?php if(isset($messageError)) : ?>
      <div class="alert alert-danger">
        <?php echo $messageError; ?>
      </div>
    <?php endif ?>

    <?php if(isset($messageSuccess)) : ?>
      <div class="alert alert-success">
        <?php echo $messageSuccess; ?>
      </div>
    <?php endif ?>

    <form action="login.php" method="post">
      <div class="form-group row">
        <label class="control-label col-sm-3">User</label>
        <div class="col-sm-6">
          <input type="text" name="user" class="form-control" required>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-3">Password</label>
        <div class="col-sm-6">
          <input type="password" name="pass" class="form-control" required>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-sm-3"></label>
        <div class="col-sm-6">
          <input type="submit" name="submit-login" class="btn btn-success" value="Login">
        </div>
      </div>
    </form>    
  </div>

</body>
</html>