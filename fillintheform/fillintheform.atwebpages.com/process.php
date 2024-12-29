<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $idCard = $_POST["idCard"];
    $mobile = $_POST["mobile"];
    $gender = $_POST["gender"];

    // Prepare the data
    $data = array($name, $idCard, $mobile);

    // Select the file based on gender
    if ($gender === "Boys") {
        $file = fopen("boys.csv", "a");
    } else {
        $file = fopen("girls.csv", "a");
    }

    // Append data to the respective CSV file
    fputcsv($file, $data);
    fclose($file);

    // Success message
    echo "<script>
                    alert('Data Submitted.');
                    window.location.href = 'index.html';
                  </script>";
        }
?>
