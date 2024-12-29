<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $index = $_POST['index'];
    $action = $_POST['action'];
    $newRow = $_POST['row'];
    $gender = $_POST['gender'];

    // Select the target file based on gender
    $filePath = $gender === "boys" ? "boys.csv" : "girls.csv";

    // Read data from the CSV file
    $data = [];
    if (file_exists($filePath) && ($handle = fopen($filePath, "r")) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    }

    // Perform the desired action
    if ($action === "update") {
        $data[$index] = $newRow;
    } elseif ($action === "delete") {
        unset($data[$index]);
        $data = array_values($data);
    } elseif ($action === "paid") {
        $data[$index][3] = "Paid Amount";
    } elseif ($action === "not-paid") {
        $data[$index][3] = "Not Paid";
    }

    // Write updated data back to the CSV file
    $file = fopen($filePath, "w");
    foreach ($data as $row) {
        fputcsv($file, $row);
    }
    fclose($file);

    header("Location: dashboard.php");
    exit;
}
?>
