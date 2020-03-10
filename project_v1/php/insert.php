<?php

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    if (!empty($fname) || !empty($lname) || !empty($email) || !empty($password) || !empty($gender)) {
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "accounts";

        // create a connection
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connection Error('.mysqli_connect_errno().')'.mysqli_connect_error());

        } else {
            $SELECT = "SELECT email from register Where email = ? Limit 1";
            $INSERT = "INSERT Into register (fname, lname, email, password, gender) values(?, ?, ?, ?, ?)";

            // Prepare statement
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssssii", $fname, $lname, $email, $password, $gender);
                $stmt->excute();
                echo "New record inserted";
            } else {
                echo "Email already registed";
            }
            $stmt->close();
            $conn->close();
        }

    } 
    else {
        echo "ALl fields are required";
        die()
    }



?>