<?php

// Copyright 2024 Pius Odiahi
// 
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
// 
//     https://www.apache.org/licenses/LICENSE-2.0
// 
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

// Include Composer autoloader
require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Function to convert HTML to base64-encoded PDF
function convertHtmlToPdfBase64($html) {
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // Set paper size and orientation A4/A3/A5 etc, if not comment code
    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    // return output and convert to base 64
    $pdfContent = $dompdf->output();
    $pdfBase64 = base64_encode($pdfContent);

    return $pdfBase64;
}

// Function to save base64-encoded PDF content to a file
function savePdfToFile($pdfBase64, $filename) {

    $pdfContent = base64_decode($pdfBase64);

    file_put_contents($filename, $pdfContent);
}

$htmlContent = '<h1>Hello, world!</h1><p>This is a sample HTML content.</p>';
$pdfBase64 = convertHtmlToPdfBase64($htmlContent);

// Save base64-encoded PDF content to a file
savePdfToFile($pdfBase64, 'file_output.pdf');

// $pdfBase64 = convertHtmlToPdfBase64($htmlContent);
// echo $pdfBase64;
?>
