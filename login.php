<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    include 'config.php';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT password, plan FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $plan);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        $_SESSION['plan'] = $plan; // Spara användarens planstatus i sessionen
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p>Fel användarnamn eller lösenord.</p>";
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
    <link rel="stylesheet" href="login.css">
    <title>Logga In</title>
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
        <h2>Logga In</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Användarnamn" required>
            <input type="password" name="password" placeholder="Lösenord" required>
            <button type="submit">Logga In</button>
        </form>
        <p>Har du inget konto? <a href="register.php">Registrera dig här</a></p>

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
