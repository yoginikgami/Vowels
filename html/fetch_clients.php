<?php 
require 'connection.php';

//search client 
$clientSearch = "SELECT * FROM client_master";
$result = $con->query($clientSearch);

// Initialize an empty array for the clients
$clients = [];

if ($result->num_rows > 0) {
    // Fetch each client as an associative array
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}

echo json_encode($clients);
?>