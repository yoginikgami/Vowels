<?php
include '../config.php';

$sql = "SELECT position, tems_cond_name, id FROM temps_condi_tax_invoice ORDER BY position ASC";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr data-id="' . $row['id'] . '">
            <th scope="row">' . htmlspecialchars($row['position']) . '</th>
            <td>' . htmlspecialchars($row['tems_cond_name']) . '</td>
            <td><button class="btn btn-danger btn-sm delete-btn" data-id="' . $row['id'] . '">Delete</button></td>
        </tr>';
    }
} else {
    echo '<tr><td colspan="3">No records found.</td></tr>';
}
?>
