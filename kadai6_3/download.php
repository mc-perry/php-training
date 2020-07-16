<?php
require_once '../lib/MyDBControllerMySQL.class.php';
require_once '../lib/validation.class.php';

// Start the session
session_start();

$my_db = new MyDBControllerMySQL();
$my_db->connect();
$table_name = "kadai_jonathan_ziplist";

$download_data = array();
$csv_array = array();

$isDownloadAll;

// If we checked to download all
if ($_POST["downloadingAll"] == true) {
    $isDownloadAll = true;
    // Select all rows and write them to the array to be written to CSV
    $row_data_query = "SELECT * FROM $table_name";
    $download_data = $my_db->query($row_data_query, null, null, null, null, null);
} else if ($_POST["downloadcheckboxval"] != null) {
    $isDownloadAll = false;
    foreach ($_POST["downloadcheckboxval"] as $val) {
        $exploded = explode("/", $val);
        $dataRow = $my_db->selectByZip($exploded[0], $exploded[1], $exploded[2], $table_name)[0];
        array_push($download_data, $dataRow);
    }
} else if (count($download_data) == 0) {
    // Redirect user back to list page with error
    $_SESSION["no_files_selected_error"] = true;
    header("Location: index.php");
    exit();
}

// Close the db
$my_db->close();

foreach ($download_data as $data_row) {
    $out = implode(",", $data_row) . PHP_EOL;
    array_push($csv_array, $out);
}

$fp = fopen('php://output', 'w');

//set headers to download file rather than display
header('Content-Type: application/csv; charset="shift-jis"');
header('Content-disposition: attachment; filename="export.csv"');
header('Pragma: no-cache');
header('Expires: 0');

for ($x = 0; $x < count($csv_array); $x++) {
    echo mb_convert_encoding($csv_array[$x], "SJIS");
}

// Rewind the file pointer
rewind($fp);
// Close the file pointer
fclose($fp);

exit();