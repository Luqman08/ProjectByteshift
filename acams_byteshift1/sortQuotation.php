<?php
// Include your database connection file
include("dbcon.php");

// Retrieve the sorting criteria from the AJAX request
$sortBy = $_POST['sortBy'];

// Define the SQL query based on the sorting criteria
if ($sortBy === 'qc_OCID' || $sortBy === 'qc_issuedate' || $sortBy === 'qc_expirydate') {
    $sql = "SELECT * FROM quotecons ORDER BY $sortBy";
} else {
    // Default query if an invalid sorting criteria is provided
    $sql = "SELECT * FROM quotecons";
}

// Execute the query
$result = mysqli_query($con, $sql);

// Check for errors
if (!$result) {
    die("Error in SQL query: " . mysqli_error($con));
}

// Output the sorted data in HTML format
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['qc_OCID'] . "</td>";
    echo "<td>" . $row['qc_issuedate'] . "</td>";
    echo "<td>" . $row['qc_expirydate'] . "</td>";
    // Add other columns as needed
    echo "<td>";
    // Add your button links here
    echo "</td>";
    echo "</tr>";
}

// Close the database connection
mysqli_close($con);
