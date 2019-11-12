<?php
    //voor ieder pagina die de header gebruikt moet men ook zijn ingelogd. 
    session_start();
    if (!$_SESSION['logged_in']) {
        header("Location: login.php");
    }
?>

<header>
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>

    <link type="text/css" rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap-grid.css">
    <link type="text/css" rel="stylesheet" href="css/globel.css">
    <link type="text/css" rel="stylesheet" href="css/header.css">
    <link type="text/css" rel="stylesheet" href="css/footer.css">
</header>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav nav-tabs">
                <li class="nav-item active">
                    <a class="nav-link" href="overview_klanten.php">Klanten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="overview_autos.php">Autos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="overview_klussen.php">Klussen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="klant.php?type=klant">Nieuwe klant</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="klus.php">Nieuwe klus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="nieuwe_auto.php">Auto toevoegen aan klant</a>
                </li>
            </ul>
            <ul class="nav nav-tabs ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Uitloggen</a>
                </li>
            </ul>
        </div>
    </nav>