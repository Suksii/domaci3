<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<div class="container mt-4 mb-4" >
<div class="d-flex justify-content-end">
                <a href="logout.php">Logout</a>
            </div>
            <hr>
<nav class="navbar navbar-light bg-light">
            <form method="GET" class="form-inline">
            <div class="row">
                <div class="col-4">
                    <input name="term" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"value="<?php if(isset($_GET['term'])) echo $_GET['term']; ?>">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Search</button>
                </div>
                <div class="col-4">
                    <select name="sort" class="form-control mr-sm-2">
                        <option value="a-z" <?php if(isset($_GET['sort']) && $_GET['sort'] == "a-z"){echo "selected";} ?> >A-Z</option>
                        <option value="z-a" <?php if(isset($_GET['sort']) && $_GET['sort'] == "z-a"){echo "selected";} ?> >Z-A</option>
                    </select>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Sort</button>
                </div>

            </form>
        </nav>
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

     if(isset($_POST['delete'])){

        $id = $_POST['id'];
        $query_delete = "DELETE FROM books where id = '$id'";
        $result_delete = mysqli_query($conn, $query_delete);
      }

    //   $sort = "";
    //   if(isset($_GET['sort'])){
    //   if($_GET['sort'] == "a-z")
    //   $sort_option = "ASC";
    // elseif($_GET['sort'] == "z-a")
    //   $sort_option = "DESC";
    //   $query_sort = "SELECT * FROM books ORDER BY book $sort_option";
    //   $result_sort = mysqli_query($conn, $query_sort);
    //   }
    //ako postoji upis u search
     if (isset($_GET["term"])) {
         $term = $_GET["term"];

         $query_search = "SELECT * FROM books where CONCAT(book, writer)  like '%$term%'";
         $result_search = mysqli_query($conn, $query_search);
      
         if (mysqli_num_rows($result_search) > 0){
             echo "<table class=\"table table-bordered text-center\">";
             echo "<thead class=\"table-active\">
                   <tr>
                     <th>id</th>
                     <th>Book</th>
                     <th>Writer</th>
                     <th>About Book</th>
                     <th>Available</th>
                     <th>Edit</th>
                     <th>Delete</th>
                   </tr>
                  </thead>";
             while($row = mysqli_fetch_assoc($result_search)){
                 echo "<tr>
                         <td>" . $row["id"] . "</td>
                         <td>" . $row["book"] . "</td>
                         <td>" . $row["writer"] . "</td>
                         <td>" . $row["about_book"] . "</td>
                         <td><div><input type=\"radio\" class=\"form-check-input\" name=\"available" . $row['id'] . "\" value=\"available\" echo checked>
                         <label for=\"available\" class=\"form-input-label\">Available</label></div>
                         <div><input type=\"radio\" class=\"form-check-input\" name=\"available" . $row['id'] . "\" value=\"unavailable\">
                         <label for=\"available\" class=\"form-input-label\">Unavailable</label></div></td>
                         <td><a class=\"btn btn-warning\" href=\"editBook.php?id=" . $row['id'] . "\">Edit</a></td>
                         <td><form method=\"POST\" action=\"books.php\">
                         <input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">
                         <button type=\"submit\" name=\"delete\" class=\"btn btn-danger\">Delete</button>
                         </form></td>
                       </tr>";
             }
             echo "</table>";

             while($row = mysqli_fetch_assoc($result_search)){
                $available = $_POST['available'.$row['id']];

                $sql = "UPDATE books SET availability='$available' WHERE id=" . $row['id'];
                mysqli_query($conn, $sql);
            }
         }
        }
         //ako ne postoji upis u search
     else{
         $sql = "SELECT * FROM books";
         $result = mysqli_query($conn, $sql);
     
     if(mysqli_num_rows($result) > 0){
         echo "<table class=\"table table-bordered text-center\">";
         echo "<thead class=\"table-active\">
               <tr>
                <th>id</th>
                <th>Book</th>
                <th>Writer</th>
                <th>About Book</th>
                <th>Available</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
              </thead>";
         while($row = mysqli_fetch_assoc($result)){
            echo "<tr>
                     <td>" . $row["id"] . "</td>
                     <td>" . $row["book"] . "</td>
                     <td>" . $row["writer"] . "</td>
                     <td>" . $row["about_book"] . "</td>
                     <td><div><input type=\"radio\" class=\"form-check-input\" name=\"available" . $row['id'] . "\" value=\"available\" checked>
                         <label for=\"available\" class=\"form-input-label\">Available</label></div>
                         <div><input type=\"radio\" class=\"form-check-input\" name=\"available" . $row['id'] . "\" value=\"unavailable\">
                         <label for=\"available\" class=\"form-input-label\">Unavailable</label></div></td>
                     <td><a class=\"btn btn-warning\" href=\"editBook.php?id=" . $row['id'] . "\">Edit</a></td>
                     <td><form method=\"POST\" action=\"books.php\">
                     <input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\">
                     <button type=\"submit\" name=\"delete\" class=\"btn btn-danger\">Delete</button>
                     </form></td>
                  </tr>";   
        }
        echo "</table>";

        while($row = mysqli_fetch_assoc($result)){
                $available = $_POST['available'.$row['id']];
                $availability = $row['availability'];
                $checked_available = '';
                $checked_unavailable = '';
            
                if ($availability == 'available')
                    $checked_available = 'checked';
                else
                    $checked_unavailable = 'checked';
                

            $sql = "UPDATE books SET book_available ='$available' WHERE id=" . $row['id'];
            mysqli_query($conn, $sql);
        }
    
    }
    else
    echo "<h2 class=\"text-center\">No books added</h2>";
     
}

echo "<form method=\"POST\" action=\"addBooks.php\">
<div class=\"d-flex justify-content-center\">
    <button type=\"submit\" class=\"btn btn-success mt-4 mb-4\">Add book</button>
</div>
</form>";

if(isset($_GET['msg'])){
    $msg = $_GET['msg'];
    echo "<div class=\"alert alert-warning alert-dismissible fade show text-center\" role=\"alert\">
    $msg
    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\">
    </button>
          </div>"; }
    mysqli_close($conn);

    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</script>
</body>
</html>