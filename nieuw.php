<?php
$type = $_GET['type'];


// TODO: Splits deze file op naar meerdere losse scripts. Eentje voor customer, eentje voor auto, eentje voor klussen.

// TODO: Maak het mogelijk om een auto aan een bestaande klant toe te voegen

// TODO: Maak het mogelijk om autos, klanten en klussen te verwijderen


?>


<?php require 'header.php';?>
<div class="login-page">
    <div class="form" id="myTabContent">
    <form action="opslaan.php" method="POST" class="login-form">
        <?php
        switch ($type){
        case 'klant':
            ?>
            <h3>Persoon</h3>                 
            <input name="first_name" placeholder="Voornaam"></<input>
            <input name="last_name" placeholder="Achternaam"></<input>
            <input name="leeftijd" placeholder="Leeftijd"></<input>

            <h3> Auto</h3>            
            <input name="brand" placeholder="Merk">               
            <input name="type" placeholder="Type">     

            <?php break;
        case 'task':
        require(__DIR__.'/services/Database.php');
        $db = new Database;

        $cars = $db->getAllRows('SELECT car.*, customer.first_name, customer.last_name from car JOIN customer on customer.id = car.customer_id;')

        ?>
        <form action="opslaan.php" class="login-form">

            <h3> Auto</h3>
            <select name="car">
                <?php foreach ($cars as $car): ?>
                    <option value="<?= $car['id'] ?>"><?= $car['first_name'] . ' ' . $car['last_name'] . '\'s ' . $car['brand'] . ' ' . $car['type'] ?>
                <?php endforeach; ?>
            </select>
                <input name="task" placeholder="Klus">
            <?php
                } 
            ?>
            <input type="hidden" name="save_type" value="<?= $_GET['type'] ?>">
            <input class="button" type="submit" value="Invoeren"/>
        </form>
    </div>
</div>
<?php require 'footer.php';?>
