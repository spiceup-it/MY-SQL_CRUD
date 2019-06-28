<?php

//check of id parameter from index.php url
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    require_once("includes/config.php");

        //prepare the select statement
        $sql = "SELECT * FROM Employees1 where id = ?;";

        if($stmt = mysqli_prepare($conn,$sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_id);
        
                // Set parameters
                $param_id = trim($_GET["id"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
            
                    if(mysqli_num_rows($result) == 1){
                        /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        // Retrieve individual field value
                        $name = $row["name"];
                        $address = $row["address"];
                        $salary = $row["salary"];
                    } else{
                        // URL doesn't contain valid id parameter. Redirect to error page
                        header("location: error.php");
                        //echo "Sorry, you've made an invalid request. Please try again later";
                        exit();
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }            
            // Close statement
            mysqli_stmt_close($stmt);
            // Close connection
            mysqli_close($conn);
        } else{
            // URL doesn't contain id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>View Details</title>
</head>
<body>
<div class="container ml-5">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>View Details</h1>
                </div>
                <div class="card">
                <h5 class="card-header">Details</h5>
                <div class="card-body">
                    <h5 class="card-title"> <?php echo $row["name"]; ?></h5>
                    <p class="card-text">
                    <b>Address:</b> <?php echo $row["address"]; ?> <br> 
                    <b>Salary:</b> <?php echo $row["salary"];  ?>
                    </p>
                    <a href="index.php" class="btn btn-primary">Back</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>