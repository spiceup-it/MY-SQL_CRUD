<?php

    require_once('includes/config.php');

    //Define varables and initialize with empty values
    $name = $address = $salary = "";
    $name_err = $address_err = $salary_err = "";

    //processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
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

    //check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){

        $sql="INSERT INTO Employees1(name, address, salary) VALUES (?,?,?)";

        if($stmt = mysqli_prepare($conn,$sql)){
            mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_address, $param_salary);

            //set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;

            //Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            }else{
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Create Record</title>
</head>
<style> .wrapper{ width:500px; margin:0 auto;}</style>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header text-center">
                        <h2>Create Record</h2>
                    </div>
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name;?>">
                            <span class="error"><?php echo $name_err ?></span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control"><?php echo $address;?> </textarea>
                            <span class="error"><?php echo $address_err ?></span>
                        </div>
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary;?>">
                            <span class="error"><?php echo $salary_err ?></span>
                        </div>
                        <div class="form-group">
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