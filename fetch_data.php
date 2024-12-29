<?php
if (isset($_GET['gender'])) {
    $gender = $_GET['gender'];
    $filename = ($gender === "Boys") ? "boys.csv" : "girls.csv";

    if (file_exists($filename)) {
        $file = fopen($filename, "r");

        // Display table header with the new Paid/Not Paid column
        echo "<table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th> <!-- New column for Paid/Not Paid -->
                    </tr>
                </thead>
                <tbody>";

        $counter = 1;
        while (($data = fgetcsv($file)) !== false) {
            // Ensure the "Paid/Not Paid" status exists in the CSV row
            $status = isset($data[3]) ? $data[3] : "Not Specified";

            echo "<tr>
                    <td>{$counter}</td>
                    <td>{$data[0]}</td>
                    <td>{$status}</td> <!-- Display Paid/Not Paid status -->
                  </tr>";
            $counter++;
        }

        echo "</tbody></table>";
        fclose($file);
    } else {
        echo "<p>No data available for {$gender}.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
