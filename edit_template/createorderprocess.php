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

$duplicateFound = false;

// Process each item
for ($i = 0; $i < count($ocname); $i++) {
    // Check if an identical order already exists
    $checkDuplicateSQL = "SELECT * FROM quotecons WHERE qc_OCID = '$ocid' AND qc_name = '$ocname[$i]' AND qc_type = '$octype[$i]'";
    $duplicateResult = mysqli_query($con, $checkDuplicateSQL);

    if (mysqli_num_rows($duplicateResult) > 0) {
        // Duplicate order found, set the flag
        $duplicateFound = true;
        $_SESSION['duplicateOrder'] = "Duplicate order found for Order Quotation: $ocid, Item Name: $ocname[$i], Item Type: $octype[$i]";
        break; // Exit the loop as we don't need to check further once a duplicate is found
    } else {
        // Fetch the price from the constructionitem table based on name and type
        $fetchPriceSQL = "SELECT CI_price FROM constructionitem WHERE CI_name = '$ocname[$i]' AND CI_type = '$octype[$i]'";
        $priceResult = mysqli_query($con, $fetchPriceSQL);

        if ($priceResult) {
            $priceRow = mysqli_fetch_assoc($priceResult);

            if ($priceRow !== null && isset($priceRow['CI_price'])) {
                $itemPrice = $priceRow['CI_price'];

                if (isset($ocquantity[$i])) {
                    $totalPrice = $itemPrice * $ocquantity[$i];
                    $unitPrice = $itemPrice;

                    // Insert the order details into the database
                    $sql = "INSERT INTO quotecons(qc_OCID, qc_name, qc_type, qc_quantity, qc_unitprice, qc_state, qc_city, qc_distance, qc_issuedate, qc_expirydate, qc_custname, qc_custemail, qc_custphone, qc_custaddress, qc_AID, qc_custcategory, qc_qstatus, qc_total)
                            VALUES ('$ocid', '$ocname[$i]', '$octype[$i]', '$ocquantity[$i]', '$unitPrice', '$ocstate','$occity', '$ocdistance', '$ocidate', '$ocedate', '$cname', '$cemail', '$cphone', '$caddress', '$suic', '$ccat', '$qstat', '$totalPrice')";

                    mysqli_query($con, $sql);
                } else {
                    // Handle the case where quantity is not set
                    echo "Quantity not set for Order Quotation: $ocid, Item Name: $ocname[$i], Item Type: $octype[$i].";
                }
            } else {
                // Handle the case where CI_price is not set in the result row
                echo "Price not found for Item Name: $ocname[$i], Item Type: $octype[$i].";
            }
        } else {
            // Handle the case where the query execution fails
            echo "Error executing query for Item Name: $ocname[$i], Item Type: $octype[$i].";
        }
    }
}

mysqli_close($con);

// Check if no duplicate was found and redirect accordingly
if (!$duplicateFound) {
    header('Location: quotationlistCons.php'); // Change 'quotationpage.php' to the actual page you want to redirect to
    exit(); // Ensure that the script stops executing after the redirection
} else {
    // Redirect back to createorder.php with a flag indicating the presence of a duplicate
    header('Location: createorder.php?duplicate=' . ($duplicateFound ? 'true' : 'false'));
    exit(); // Ensure that the script stops executing after the redirection
}
