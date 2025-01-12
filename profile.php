<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, plan FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($username, $plan);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $update_sql = "UPDATE users SET password = ? WHERE username = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ss", $new_password, $_SESSION['username']);
    
    if ($update_stmt->execute()) {
        echo "<p>Lösenordet har uppdaterats!</p>";
    } else {
        echo "<p>Ett fel inträffade vid uppdateringen av lösenordet.</p>";
    }

    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Profil - 561Cheats</title>
</head>
<body>
    <!--  -->
    <div class="sidebar">
        <div class="logo">561Cheats</div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Hem</a></li>
                <li><a href="profile.php" class="active">Profil</a></li>
                <li><a href="settings.php">Inställningar</a></li>
                <li><a href="fusk.php">561Cheats</a></li>
                <li><a href="logout.php">Logga ut</a></li>
            </ul>
        </nav>
    </div>

    <!--  -->
    <div class="main-content">
        <header class="hero">
            <div class="container">
                <h1>Välkommen till din profil, <?php echo htmlspecialchars($username); ?>!</h1>
                <p>Din nuvarande plan: <strong><?php echo htmlspecialchars($plan); ?></strong></p>
            </div>
        </header>

        <!--  -->
        <section class="profile-settings">
            <div class="container">
                <h2>Uppdatera Lösenord</h2>
                <form action="profile.php" method="POST">
                    <label for="new_password">Nytt lösenord:</label>
                    <input type="password" name="new_password" id="new_password" required>
                    <button type="submit">Uppdatera Lösenord</button>
                </form>
            </div>
        </section>

        <!--  -->
        <footer class="footer">
            <div class="container">
                <p>561Cheats. Följ oss på GitHub för uppdateringar!</p>
            </div>
        </footer>
    </div>
</body>
</html>
