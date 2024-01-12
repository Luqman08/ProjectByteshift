<?php
session_start();

// Include database connection
include('dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the login form (sanitize inputs to prevent SQL injection)
    $u_id = mysqli_real_escape_string($con, $_POST['u_id']);
    $fpwd = mysqli_real_escape_string($con, $_POST['fpwd']);
    $userType = mysqli_real_escape_string($con, $_POST['userType']);

    // Add debugging output
    echo "User Type: $userType<br>";

    // SQL retrieve statement
    $sql = "SELECT * FROM tb_user WHERE u_id='$u_id' AND u_pwd='$fpwd' AND u_type='$userType'";

    // Execute SQL
    $result = mysqli_query($con, $sql);

    // Check for SQL errors
    if (!$result) {
        die("SQL Error: " . mysqli_error($con));
    }

    function redirectUser($userType)
    {
        if ($userType == "1") {
            header('Location: staffpage.php'); // Redirect to the staff page
        } else if ($userType == "2") {
            header('Location: report.php'); // Redirect to the admin page
        } else {
            // Handle other user types or invalid types
            header('Location: login.php');
        }
        exit();
    }

    // Retrieve row/data
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        // User available
        $row = mysqli_fetch_array($result);

        // Set session variables
        $_SESSION['u_id'] = session_id();
        $_SESSION['suic'] = $fname;

        // Regenerate session ID (optional but recommended)
        session_regenerate_id(true);

        // Redirect to corresponding page
        redirectUser($userType);
    } else {
        // Data not available/exist
        // Add script to let the user know either username or password is wrong

        // Add debugging output
        echo "Login failed<br>";

        header('Location: login.php');
        exit();
    }
}

// Close DB connection
mysqli_close($con);