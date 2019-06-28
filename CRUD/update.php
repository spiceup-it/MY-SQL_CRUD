<?php

    require_once('includes/config.php');

    //declare and initialize variables
    $name = $address = $salary = "";
    $name_err = $address_err = $salary_err = "";


    if(isset($_POST["id"]) && !empty($_POST["id"])){

        //get hidden input value
        $id = $_POST["id"];

         //validate name
         $input_name = trim($_POST["name"]);
         if(empty($input_name)){
             $name_err = "Please enter a name.";
         }
         else{
             $name = $input_name;
         }
     
        //validate address
        $input_address = trim($_POST["address"]);
        if(empty($input_address)){
            $address_err = "Please enter an address.";
        }else{
            $address = $input_address;
        }
    
        //validate salary
        $input_salary = trim($_POST["salary"]);
        if(empty($input_salary)){
            $salary_err = "Please enter an salary.";
        }else{
            $salary = $input_salary;
        }

        //check input error before inserting in database
        if(empty($name_err) && empty($address_err) && empty($salary_err)){

            //prepare an update query
            $sql = "UPDATE Employees1 SET name = ?, address = ?, salary = ? WHERE id=?;";

            if($stmt = mysqli_prepare($conn,$sql)){

                mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);

                //set parameters
                $param_name = $name;
                $param_address = $address;
                $param_salary = $salary;
                $param_id = $id;

                //Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    //Records updated successfully then redirect to index.php
                        header("location: index.php");
                        exit();
                }
                else{
                    echo "Something went wrong. Please try again later";
                }

            }

            //close statement
            mysqli_stmt_close($stmt);
        }
        //close connection
        mysqli_close($conn);
        }
        else{
                if(isset($_GET["id"]) && !empty($_GET["id"])){
                    //Get id from the URL
                    $id = $_GET["id"];

                    //prepare an select query
                    $sql = "SELECT * FROM Employees1 WHERE id = ?;";

                    if($stmt = mysqli_prepare($conn,$sql)){

                        mysqli_stmt_bind_param($stmt, "i", $param_id);

                        //set parameters
                        $param_id = $id;

                        //Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){

                            $result = mysqli_stmt_get_result($stmt);

                            if(mysqli_num_rows($result) == 1){
                                //Fetch result row as an associative array.
                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                                //Retrive individual field value
                                $name = $row["name"];
                                $address = $row["address"];
                                $salary = $row["salary"];
                            }
                            else{
                                //URL doesn't contain valid id. Redirect to error page
                                header("location: error.php");
                                exit();
                            }

                        }
                        else{
                            echo "Something went wrong. Please try again later";
                        }
                }
                //close statement
                mysqli_stmt_close($stmt);

                //close connection
                mysqli_close($conn);
        }else {
            header("location: error.php");
            exit();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Update Record</title>
    <style> .wrapper{ width:500px; margin:0 auto;}</style>
</head>
<body>
<div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header text-center">
                        <h2>Update Record</h2>
                    </div>
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name;?>">
                            <span class="error"><?php echo $name_err ?></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?> </textarea>
                            <span class="error"><?php echo $address_err ?></span>
                        </div>
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary;?>">
                            <span class="error"><?php echo $salary_err ?></span>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $id;?>"/>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-default">Cancel</a>
                        </div>              
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>