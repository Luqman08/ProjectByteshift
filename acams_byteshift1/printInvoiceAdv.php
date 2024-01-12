<?php

include('mysession.php');
if (!session_id()) {
    session_start();
}

require("fpdf/fpdf.php");
include('dbcon.php');

function getQuotationDetails($orderId)
{
    global $con;

    $query = "SELECT
                tb_order.o_id as order_id,
                tb_order.o_date as order_date,
                tb_customer.c_name as customer_name,
                tb_customer.c_phone as customer_phone,
                tb_product.p_name as product_name,
                tb_product.p_price as product_price,
                tb_orderproduct.op_quantity as order_quantity,
                tb_orderproduct.op_total_price as total_price
              FROM
                tb_order
                JOIN tb_customer ON tb_order.o_cid = tb_customer.c_id
                JOIN tb_orderproduct ON tb_order.o_id = tb_orderproduct.op_orderid
                JOIN tb_product ON tb_orderproduct.op_productid = tb_product.p_id
              WHERE
                tb_order.o_id = $orderId";

    $result = $con->query($query);

    $quotationDetails = array();
    while ($row = $result->fetch_assoc()) {
        $quotationDetails[] = $row;
    }

    return $quotationDetails;
}

// Retrieve quotation details for a specific order ID
$orderId = isset($_GET["id"]) ? $_GET["id"] : null;

if ($orderId !== null) {
    $quotationDetails = getQuotationDetails($orderId);
} else {
    // Handle the case when order ID is not provided
    // For example, redirect the user to an error page or show an error message
    die("Error: Order ID not provided.");
}

// Customer and invoice details
$info = [
    "customer" => $quotationDetails[0]['customer_name'],
    "invoice_no" => $quotationDetails[0]['order_id'],
    "quotation_date" => date("d-m-Y", strtotime($quotationDetails[0]['order_date'])),
    "our_ref" => $quotationDetails[0]['order_id'],
    "phone" => $quotationDetails[0]['customer_phone']
];

// Invoice products
$products_info = [];
foreach ($quotationDetails as $row) {
    $products_info[] = [
        "name" => $row["product_name"],
        "price" => $row["product_price"],
        "qty" => $row["order_quantity"],
        "total" => $row["total_price"]
    ];
}

class PDF extends FPDF
{
    function Header()
    {
        // Load and display company logo
        $logoPath = 'https://files.ajobthing.com/employers/147490-1644206921.png'; // Replace with the actual path to your logo
        $this->Image($logoPath, 10, 10, 30); // Adjust the coordinates and size as needed

        // Display Company Info
        $this->SetY(10);
        $this->SetX(40);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(50, 10, "AK MAJU RESOURCES SDN BHD ", 0, 0);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 10, "                                        (1088436-K)", 0, 1);
        $this->SetY(18);
        $this->SetX(40);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "39 & 41 Jalan Utama 3/2, Pusat Komersial Sri Utama, 85000 Segamat, Johor.", 0, 1);
        $this->SetY(22);
        $this->SetX(40);
        $this->Cell(50, 7, "Tel : 010-221 1074, 012-221 8224  Fax : 07-9310 717  Email : akmaju.printworks@gmail.com", 0, 1);

        // Display Horizontal line
        $this->Line(0, 45, 210, 45);
    }

    function body($info, $products_info)
    {
        // Draw a rectangle around the QUOTATION text
        $this->SetY(51);
        $this->SetX(10);
        $this->SetLineWidth(0.6); // Set the line width
        $textWidth = $this->GetStringWidth("INVOICE");
        $this->Rect(10, 51, $textWidth + 10, 10, 'D'); // Adjust the coordinates and size based on the text
        $this->SetLineWidth(0.2); // Reset the line width

        // Display QUOTATION text inside the rectangle
        $this->SetFont('Arial', 'B', 15);
        $this->SetY(51);
        $this->SetX(10);
        $this->Cell($textWidth + 10, 10, "INVOICE", 0, 1); // Adjust the width of the cell

        // Customer details
        $this->SetY(63);
        $this->SetX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "Customer Name: " . $info["customer"], 0, 1);
        $this->SetY(72);
        $this->SetX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "Telephone: " . $info["phone"], 0, 1);
        $this->SetY(81);
        $this->SetX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "Our Ref.: " . $info["our_ref"], 0, 1);
        $this->SetY(87);
        $this->SetX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "Issue Date: " . $info["quotation_date"], 0, 1);

        // PIC details
        $this->SetY(81);
        $this->SetX(-60);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "PIC: AZAM (012-2218224)", 0, 1);

        // Display Table headings with numbering column
        $this->SetY(98);
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(15, 9, "No.", 1, 0, "C"); // Numbering column
        $this->Cell(65, 9, "DESCRIPTION", 1, 0, "C");
        $this->Cell(30, 9, "QTY", 1, 0, "C");
        $this->Cell(40, 9, "UNIT PRICE (RM)", 1, 0, "C");
        $this->Cell(40, 9, "AMOUNT (RM)", 1, 1, "C");
        $this->SetFont('Arial', '', 12);

        // Display table product rows with numbering
        $counter = 1;
        foreach ($products_info as $row) {
            $this->Cell(15, 9, $counter, "LR", 0, "C"); // Numbering column
            $this->Cell(65, 9, $row["name"], "R", 0, "L");
            $this->Cell(30, 9, $row["qty"], "R", 0, "C");
            $this->Cell(40, 9, $row["price"], "R", 0, "C");
            $this->Cell(40, 9, $row["total"], "R", 1, "C");
            $counter++;
        }

        // Calculate the number of remaining empty rows
        $emptyRows = 12 - count($products_info);

        // Display table empty rows
        for ($i = 0; $i < $emptyRows; $i++) {
            $this->Cell(15, 9, "", "LR", 0, "C"); // Numbering column
            $this->Cell(65, 9, "", "R", 0, "L");
            $this->Cell(30, 9, "", "R", 0, "C");
            $this->Cell(40, 9, "", "R", 0, "C");
            $this->Cell(40, 9, "", "R", 1, "C");
        }

        // Calculate grand total
        $grandTotal = 0;
        foreach ($products_info as $row) {
            $grandTotal += $row["total"];
        }

        // New formula: Divide grand total by 2
        $newGrandTotal = $grandTotal / 2;


        // Display table total row
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(150, 9, "GRAND TOTAL", 1, 0, "R");
        $this->Cell(40, 9, number_format($newGrandTotal, 2), 1, 1, "R");
    }

    function Footer()
    {
        // Display notes
        $this->SetY(226);
        $this->SetX(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 9, "Notes:", 0, 1);
        $this->SetY(232);
        $this->SetX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 9, "Thank you for the opportunity to provide this quotation. We hope that our quotation is favourable to you and looking", 0, 1);
        $this->SetY(236);
        $this->SetX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 9, "forward to receive your valued orders in due course. If you have any further questions, please do not hesitate to call us.", 0, 1);
        $this->SetY(240);
        $this->SetX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 9, "All payment must be made to AK MAJU RESOURCES SDN BHD (Maybank Account : 5510 5238 4209)", 0, 1);

        // Set footer position
        $this->SetY(-30);
        $this->Ln(15);
        $this->SetFont('Arial', '', 10);
        // Display Footer Text
        $this->Cell(0, 10, "This is a computer-generated quotation", 0, 1, "C");
    }
}

// Create A4 Page with Portrait
$pdf = new PDF("P", "mm", "A4");
$pdf->AddPage();
$pdf->body($info, $products_info);
$pdf->Output();
