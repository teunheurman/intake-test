<?php

// TODO: Splits deze file op naar meerdere losse scripts. Eentje voor customer, eentje voor auto, eentje voor klussen.
// DONE: Er is nu bestand niewue_auto.php, klus.php en klant.php.

// TODO: Maak het mogelijk om een auto aan een bestaande klant toe te voegen
// DONE: dit is nu mogelijk in nieuwe_auto.php 

// TODO: Maak het mogelijk om autos, klanten en klussen te verwijderen
// DONE: dit is gedaan in klus.php, klant.php en auto.php, alleen er gaat nog wel iets mis bij het verwijderen van een klus :(

require(__DIR__.'/services/Database.php');
$db = new Database;  

//Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
$cars = $db->getAllRows('SELECT car.*, customer.first_name, customer.last_name from car JOIN customer on customer.id = car.customer_id;');

//Na dat de form is gesubmit moeten we de waardes nog even controleren of deze ook valid zijn.
$taskErr = $carErr = "";
$task = $carId = "";
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["task"])) {
    $taskErr = "Klus is verplicht";
    $valid = false;
  } else {
    $task = test_input($_POST["task"]);
    // controlleer als de waarde alleen letters en spaties bevat
    if (!preg_match("/^[a-zA-Z ]*$/",$task)) {
      $taskErr = "Er mogen alleen letters worden gebruikt";
      $valid = false;
    }
  }

  if (empty($_POST["car"])) {
    $carErr = "auto is verplicht";
    $valid = false;
  }
  else{
    $found = false;
    $carId = $_POST["car"];
    //controlleer als het car is bestaat
    foreach ($cars as $car){
        if($car['id'] == $carId){
            $found = true;
        }
    }
    if (!$found){
        $carErr = 'auto can niet gevonden worden';
        $valid = false;
    }
  }

  //wanneer alle waardes zijn gecheckted voeg een nieuwe task toe
  if($valid){
    require(__DIR__.'/classes/Task.php');
    $new_task = new Task();
    $new_task->addTask($carId, $task);
    header('Location: overview_klussen.php');
  }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<?php require 'header.php';?>
<div class="login-page">
    <div class="form" id="myTabContent">
        <form action="klus.php" method="POST" class="login-form">
            <h3> Auto</h3>
            <p class="error"><?php echo $carErr ?></p>
            <select name="car">
                <?php foreach ($cars as $car): ?>
                    <option value="<?= $car['id'] ?>"><?= $car['first_name'] . ' ' . $car['last_name'] . '\'s ' . $car['brand'] . ' ' . $car['type'] ?>
                <?php endforeach; ?>
            </select>
            <p class="error">* <?php echo $taskErr ?></p>
            <input name="task" placeholder="Klus">
            <input class="button" type="submit" value="Invoeren"/>
        </form>
    </div>
</div>
<?php require 'footer.php';?>
