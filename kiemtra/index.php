<?php

session_start();

$ignore = false;

if(isset($_SESSION['user'])){
  // header('Location: index.php');
}else{
  header('Location: login.php');
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kiemtra";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if($_SERVER["REQUEST_METHOD"] == "POST"){



  // add
  if(isset($_POST['submit-add'])){

    // echo "insert";

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // echo "INSERT INTO infos (namee, phone, email) VALUES ('".$name."', '".$phone."', '".$email."')";

    $sql = "INSERT INTO infos (namee, phone, email) VALUES ('".$name."', '".$phone."', '".$email."')";


    $conn->query($sql);

  }

  // delete
  if(isset($_POST['submit-delete'])){


    // $name = $_POST['name'];
    // $phone = $_POST['phone'];
    // $email = $_POST['email'];


    $sql = "DELETE FROM infos WHERE id=".$_POST['id'];

    $conn->query($sql);

  }

  // edit
  if(isset($_POST['submit-edit'])){

    // echo "edit";

    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // echo "INSERT INTO infos (namee, phone, email) VALUES ('".$name."', '".$phone."', '".$email."')";

    $sql = "UPDATE infos SET namee='".$name."' WHERE id=".$id;
    $conn->query($sql);

    $sql = "UPDATE infos SET phone='".$phone."' WHERE id=".$id;
    $conn->query($sql);

    $sql = "UPDATE infos SET email='".$email."' WHERE id=".$id;
    $conn->query($sql);



  }

}

if($_SERVER["REQUEST_METHOD"] == "GET"){

  // tim kiem
  if(isset($_GET['q'])){

    $q = $_GET['q'];

    $sql = "SELECT * FROM infos WHERE namee LIKE '". $q ."%' ORDER BY namee";
    $result = $conn->query($sql);

    $ignore = true;

  }

}

if(isset($ignore)){
  if($ignore == true){

  }else{
    $sql = "SELECT * FROM infos ORDER BY namee";
    $result = $conn->query($sql);
  }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Contact</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
    <h3 class="my-2 text-center">CONTACT</h3>

    <div class="text-right">
      <span>Welcome <?php echo $_SESSION['user']; ?></span>
      <a href="javascript:void(0)" class="btn btn-secondary btn-logout">
        <span>Log out</span>
        <form action="login.php" method="post" style="display: none;">

          <input type="hidden" name="submit-logout" value="x">
      
        </form>
      </a>
    </div>

    <a href="javascript:void(0)" class="btn btn-success btn-add my-2">

      <span>ADD</span>

      <div class="modal fade modal-add text-dark">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <form action="index.php" method="post">
                <div class="form-group row">
                  <label class="control-label col-sm-3">Name</label>
                  <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-sm-3">Phone</label>
                  <div class="col-sm-9">
                    <input type="text" name="phone" class="form-control" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-sm-3">Email</label>
                  <div class="col-sm-9">
                    <input type="text" name="email" class="form-control" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-sm-3"></label>
                  <div class="col-sm-9 text-left">
                  <input type="submit" name="submit-add" class="btn btn-success" value="ADD">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </a>

    <div class="my-2">
      <form action="index.php" method="get">
        <div class="form-group row justify-content-center">
            <div class="col-sm-8">
              <input type="text" name="q" class="form-control">
            </div>
            <div class="col-sm-auto">
              <input type="submit" name="submit-search" value="SEARCH" class="btn btn-success">
            </div>
        </div>
      </form>
    </div>

    <table id="tableData" class="table my-2">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th>First Letter</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>

      <?php if($result->num_rows > 0) : ?>
        <?php foreach($result as $row) : ?>

          <tr letter="<?php echo strtoupper(substr($row['namee'], 0, 1)); ?>">
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['namee']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><a href="javascript:void(0)" letter="<?php echo strtoupper(substr($row['namee'], 0, 1)); ?>" class="btn btn-dark btn-letter"><?php echo strtoupper(substr($row['namee'], 0, 1)); ?></a></td>
            <td>
              <a href="javascript:void(0)" class="btn btn-primary btn-edit">
                <span>Edit</span>
                <div class="modal fade modal-edit text-dark">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-body">
                        <form action="index.php" method="post">
                          <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                          <div class="form-group row">
                            <label class="control-label col-sm-3">Name</label>
                            <div class="col-sm-9">
                              <input type="text" name="name" value="<?php echo $row["namee"]; ?>" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-sm-3">Phone</label>
                            <div class="col-sm-9">
                              <input type="text" name="phone" value="<?php echo $row["phone"]; ?>" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-sm-3">Email</label>
                            <div class="col-sm-9">
                              <input type="text" name="email" value="<?php echo $row["email"]; ?>" class="form-control" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-sm-3"></label>
                            <div class="col-sm-9 text-left">
                            <input type="submit" name="submit-edit" class="btn btn-success" value="UPDATE">
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </a>

              <a href="javascript:void(0)" class="btn btn-danger btn-delete">
                <span>Remove</span>
                <form action="" method="post" style="display: none;">
                  <input type="hidden" name="submit-delete" value="s">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                </form>
              </a>
            </td>
          </tr>

        <?php endforeach ?>
      <?php endif ?>

      </tbody>
    </table>


    <script>

      var arrData = [

        <?php foreach ($result as $row) {
          echo '{id :'.$row['id'].', name: "'.$row['namee'].'", phone: "'.$row['phone'].'", email: "'.$row['email'].'"}, ';
        } ?>

      ];
    
      $(document).ready(function(){
        $('.btn-add').click(function(){
          $(this).find('.modal-add').modal();
        }); 
      });
      
      $(document).ready(function(){
        $('.btn-delete').click(function(){
          $(this).find('form').submit();
        }); 
      });

      $(document).ready(function(){
        $('.btn-edit').click(function(){
          $(this).find('.modal-edit').modal();
        }); 
      });

      $(document).ready(function(){
        $('.btn-logout').click(function(){
          $(this).find('form').submit();
        }); 
      });

      $(document).ready(function(){
        $('.btn-letter').click(function(){
          let letter = $(this).attr('letter');
          $(this).parents('tbody').find('tr:not([letter="'+letter+'"])').remove();
        }); 
      });

    </script>

  </div>
</body>
</html>