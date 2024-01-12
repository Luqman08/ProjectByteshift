<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbcon.php');

$ocid = $_POST['ocid'];
$cname = $_POST['cname'];
$cemail = $_POST['cemail'];
$cphone = $_POST['cphone'];
$caddress = $_POST['caddress'];
$ccat = $_POST['ccat'];
$ocname = $_POST['ocname'];
$octype = $_POST['octype'];
$ocquantity = $_POST['ocquantity'];
$qstat = $_POST['qstat'];
$ocstate = $_POST['ocstate'];
$occity = $_POST['occity'];
$ocdistance = $_POST['ocdistance'];
$ocidate = $_POST['ocidate'];
$ocedate = $_POST['ocedate'];
$suic = $_SESSION['suic'];

// Process each item
for ($i = 0; $i < count($ocname); $i++) {
    // Fetch the price from the constructionitem table based on name and type
    $fetchPriceSQL = "SELECT CI_price FROM constructionitem WHERE CI_name = '$ocname[$i]' AND CI_type = '$octype[$i]'";
    $priceResult = mysqli_query($con, $fetchPriceSQL);

    // Check if a row is returned
    if ($priceResult) {
        $priceRow = mysqli_fetch_assoc($priceResult);

        // Check if $priceRow is not null before accessing its values
        if ($priceRow !== null && isset($priceRow['CI_price'])) {
            $itemPrice = $priceRow['CI_price'];

            // Check if quantity is set
            if (isset($ocquantity[$i])) {
                // Calculate total price
                $totalPrice = $itemPrice * $ocquantity[$i];

                // Set the unit price
                $unitPrice = $itemPrice;

                // Insert the order details into the database, including customer details and AID
                $sql = "INSERT INTO quotecons(qc_OCID, qc_name, qc_type, qc_quantity, qc_unitprice, qc_state, qc_city, qc_distance, qc_issuedate, qc_expirydate, qc_custname, qc_custemail, qc_custphone, qc_custaddress, qc_AID, qc_custcategory, qc_qstatus, qc_total)
        VALUES ('$ocid', '$ocname[$i]', '$octype[$i]', '$ocquantity[$i]', '$unitPrice', '$ocstate','$occity', '$ocdistance', '$ocidate', '$ocedate', '$cname', '$cemail', '$cphone', '$caddress', '$suic', '$ccat', '$qstat', '$totalPrice')";

                mysqli_query($con, $sql);
            } else {
                // Handle the case where quantity is not set
                // You might want to log this or handle it in some way
            }
        } else {
            // Handle the case where CI_price is not set in the result row
            // You might want to log this or handle it in some way
        }
    } else {
        // Handle the case where the query execution fails
        // You might want to log this or handle it in some way
    }
}

mysqli_close($con);

header('Location: quotationlistCons.php');
