<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>
    <div class="container">
    <div class="d-flex justify-content-center">
      <h2>Registration</h2>
    </div>
    <form method="POST" action="register.php">

        <div class="form-outline col-4 offset-4 mt-4">
          <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Your First Name" required/>
        </div>

        <div class="form-outline col-4 offset-4 mt-4">
          <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Your Last Name" required/>
        </div>

        <div class="form-outline col-4 offset-4 mt-4">
          <input type="text" class="form-control" id="username" name="username" placeholder="Your username" required/>
        </div>

        <div class="form-outline col-4 offset-4 mt-4">
            <input type="email" class="form-control" id="email" name="email" placeholder="Your email" required/>
          </div>

        <div class="form-outline col-4 offset-4 mt-4">
          <input type="password" class="form-control" id="password" name="password" placeholder="Your password" required/>
        </div>

        <div class="d-flex justify-content-center">
          <button type="submit" name="register" class="btn btn-success col-2 mt-4">Register</button>
        </div>

        <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="http://localhost/domaci3/login.php" class="fw-bold text-body"><u>Login here</u></a></p>

      </form>

    </div>

    <?php

//povezivanje sa bazom podataka i pokretanje sesije
session_start();
$conn = mysqli_connect("localhost","root","","library_db");

if(!empty($_SESSION["id"])){
  header("Location: books.php");
}

if(mysqli_connect_errno())
  echo "Failed to connect to MySQL:" . mysqli_connect_error();

//else
//echo "Successfully connected to MySQL";

if(isset($_POST['register'])){
//sacuvaj podatke iz forme
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"]; 

//provjera da li username ili mail postoji u bazi podataka
$duplicate = "SELECT * FROM members WHERE username = '$username' or email = '$email'";
$result = mysqli_query($conn, $duplicate);


if(mysqli_num_rows($result) > 0)
echo "<div class=\"alert alert-warning alert-dismissible fade show text-center mt-4\" role=\"alert\">
Username or email are already taken.</h3>
<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\">
</button>
      </div>";

//dodavanje korisnika u bazu podataka
else{
$sql = "INSERT INTO members(first_name, last_name, username, email, password) VALUES ('$first_name', '$last_name', '$username', '$email', '$password')";

if(mysqli_query($conn, $sql)){
  header("Location: login.php");
  exit();
}
else
echo "Registration error : " . $sql . "<br>" . mysqli_error($conn);
}
}
//zatvaranje veze sa bazom podataka
mysqli_close($conn);

?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





