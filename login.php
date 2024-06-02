<?php
session_start();

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
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Nieprawidłowe hasło.";
        }
    } else {
        echo "Nie znaleziono użytkownika.";
    }
}

$conn->close();
?>
