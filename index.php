<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSGO Team Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
        }
        .form-toggle {
            margin-top: 20px;
            text-align: center;
        }
        .form-toggle a {
            color: #007bff;
            text-decoration: none;
        }
        .form-toggle a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Logowanie</h2>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Nazwa użytkownika" required>
            <input type="password" name="password" placeholder="Hasło" required>
            <input type="submit" value="Zaloguj się">
        </form>
        <div class="form-toggle">
            <span>Nie masz konta? <a href="javascript:void(0);" onclick="toggleForm()">Zarejestruj się</a></span>
        </div>
    </div>

    <div class="container" style="display:none;">
        <h2>Rejestracja</h2>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Nazwa użytkownika" required>
            <input type="password" name="password" placeholder="Hasło" required>
            <input type="submit" value="Zarejestruj się">
        </form>
        <div class="form-toggle">
            <span>Masz już konto? <a href="javascript:void(0);" onclick="toggleForm()">Zaloguj się</a></span>
        </div>
    </div>

    <script>
        function toggleForm() {
            const forms = document.querySelectorAll('.container');
            forms.forEach(form => {
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>
