<?php
// ============================================================
//  db_config.php  –  Central Database Configuration
//  Place this file in your project ROOT folder (ORIGINALPROJECT/)
//  CHANGE the values below to match YOUR MySQL settings
// ============================================================

define('DB_HOST', 'localhost');   // Usually 'localhost'
define('DB_USER', 'root');        // Your MySQL username
define('DB_PASS', '');  // ← CHANGE THIS to your MySQL password
define('DB_NAME', 'pdf_audio_db'); // Your database name

// Create connection
function getDBConnection() {
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$con) {
        die("❌ Database Connection Failed: " . mysqli_connect_error() .
            "<br>Please check db_config.php settings.");
    }

    // Set charset to UTF-8
    mysqli_set_charset($con, "utf8mb4");
    return $con;
}
?>
