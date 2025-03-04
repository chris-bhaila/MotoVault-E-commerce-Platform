<?php
include("../dbconn.php");

$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;

if ($cat_id > 0) {
    $query = "SELECT * FROM sub_category WHERE cat_id='$cat_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<input type="radio" name="sub_category" value="' . $row['sub_cat_id'] . '">' . $row['name'] . '<br>';
        }
    } else {
        echo 'No sub-categories found.';
    }
}
?>