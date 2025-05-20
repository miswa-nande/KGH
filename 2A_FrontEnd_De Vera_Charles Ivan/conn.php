<?php
// Database configuration
$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "KGH";

// Create connection
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute SELECT queries
function executeQuery($sql) {
    global $conn;
    $result = $conn->query($sql);
    return $result;
}

// Function to execute INSERT, UPDATE, DELETE queries
function executeNonQuery($sql) {
    global $conn;
    return $conn->query($sql);
}

// Function to escape string to prevent SQL injection
function escapeString($string) {
    global $conn;
    return $conn->real_escape_string($string);
}

// Function to close the database connection
function closeConnection() {
    global $conn;
    $conn->close();
}
?>