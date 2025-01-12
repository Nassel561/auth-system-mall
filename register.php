<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $plan = 'Free'; // Standardplan är Free

    include 'config.php';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (username, password, plan) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $plan);

    if ($stmt->execute()) {
        echo "<p>Registreringen lyckades! <a href='login.php'>Logga in här</a>.</p>";
    } else {
        echo "<p>Ett fel inträffade: " . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <title>Registrera</title>
</head>
<body>
    <header class="dark-hero">
        <div class="container">
            <nav class="navbar">
                <div class="logo">561Cheats</div>
            </nav>
        </div>
    </header>

    <div class="form-container">
        <h2>Registrera dig</h2>
        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Användarnamn" required>
            <input type="password" name="password" placeholder="Lösenord" required>
            <button type="submit">Registrera</button>
        </form>
        <p>Har du redan ett konto? <a href="login.php">Logga in här</a></p>

        <!--  -->
        <a href="index.php" class="btn btn-back">Tillbaka</a>
    </div>

    <footer class="dark-footer">
        <div class="container">
        <p>561Cheats. Följ oss på GitHub för uppdateringar!</p>
        </div>
    </footer>
</body>
</html>
