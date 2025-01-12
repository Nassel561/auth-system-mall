<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Dashboard - 561Cheats</title>
</head>
<body>
    <!--  -->
    <div class="sidebar">
        <div class="logo">561Cheats</div>
        <nav>
            <ul>
                <li><a href="dashboard.php" class="active">Hem</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="settings.php">Inställningar</a></li>
                <li><a href="fusk.php">561Cheats</a></li>
                <li><a href="logout.php">Logga ut</a></li>
            </ul>
        </nav>
    </div>

    <!--  -->
    <div class="main-content">
        <!--  -->
        <header class="hero">
            <div class="container">
                <h1>Välkommen tillbaka, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p>Din nuvarande plan: <strong><?php echo htmlspecialchars($_SESSION['plan']); ?></strong></p>
                <p>Här kan du få tillgång till alla funktioner för ditt CS:GO fusk. Gör dig redo för att dominera spelet!</p>

                <?php if ($_SESSION['plan'] == 'Pro'): ?>
                    <a href="download.php" class="btn btn-primary">Ladda ner</a>
                <?php else: ?>
                    <a href="buy.php" class="btn btn-primary">Köp</a>
                <?php endif; ?>
            </div>
        </header>

        <!-- -->
        <section class="stats-overview">
            <div class="container">
                <h2>Din CS:GO Statistik</h2>
                <div class="stats-cards">
                    <div class="card">
                        <h3>Status</h3>
                        <p>Undetected: Ja</p>
                    </div>
                    <div class="card">
                        <h3>Antal Sessions</h3>
                        <p>- sessions denna vecka</p>
                    </div>
                    <div class="card">
                        <h3>Tid kvar</h3>
                        <p>30 dagar</p>
                    </div>
                </div>
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
