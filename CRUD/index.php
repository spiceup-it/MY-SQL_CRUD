<?php

require_once('includes/config.php');

//create the table
$sql = "CREATE TABLE IF NOT EXISTS Employees1 (
    id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    address VARCHAR(50) NOT NULL,
    salary INT(10),
    reg_date TIMESTAMP
    )";

if($conn->query($sql) === TRUE)
    echo "Table Employees created successfully<br>";
else
    echo "Error creating table:". $conn->error;


    // //insert records into table
    // $sql = "INSERT INTO Employees1 (name,address,salary) VALUES ('John','JohnDoe,India ','10000');";
    // $sql .= "INSERT INTO Employees1(name, address,salary) VALUES ('Michel','Gates,Japan','20000');";
    // $sql .= "INSERT INTO Employees1(name, address,salary) VALUES ('Sridhar','Murali, France','50000');";
    // $sql .= "INSERT INTO Employees1(name, address,salary) VALUES ('Bill','Clinton, Indonesia','30000');";
    // $sql .= "INSERT INTO Employees1(name, address,salary) VALUES ('Sundar','Pichhai, Russia','40000');";


    // if($conn->multi_query($sql) === TRUE)
    //         echo "New record created successfully";
    // else
    //         echo "Error: ". $sql . "<br>" .$conn->error;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2 class="float-left text-center">Employees Details</h2>
                    <a href="create.php" class="btn btn-success float-right mb-2">Add New Employees</a>
                </div>
                <?php  
               // require_once('includes/config.php'); 
                      //Select all records 
                       $sql = "SELECT * FROM Employees1";
                       if($result = mysqli_query($conn,$sql)){
                           if(mysqli_num_rows($result) > 0){
                               echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Address</th>";
                                        echo "<th>Salary</th>";
                                        echo "<th colspan=2>Action</th>";

                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>".$row['id']."</td>";
                                        echo "<td>".$row['name']."</td>";
                                        echo "<td>".$row['address']."</td>";
                                        echo "<td>".$row['salary']."</td>";
                                        echo "<td><a href='read.php?id=".$row['id']."' title='View Record'>
                                        <i class='fas fa-eye'></i> </a></td>";
                                        echo "<td><a href='update.php?id=".$row['id']."' title='Update Record'>
                                        <i class='fas fa-edit'></i></a></td>";
                                        echo "<td><a href='delete.php?id=".$row['id']."' title='Delete Record'>
                                        <i class='fas fa-trash-alt'></i> </a></td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";

                                mysqli_free_result($result);
                            }
                            else
                                echo "<p class='lead'><em>No records were found</em></p>";
                            
                        }
                        else
                            echo "ERROR: Could not able to execute $sql.".mysqli_error($conn);

                            
                    mysqli_close($conn);

                    ?>               
                
                
                
                </div>
            
            
            
            
            </div>
        </div>
    </div>
</body>
</html>