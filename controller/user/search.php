<?php
require_once '../../includes/dbconn.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $queryParam = '%' . $query . '%';

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT productID, productName, productImage,productPrice FROM product WHERE productName LIKE ?");
    $stmt->bind_param('s', $queryParam);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results and display them
    while ($row = $result->fetch_assoc()) {
        echo '<a href="/shoppink/shop-single.php?productID=' . htmlspecialchars($row['productID']) . '" class="result-item" style="text-decoration: none; color: inherit;">';
        echo '<img src="' . $row['productImage'] . '">';
        echo '<span style="color:black;"><b>' . htmlspecialchars($row['productName']) . '</b><br> RM'. number_format(htmlspecialchars($row['productPrice']),2) .'</span>';
        echo '</a>';
    }

    $stmt->close();
}
?>
