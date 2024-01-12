<?php

include('mysession.php');
if (!session_id()) {
    session_start();
}

require("fpdf/fpdf.php");
// require("word.php");
// require "config.php";

include('dbcon.php');
//customer and invoice details
$info = [
    "customer" => "",
    "address" => ",",
    "city" => "",
    "invoice_no" => "",
    "quotationi_date" => "",
    "quotatione_date" => "",
    "total_amt" => "",
    "type" => "",
    "our_ref" => "",
    "phone" => ""
];

//Select Invoice Details From Database
$sql = "select * from quotecons where qc_OCID='{$_GET["id"]}'";
$res = $con->query($sql);
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();

    // $obj = new IndianCurrency($row["GRAND_TOTAL"]);


    $info = [
        "customer" => $row["qc_custname"],
        "address" => $row["qc_custaddress"],
        "city" => $row["qc_city"],
        "invoice_no" => $row["qc_OCID"],
        "quotationi_date" => date("d-m-Y", strtotime($row["qc_issuedate"])),
        "quotatione_date" => date("d-m-Y", strtotime($row["qc_expirydate"])),
        "attention" => $row["qc_AID"],
        "our_ref" => $row["qc_OCID"],
        "type" => $row["qc_type"],
        "phone" => $row["qc_custphone"]
        // "total_amt" => $row["qc_total"]
        // "words" => $obj->get_words(),
    ];
}

//invoice Products
$products_info = [];

//Select Invoice Product Details From Database
$sql = "select * from quotecons where qc_OCID='{$_GET["id"]}'";
$res = $con->query($sql);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $products_info[] = [
            "name" => $row["qc_name"],
            "type" => $row["qc_type"],
            "price" => $row["qc_unitprice"],
            "qty" => $row["qc_quantity"],
            "total" => $row["qc_total"],
        ];
    }
}

class PDF extends FPDF
{
    function Header()
    {
        // Load and display company logo
        $logoPath = 'https://files.ajobthing.com/employers/147490-1644206921.png'; // Replace with the actual path to your logo
        $this->Image($logoPath, 10, 10, 30); // Adjust the coordinates and size as needed


        //Display Company Info
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

        //Display Horizontal line
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
        // $this->SetY(72);
        // $this->SetX(10);
        // $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "Telephone: " . $info["phone"], 0, 1);
        // $this->SetY(81);
        // $this->SetX(10);
        // $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "Attention: " . $info["attention"], 0, 1);

        $this->SetY(63);
        $this->SetX(-60);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 7, "Our Ref.: " . $info["our_ref"], 0, 1);
        $this->SetY(69);
        $this->SetX(-60);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "Issue Date: " . $info["quotationi_date"], 0, 1);
        $this->SetY(75);
        $this->SetX(-60);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "Expiry Date: " . $info["quotatione_date"], 0, 1);
        // $this->Cell(0, 7, "Term: " . $info["term"], 0, 1);
        $this->SetY(81);
        $this->SetX(-60);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 7, "PIC: AZAM (012-2218224)");

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
            $this->Cell(65, 9, $row["name"] . ":" . $row["type"], "R", 0, "L");
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
        $this->Cell(0, 9, "forward to receive your valued orders in due course. If you have any futher question, please do not hesitate to call us.", 0, 1);
        $this->SetY(240);
        $this->SetX(10);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 9, "All payment must be made to AK MAJU RESOURCES SDN BHD (Maybank Account : 5510 5238 4209)", 0, 1);


        //set footer position
        $this->SetY(-30);
        $this->Ln(15);
        $this->SetFont('Arial', '', 10);
        //Display Footer Text
        $this->Cell(0, 10, "This is a computer generated invoice", 0, 1, "C");
    }
}
//Create A4 Page with Portrait 
$pdf = new PDF("P", "mm", "A4");
$pdf->AddPage();
$pdf->body($info, $products_info);
$pdf->Output();
