
<?php
include("../dbconn.php");

echo '<meta http-equiv="refresh" content="20">'; // Auto-refresh every 10 seconds
// Fetch total number of products
$totalQuery = "SELECT COUNT(*) AS total_products FROM motoproducts";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalProducts = $totalRow['total_products'];
echo "<h2>Total Products in Store: $totalProducts</h2>";
$query = "
    SELECT 
        s.sub_cat_id,
        s.name AS sub_cat_name,
        c.name AS category_name,
        COUNT(m.sub_cat_fid) AS product_count
    FROM sub_category s
    JOIN categories c ON s.cat_id = c.category_id
    LEFT JOIN motoproducts m ON s.sub_cat_id = m.sub_cat_fid
    GROUP BY s.sub_cat_id, s.name, c.name
    ORDER BY 
        FIELD(c.name, 'Helmets', 'Riding Gear', 'Parts'),
        s.name
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

echo "<h2>Product Count by Sub-Category (Auto-refreshes every 20 seconds)</h2>";
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr><th>S.N.</th><th>Category</th><th>Sub-Category ID</th><th>Sub-Category Name</th><th>Number of Products</th></tr>";
$index = 0;

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . ++$index . "</td>";
    echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['sub_cat_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['sub_cat_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['product_count']) . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<br><h2>Product Count by Brand</h2>";

$brandQuery = "
    SELECT 
        b.brand_id,
        b.name AS brand_name,
        COUNT(m.product_id) AS product_count
    FROM brands b
    LEFT JOIN motoproducts m ON b.brand_id = m.brand_fid
    GROUP BY b.brand_id, b.name
    ";
    
    // ORDER BY product_count DESC
$brandResult = mysqli_query($conn, $brandQuery);

if (!$brandResult) {
    die("Brand query failed: " . mysqli_error($conn));
}

echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr><th>S.N.</th><th>Brand ID</th><th>Brand Name</th><th>Number of Products</th></tr>";
$brandIndex = 0;

while ($row = mysqli_fetch_assoc($brandResult)) {
    echo "<tr>";
    echo "<td>" . ++$brandIndex . "</td>";
    echo "<td>" . htmlspecialchars($row['brand_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['brand_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['product_count']) . "</td>";
    echo "</tr>";
}

echo "</table>";

?>
