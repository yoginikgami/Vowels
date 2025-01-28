<?php
require 'connection.php';

$clientId = $_POST['id']; // Get client ID from AJAX request
$sql = "SELECT * FROM client_master WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $clientId);
$stmt->execute();
$result = $stmt->get_result();

$clientDetails = $result->fetch_assoc();

echo json_encode($clientDetails);
$con->close();
?>
