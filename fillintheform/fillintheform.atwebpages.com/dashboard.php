<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Function to read CSV data
function readCSV($filename) {
    $data = [];
    if (file_exists($filename) && ($handle = fopen($filename, "r")) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}

// Read data from boys.csv and girls.csv
$boysData = readCSV("boys.csv");
$girlsData = readCSV("girls.csv");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
            color: #343a40;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #495057;
            margin-bottom: 20px;
        }

        .btn {
            margin-bottom: 15px;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            background-color: #343a40;
            color: #f8f9fa;
            text-align: center;
        }

        .table tbody tr:hover {
            background-color: #f1f3f5;
        }

        @media (max-width: 768px) {
            h1, h2 {
                font-size: 1.5rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 6px 10px;
            }

            .table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <h1>Trip Data Collection</h1>
   <div class="d-flex justify-content-between">
    <a href="logout.php" class="btn btn-secondary no-print">Logout</a>
    <div>
        <button class="btn btn-success no-print" onclick="printTable()">Print Boys Table</button>
        <button class="btn btn-success no-print" onclick="printGirlsTable()">Print Girls Table</button>
    </div>
</div>

<h2>Boys Data</h2>
<div id="printableTable">
    <table class="table table-striped table-bordered">
        <thead>
            <tr><th colspan="6">Agriculture University of Peshawar Travel Adventure</th></tr>
            <tr><th colspan="6">Boys Information</th></tr>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>ID Card</th>
                <th>Mobile</th>
                <th>Status</th>
                <th class="no-print">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($boysData as $index => $row): ?>
            <tr>
                <form method="POST" action="process_action.php">
                    <td><?php echo $index + 1; ?></td>
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <input type="hidden" name="gender" value="boys">
                    <?php foreach ($row as $col): ?>
                        <td><input type="text" name="row[]" value="<?php echo htmlspecialchars($col); ?>" class="form-control" readonly></td>
                    <?php endforeach; ?>
                    <td class="no-print">
                        <button type="submit" name="action" value="update" class="btn btn-primary">Update</button>
                        <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                        <button type="submit" name="action" value="paid" class="btn btn-success">Paid</button>
                        <button type="submit" name="action" value="not-paid" class="btn btn-warning">Not Paid</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<h2>Girls Data</h2>
<div id="printableTableGirls">
    <table class="table table-striped table-bordered">
        <thead>
            <tr><th colspan="6">Agriculture University of Peshawar Travel Adventure</th></tr>
            <tr><th colspan="6">Girls Information</th></tr>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>ID Card</th>
                <th>Mobile</th>
                <th>Status</th>
                <th class="no-print">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($girlsData as $index => $row): ?>
            <tr>
                <form method="POST" action="process_action.php">
                    <td><?php echo $index + 1; ?></td>
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <input type="hidden" name="gender" value="girls">
                    <?php foreach ($row as $col): ?>
                        <td><input type="text" name="row[]" value="<?php echo htmlspecialchars($col); ?>" class="form-control" readonly></td>
                    <?php endforeach; ?>
                    <td class="no-print">
                        <button type="submit" name="action" value="update" class="btn btn-primary">Update</button>
                        <button type="submit" name="action" value="delete" class="btn btn-danger">Delete</button>
                        <button type="submit" name="action" value="paid" class="btn btn-success">Paid</button>
                        <button type="submit" name="action" value="not-paid" class="btn btn-warning">Not Paid</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<script>
function printTable() {
    var content = document.getElementById("printableTable").innerHTML;  // Adjust the ID for the table

    // Create a new window for printing
    var newWindow = window.open('', '', 'width=800, height=600');
    newWindow.document.write('<html><head><title> Boys Trip Information</title>');
    
    // Add styles for the printed content
    newWindow.document.write(`
        <style>
            @media print {
                @page {
                    size: A4;
                    margin-top: 0.49in;
                    margin-left: 0.28in;
                    margin-right: 0.28in;
                    margin-bottom: 0.49in;
                }
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 4px;
                    border: 1px solid #000;
                    font-size: 10px;
                    word-break: break-word;
                }
                th {
                    font-size: 12px;
                    background-color: #f2f2f2;
                }
                td.rollno, td.name {
                    text-align: left;
                }
                .no-print {
                    display: none;
                }
                table, h1, h2, h3, p {
                    page-break-inside: avoid;
                }
            }
        </style>
    `);
    
    newWindow.document.write('</head><body>');
    newWindow.document.write(content); // Add the table content
    newWindow.document.write('</body></html>');
    newWindow.document.close();

    // Print the new window content
    newWindow.print();
}
function printGirlsTable() {
    var content = document.getElementById("printableTableGirls").innerHTML;

    // Create a new window for printing
    var newWindow = window.open('', '', 'width=800, height=600');
    newWindow.document.write('<html><head><title> Girls Trip Information</title>');
    
    // Add styles for the printed content
    newWindow.document.write(`
        <style>
            @media print {
                @page {
                    size: A4;
                    margin-top: 0.49in;
                    margin-left: 0.28in;
                    margin-right: 0.28in;
                    margin-bottom: 0.49in;
                }
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 4px;
                    border: 1px solid #000;
                    font-size: 10px;
                    word-break: break-word;
                }
                th {
                    font-size: 12px;
                    background-color: #f2f2f2;
                }
                td.rollno, td.name {
                    text-align: left;
                }
                .no-print {
                    display: none;
                }
                table, h1, h2, h3, p {
                    page-break-inside: avoid;
                }
            }
        </style>
    `);

    newWindow.document.write('</head><body>');
    newWindow.document.write(content);
    newWindow.document.write('</body></html>');
    newWindow.document.close();

    newWindow.print();
}


        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
