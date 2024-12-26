<?php
function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        die("The .env file does not exist.");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip lines starting with #
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Split key and value
        list($key, $value) = explode('=', $line, 2);

        // Trim and set the environment variable
        $_ENV[trim($key)] = trim($value);
    }
}

// Load the .env file from the root directory
$rootPath = dirname(__DIR__); // Get the parent directory (root)
$envFilePath = $rootPath . '/.env';

loadEnv($envFilePath);

// Access the variables
$servername = $_ENV['DB_SERVER'];
$dbusername = $_ENV['DB_USERNAME'];
$dbpassword = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

// Connect to the database
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname) or die('Error connecting to database');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
