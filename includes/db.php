<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'legalease';

// Create connection
$db = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set charset to utf8mb4 for full Unicode support
$db->set_charset("utf8mb4");

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Helper function for prepared statements
function executeQuery($sql, $params = []) {
    global $db;
    $stmt = $db->prepare($sql);
    
    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt;
}
?>