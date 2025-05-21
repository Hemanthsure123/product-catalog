<?php
// Database connection settings
$host = 'localhost'; // The server where the database is (usually 'localhost')
$database_name = 'electronics_catalog'; // Name of the database
$username = 'root'; // Your MySQL username (default is often 'root')
$password = ''; // Your MySQL password (default is often empty for 'root')

// Try to connect to the database
try {
    // Create a connection using PDO
    $db = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);
    
    // Make sure errors are shown (helps find problems)
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Tell PDO to return results as simple arrays (easier to use)
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // If connection fails, show a simple error message and stop
    echo "Sorry, could not connect to the database: " . $e->getMessage();
    exit;
}
?>