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
            <div class="d-flex justify-content-end">
                <a href="login.php">Logout</a>
            </div>
            <hr>
<form method="POST" action="addBooks.php">
    <div class="form-outline col-4 offset-4 mt-4">
        <input type="text" class="form-control" id="book" name="book" placeholder="Book" required/>
    </div>
    <div class="form-outline col-4 offset-4 mt-4">
        <input type="text" class="form-control" id="writer" name="writer" placeholder="Writer" required/>
    </div>
    <div class="form-outline col-4 offset-4 mt-4">
        <input type="text" class="form-control" id="about_book" name="about_book" placeholder="About book" required/>
    </div>
    <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-success col-2 mt-4" name="add_book">Add book</button>
    </div>
</form>
</div>

<?php
//povezivanje s bazom podataka
$conn = mysqli_connect("localhost","root","","library_db");
session_start();
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM members WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
  }
  else{
    header("Location: login.php");
  }

    if(mysqli_connect_errno())
    echo "Failed to connect to MySQL:" . mysqli_connect_error();
    //else
    //echo "Successfully connected to MySQL";

//sacuvaj podatke iz forme
if(isset($_POST['add_book'])){
$book = $_POST["book"];
$writer = $_POST["writer"];
$about_book = $_POST["about_book"];

//provjeravamo da li knjiga vec postoji u bazi
$duplicate_book = "SELECT book FROM books WHERE book = '$book'";
$result_book = mysqli_query($conn, $duplicate_book);
$duplicate_writer = "SELECT writer FROM books WHERE writer = '$writer'";
$result_writer = mysqli_query($conn, $duplicate_writer);
if(mysqli_num_rows($result_book) && mysqli_num_rows($result_writer) > 0){
  echo "<div class=\"alert alert-success alert-dismissible fade show text-center mt-4\" role=\"alert\">
  This book already exists.
  <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\">
  </button>
        </div>";
  exit();
}
else
//dodavanje knjiga u bazi
$sql = "INSERT INTO books(book, writer, about_book) VALUES ('$book', '$writer', '$about_book')";
$result = mysqli_query($conn, $sql);
 if($result){
  echo "<div class=\"alert alert-success alert-dismissible fade show text-center mt-4\" role=\"alert\">
  Book added successfully.
  <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\">
  </button>
        </div>";
   echo "<form method=\"POST\" action=\"books.php\">
         <div class=\"d-flex justify-content-center\">
           <button type=\"submit\" class=\"btn btn-success col-2 mt-4\">Go back to books page</button>
         </div>
       </form>";
 }
 else
 echo "<div class=\"alert alert-danger alert-dismissible fade show text-center mt-4\" role=\"alert\">
 Book isn't added to DB.
 <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\">
 </button>
       </div>"; ;
}

mysqli_close($conn);
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>