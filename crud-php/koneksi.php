<?php
$servername = "sql100.infinityfree.com";
$username = "if0_40866012";
$password = "vkoLDVddUT7w";
$db = "if0_40866012_webdailyjournal";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>