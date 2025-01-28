#!/usr/local/bin/php
<?php header('Content-Type: text/plain; charset=utf-8');

$db = new SQLITE3('credit.db');
$statement = 'CREATE TABLE IF NOT EXISTS users(name TEXT, credit REAL)';
$db->exec($statement);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo 'Either the user or credit was not posted';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['credit'])) {
    $username = $_POST['username'];
    $credit = $_POST['credit'];
    $credit = floatval($credit);

    // Check if the user exists in the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $db->query($query);

    if ($row = $result->fetchArray()) {
        // User exists, update their credit
        $update = "UPDATE users SET credit = $credit WHERE username = '$username'";
        $db->exec($update);  // Execute the update query
    
        // Re-fetch the updated credit from the database
        $query = "SELECT credit FROM users WHERE username = '$username'";  // Re-run the SELECT query
        $result = $db->query($query);  // Get the updated value
        $row = $result->fetchArray();  // Fetch the updated row
    
        $credit = $row['credit'];  // Get the updated credit value
    } else {
        // User doesn't exist, insert a new record
        $insert = "INSERT INTO users (name, credit) VALUES ('$username', $credit)";
        $db->exec($insert);
    }    

    // Return the updated credit as a response
    // echo 'Your Credit: $' . number_format($credit, 2);
    echo number_format($credit, 2);
}

$db->close();
?>

