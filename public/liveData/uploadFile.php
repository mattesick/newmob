
<?php
require_once "../../boot.php";
if (isset($_POST["rgid"]) && isset($_FILES['file']) && $_FILES['file']['size'] != 0) {
    //folder that we save the files in.
    $dir = $_SERVER["DOCUMENT_ROOT"] . "requestFiles" . DIRECTORY_SEPARATOR . $_POST["rgid"];
    if (!is_dir(DIRECTORY_SEPARATOR . "requestFiles" . DIRECTORY_SEPARATOR . $_POST["rgid"] . DIRECTORY_SEPARATOR) && !file_exists($dir)) {
        $result = mkdir($dir, 0777, true);
    }
    $targetDir = $dir . DIRECTORY_SEPARATOR;
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    // Guessing that the file will be allowed in the beginning but if it dosen't pass all tests allowed will be false,
    $allowed = true;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($targetFile)) {
        $msg =  "Den filen finns redan!";
        $allowed = false;
    }
    // Check file size
    if ($_FILES["file"]["size"] > 1000000) {
        $msg =  "Filen är för stor!";
        $allowed = false;
    }
    // Allow certain file formats
    if (
        $fileType != "jpg" && $fileType != "png" && $fileType != "pdf"
        && $fileType != "docx"
    ) {
        $msg =  "Vi tar bara emot JPG, PNG, PDF, DOCX filer.";
        $allowed = false;
    }
    // Check if $allowed is set to false by an msg
    if ($allowed == false) {
        $msg .=  " Din fil laddades inte upp!";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $msg =  basename($_FILES["file"]["name"]);
        } else {
            $msg =  "Något gick fel när vi försökte ladda up filen!";
        }
    }
    $data = [
        'allowed' => $allowed,
        'fileName' => $msg
    ];


    echo json_encode($data);
}
