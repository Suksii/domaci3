<?php
//povezivanje s bazom podataka i pocetak sesije
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
    $id = $_GET['id'];

  if(isset($_POST['edit'])){
    $book = $_POST['book'];
    $writer = $_POST['writer'];
    $about_book = $_POST['about_book'];
    
    $query_edit = "UPDATE books SET book = '$book', writer = '$writer', about_book = '$about_book' WHERE id = $id";
    $result = mysqli_query($conn, $query_edit);

    if($result)
    header("Location: books.php?msg=Edit done successfully");
    else
    echo "<h3 class=\"text-center\">Update error</h3>";
  }


?>

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
<?php
  if(isset($_GET['id']))
    $id = $_GET['id'];

    $query = "SELECT * FROM books WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    mysqli_close($conn);
?>
    <div class="container">
            <div class="d-flex justify-content-end">
                <a href="logout.php">Logout</a>
            </div>
            <form method="POST" action="editBook.php?id=<?php echo $id; ?>">   

            <div class="form-outline col-4 offset-4 mt-4">
                <input type="text" class="form-control" id="book" name="book" placeholder="Edit book" value="<?php echo $row['book'];?>" required/>
            </div>
            <div class="form-outline col-4 offset-4 mt-4">
                <input type="text" class="form-control" id="writer" name="writer" placeholder="Edit writer" value="<?php echo $row['writer'];?>" required/>
            </div>
            <div class="form-outline col-4 offset-4 mt-4">
                <input type="text" class="form-control" id="about_book" name="about_book" placeholder="Edit description" value="<?php echo $row['about_book'];?>" required/>
            </div>
            <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-success col-2 mt-4" id="edit" name="edit">Edit</button>
            </div>
            </form>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>