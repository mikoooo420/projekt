<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csgo_management";

// Połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register_team'])) {
        // Rejestracja drużyny
        $team_name = $conn->real_escape_string($_POST['team_name']);
        $captain_id = $conn->real_escape_string($_POST['captain_id']);
        $sql = "INSERT INTO teams (team_name, captain_id) VALUES ('$team_name', '$captain_id')";
        $conn->query($sql);
    } elseif (isset($_POST['edit_team'])) {
        // Edycja drużyny
        // Implementacja kodu edycji drużyny
    } elseif (isset($_POST['delete_team'])) {
        // Usunięcie drużyny
        // Implementacja kodu usunięcia drużyny
    }
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
