<link type="text/css" rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap-grid.css">
<link type="text/css" rel="stylesheet" href="css/globel.css">
<link type="text/css" rel="stylesheet" href="css/login.css">


<div class="login-page">
    <div class="form">
        <form action="authenticate.php" method="POST" class="login-form">        
            <h2>Login</h2>
            <div class="field-wrapper">
                <input name="login" placeholder="gebruikers naam...">
            </div>  
            <!-- TODO: zorg ervoor dat bij password input wat je invult verborgen/niet zichtbaar is-->
            <!-- dit is zeer simpel door een type password mee tegeven -->
            <input type="password" name="password" placeholder="wachtwoord">        
            <input class="button" type="submit" value="Log in">

            <?php
                if (isset($_GET['login_failed'])) {
            ?>
                <p style="color:red;">Kon niet inloggen: Login of wachtwoord incorrect</p>
            <?php
                }
            ?>
        </form>
    </div>
</div>


