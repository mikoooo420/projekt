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
    if (isset($_POST['add_stat'])) {
        // Dodawanie statystyk
        $player_id = $conn->real_escape_string($_POST['player_id']);
        $kd_ratio = $conn->real_escape_string($_POST['kd_ratio']);
        $points = $conn->real_escape_string($_POST['points']);
        $matches_won = $conn->real_escape_string($_POST['matches_won']);
        $tournaments_won = $conn->real_escape_string($_POST['tournaments_won']);
        $sql = "INSERT INTO stats (player_id, kd_ratio, points, matches_won, tournaments_won) VALUES ('$player_id', '$kd_ratio', '$points', '$matches_won', '$tournaments_won')";
        $conn->query($sql);
    } elseif (isset($_POST['edit_stat'])) {
        // Edytowanie statystyk
        $stat_id = $conn->real_escape_string($_POST['stat_id']);
        $player_id = $conn->real_escape_string($_POST['player_id']);
        $kd_ratio = $conn->real_escape_string($_POST['kd_ratio']);
        $points = $conn->real_escape_string($_POST['points']);
        $matches_won = $conn->real_escape_string($_POST['matches_won']);
        $tournaments_won = $conn->real_escape_string($_POST['tournaments_won']);
        $sql = "UPDATE stats SET player_id='$player_id', kd_ratio='$kd_ratio', points='$points', matches_won='$matches_won', tournaments_won='$tournaments_won' WHERE stat_id='$stat_id'";
        $conn->query($sql);
    } elseif (isset($_POST['delete_stat'])) {
        // Usuwanie statystyk
        $stat_id = $conn->real_escape_string($_POST['stat_id']);
        $sql = "DELETE FROM stats WHERE stat_id='$stat_id'";
        $conn->query($sql);
    }
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
