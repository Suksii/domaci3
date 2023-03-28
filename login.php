<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">

    <h2 class="text-center mt-4 mb-4">LOGIN</h2>

    <form method="POST" action="login.php">
        <div class="row col-4 offset-4 mt-5">
            <input type="text" name="username" class="form-control" placeholder="Your username" required>
        </div>
        <div class="row col-4 offset-4 mt-2">
            <input type="password" name="password" class="form-control" placeholder="Your password" required>
        </div>
        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-success col-2 mt-4" name="login">Login</button>
        </div>
        <p class="text-center text-muted mt-5 mb-0">Haven't registered yet? <a href="register.php" class="fw-bold text-body"><u>Register</u></a></p>
    </form>
    </div>

    <?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "library_db");

    if(!empty($_SESSION["id"])){
        header("Location: index.php");
      }

    if(mysqli_connect_errno())
    echo "Failed to connect to MySQL:" . mysqli_connect_error();
    //else
    //echo "Successfully connected to MySQL";
if(isset($_POST['login'])){
$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM members WHERE username = '$username' and password = '$password'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(mysqli_num_rows($result) == 1){
if($password == $row['password']){
    $_SESSION["login"] = true;
    $_SESSION["id"] = $row["id"];
    header("Location: books.php");
}
else{
  echo "<h3 class=\"text-center\">Wrong password.</h3>";
}
}
else
echo "<div class=\"alert alert-danger alert-dismissible fade show text-center mt-4\" role=\"alert\">
Wrong username or password
<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\">
</button>
      </div>";
}
mysqli_close($conn);
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
