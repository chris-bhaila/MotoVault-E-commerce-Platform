<?php
$servername = "localhost";
$username = "root";  // your DB username
$password = "";      // your DB password
$dbname = "motovault";  // your DB name

$csvFile = "motoproducts.csv";  // path to your CSV file

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Open CSV file for reading
if (!file_exists($csvFile) || !is_readable($csvFile)) {
    die("CSV file not found or not readable.");
}

$header = null;
$data = [];
$rowCount = 0;
$insertedCount = 0;

if (($handle = fopen($csvFile, 'r')) !== false) {
    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
        if (!$header) {
            $header = $row;  // First row as header
            continue;
        }

        $rowCount++;

        // Combine header and row to assoc array for clarity
        $rowData = array_combine($header, $row);

        // Basic validation (can be extended)
        if (empty($rowData['product_id']) || empty($rowData['name'])) {
            continue;  // skip incomplete rows
        }

        // Prepare insert statement to avoid SQL injection
        $stmt = $conn->prepare("
            INSERT INTO motoproducts 
            (product_id, name, price, brand_fid, category_fid, sub_cat_fid, stock, description, features, image, tags, timestamp)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                name=VALUES(name),
                price=VALUES(price),
                brand_fid=VALUES(brand_fid),
                category_fid=VALUES(category_fid),
                sub_cat_fid=VALUES(sub_cat_fid),
                stock=VALUES(stock),
                description=VALUES(description),
                features=VALUES(features),
                image=VALUES(image),
                tags=VALUES(tags),
                timestamp=VALUES(timestamp)
        ");

        // Bind parameters - adjust types: i=int, s=string
        $stmt->bind_param(
            "isiiiiisssss",
            $rowData['product_id'],
            $rowData['name'],
            $rowData['price'],
            $rowData['brand_fid'],
            $rowData['category_fid'],
            $rowData['sub_cat_fid'],
            $rowData['stock'],
            $rowData['description'],
            $rowData['features'],
            $rowData['image'],
            $rowData['tags'],
            $rowData['timestamp']
        );

        // Execute and check
        if ($stmt->execute()) {
            $insertedCount++;
        } else {
            // Uncomment to debug errors for rows:
            // echo "Failed to insert product_id " . $rowData['product_id'] . ": " . $stmt->error . "\n";
        }

        $stmt->close();
    }
    fclose($handle);
} else {
    die("Failed to open the CSV file.");
}

$conn->close();

echo "Import completed: Processed $rowCount rows, inserted/updated $insertedCount products.\n";
?>
