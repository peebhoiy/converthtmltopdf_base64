<?php
// Include Composer autoloader
require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $htmlContent = $_POST['html_content'];

    $dompdf = new Dompdf();

    $dompdf->loadHtml($htmlContent);

    // Set paper size and orientation A4/A3/A5 etc, if not comment code
    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();
    $pdfContent = $dompdf->output();
    $pdfBase64 = base64_encode($pdfContent);

    //DB conn parameters
    $servername = "localhost";
    $username = "pdfconuser";
    $password = "T35Tpassv!";
    $database = "convertpdf";

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO pdf_table (pdf_data) VALUES (?)";

    //Bind and execute
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pdfBase64);

    if ($stmt->execute()) {
        echo "PDF stored successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>