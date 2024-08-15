<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "whitespace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM plans WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Plan deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: manage-plans.php");
exit();
?>
