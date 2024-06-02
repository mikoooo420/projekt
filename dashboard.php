<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="submit"], select {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .section {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <h1>Witaj w dashboardzie!</h1>
    <p>Jesteś zalogowany.</p>

    <?php
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    
    // Połączenie z bazą danych
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "csgo_management";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Pobranie identyfikatora zalogowanego użytkownika
    $user_id = $_SESSION['user_id'];
    
    // Zapytanie SQL, aby znaleźć drużynę, do której należy zalogowany użytkownik
    $sql_team = "SELECT * FROM teams WHERE captain_id = $user_id";
    $result_team = $conn->query($sql_team);
    
    if ($result_team->num_rows > 0) {
        // Wyświetlanie informacji o drużynie użytkownika
        $row_team = $result_team->fetch_assoc();
        $team_id = $row_team['team_id'];
        $team_name = $row_team['team_name'];
    
        echo "<h2>Twoja drużyna: $team_name</h2>";
    
        // Zapytanie SQL, aby pobrać statystyki drużyny
        $sql_stats = "SELECT * FROM team_stats WHERE team_id = $team_id";
        $result_stats = $conn->query($sql_stats);
    
        if ($result_stats->num_rows > 0) {
            // Wyświetlanie statystyk drużyny
            $row_stats = $result_stats->fetch_assoc();
            echo "<p>Statystyki drużyny:</p>";
            echo "<ul>";
            echo "<li>Wygrane: " . $row_stats['wins'] . "</li>";
            echo "<li>Przegrane: " . $row_stats['losses'] . "</li>";
            echo "<li>Remisy: " . $row_stats['draws'] . "</li>";
            echo "</ul>";
        } else {
            echo "<p>Brak statystyk dla drużyny.</p>";
        }
    
        // Zapytanie SQL, aby pobrać wszystkich graczy drużyny
        $sql_players = "SELECT * FROM players WHERE team_id = $team_id";
        $result_players = $conn->query($sql_players);
    
        if ($result_players->num_rows > 0) {
            // Wyświetlanie listy graczy drużyny
            echo "<h3>Gracze drużyny:</h3>";
            echo "<ul>";
            while ($row_player = $result_players->fetch_assoc()) {
                echo "<li>" . $row_player['username'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Brak graczy w drużynie.</p>";
        }
    } else {
        echo "<p>Nie należysz do żadnej drużyny.</p>";
    }
?>    

    <!-- Formularz wyszukiwania gracza -->
    <form action="search_player.php" method="post">
        <input type="text" name="player_name" placeholder="Wpisz nazwę gracza" required>
        <input type="submit" value="Szukaj">
    </form>

    <!-- Formularz zarządzania drużynami -->
    <div class="section">
        <h2>Zarządzanie drużynami</h2>
        <form action="manage_teams.php" method="post">
            <input type="text" name="team_name" placeholder="Nazwa drużyny" required>
            <input type="submit" name="action" value="Dodaj">
            <input type="submit" name="action" value="Edytuj">
            <input type="submit" name="action" value="Usuń">
        </form>
    </div>

    <!-- Formularz zarządzania graczami -->
    <div class="section">
        <h2>Zarządzanie graczami</h2>
        <form action="manage_players.php" method="post">
            <input type="text" name="player_name" placeholder="Nazwa gracza" required>
            <input type="text" name="team_name" placeholder="Nazwa drużyny">
            <select name="role">
                <option value="snajper">Snajper</option>
                <option value="lider">Lider</option>
                <option value="entry fragger">Entry Fragger</option>
                <option value="support">Support</option>
                <option value="lurker">Lurker</option>
            </select>
            <input type="submit" name="action" value="Dodaj">
            <input type="submit" name="action" value="Edytuj">
            <input type="submit" name="action" value="Usuń">
        </form>
    </div>

    <!-- Wyświetlanie wszystkich drużyn -->
    <div class="section">
        <h2>Wszystkie drużyny</h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "csgo_management";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT teams.team_name, players.username AS captain, team_stats.wins, team_stats.losses, team_stats.draws
                FROM teams
                LEFT JOIN players ON teams.captain_id = players.player_id
                LEFT JOIN team_stats ON teams.team_id = team_stats.team_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Nazwa drużyny</th><th>Kapitan</th><th>Wygrane</th><th>Przegrane</th><th>Remisy</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['team_name'] . "</td>";
                echo "<td>" . $row['captain'] . "</td>";
                echo "<td>" . $row['wins'] . "</td>";
                echo "<td>" . $row['losses'] . "</td>";
                echo "<td>" . $row['draws'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Brak drużyn do wyświetlenia.";
        }

        // Wyświetlanie nadchodzących meczów
        $sql = "SELECT teams1.team_name AS team1, teams2.team_name AS team2, matches.date
                FROM matches
                JOIN teams AS teams1 ON matches.team1_id = teams1.team_id
                JOIN teams AS teams2 ON matches.team2_id = teams2.team_id
                WHERE matches.date >= CURDATE()
                ORDER BY matches.date ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Nadchodzące mecze</h2>";
            echo "<table>";
            echo "<tr><th>Drużyna 1</th><th>Drużyna 2</th><th>Data</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['team1'] . "</td>";
                echo "<td>" . $row['team2'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<h2>Nadchodzące mecze</h2>";
            echo "Brak nadchodzących meczów.";
        }

        $conn->close();
        ?>
    </div>

    <a href="logout.php">Wyloguj się</a>
</body>
</html>
