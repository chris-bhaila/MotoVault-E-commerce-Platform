<?php
include("../dbconn.php");

// Initialize array
$a = [];

// Fetch all tags from database
$select_product = mysqli_query($conn, "SELECT tags FROM `motoproducts`") or die('Query failed.');
if (mysqli_num_rows($select_product) > 0) {
    while ($fetch_tag = mysqli_fetch_assoc($select_product)) {
        $tags = explode(',', $fetch_tag['tags']); // Split comma-separated tags
        foreach ($tags as $tag) {
            $a[] = trim($tag); // Remove any extra spaces
        }
    }
}

$a = array_unique($a); // Remove duplicate tags

$q = $_REQUEST['q'] ?? '';
$hint = "";

if ($q !== "") {
    $q = strtolower($q);
    foreach ($a as $name) {
        if (stristr($name, $q)) { // Match anywhere in the tag
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

echo $hint === "" ? "No Suggestions Found" : $hint;
?>
