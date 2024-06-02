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
    if (isset($_POST['add_player'])) {
        // Dodawanie gracza
        $username = $conn->real_escape_string($_POST['username']);
        $role = $conn->real_escape_string($_POST['role']);
        $team_id = $conn->real_escape_string($_POST['team_id']);
        $sql = "INSERT INTO players (username, role, team_id) VALUES ('$username', '$role', '$team_id')";
        $conn->query($sql);
    } elseif (isset($_POST['edit_player'])) {
        // Edytowanie gracza
        $player_id = $conn->real_escape_string($_POST['player_id']);
        $username = $conn->real_escape_string($_POST['username']);
        $role = $conn->real_escape_string($_POST['role']);
        $team_id = $conn->real_escape_string($_POST['team_id']);
        $sql = "UPDATE players SET username='$username', role='$role', team_id='$team_id' WHERE player_id='$player_id'";
        $conn->query($sql);
    } elseif (isset($_POST['delete_player'])) {
        // Usuwanie gracza
        $player_id = $conn->real_escape_string($_POST['player_id']);
        $sql = "DELETE FROM players WHERE player_id='$player_id'";
        $conn->query($sql);
    }
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
