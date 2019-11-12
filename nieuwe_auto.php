<?php

// TODO: Splits deze file op naar meerdere losse scripts. Eentje voor customer, eentje voor auto, eentje voor klussen.
// DONE: Er is nu bestand niewue_auto.php, klus.php en klant.php.

// TODO: Maak het mogelijk om een auto aan een bestaande klant toe te voegen
// DONE: dit is nu mogelijk in nieuwe_auto.php 

// TODO: Maak het mogelijk om autos, klanten en klussen te verwijderen
// DONE: dit is gedaan in overview_klus.php, overview_klant.php en overview_auto.php, alleen er gaat nog wel iets mis bij het verwijderen van een klus :(

require(__DIR__.'/services/Database.php');
$db = new Database;  

//Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
$customers = $db->getAllRows('SELECT * from customer;');

//Na dat de form is gesubmit moeten we de waardes nog even controleren of deze ook valid zijn.
$customerErr = $brandErr = $typeErr = "";
$customerId = 0;
$brand = $type = "";
$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["customer"])) {
    $customerErr = "customer is  verplict";
    $valid = false;
  }
  else{
    $found = false;
    $customerId = $_POST["customer"];
    //controlleer als het customer is bestaat
    foreach ($customers as $customer){
        if($customer['id'] == $customerId){
            $found = true;
        }
    }
    if (!$found){
        $customerErr = 'auto kan niet gevonden worden';
        $valid = false;
    }
  }

  if (empty($_POST["brand"])) {
    $brandErr = "Merk is verplicht";
    $valid = false;
  } else {
    $brand = test_input($_POST["brand"]);
    // controlleer als de waarde alleen letters en spaties bevat
    if (!preg_match("/^[a-zA-Z ]*$/",$brand)) {
      $brandErr = "Er mogen alleen letters worden gebruikt";
      $valid = false;
    }
  }

  if (empty($_POST["type"])) {
    $typeErr = "type is verplicht";
    $valid = false;
  } else {
    $type = test_input($_POST["type"]);
    // controlleer als de waarde alleen letters en spaties bevat
    if (!preg_match("/^[a-zA-Z0-9 ]*$/",$type)) {
      $typeErr = "Er mogen alleen letters worden gebruikt";
      $valid = false;
    }
  }


//wanneer alle waardes zijn gecheckted voeg een nieuwe task toe
  if($valid){
    require(__DIR__.'/classes/Car.php');
    $newCar = new Car();
    $newCar->addCar($customerId, $brand, $type);
    // header('Location: overview_klanten.php');
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
        <form action="nieuwe_auto.php" method="POST" class="login-form">
            <h3>Persoon</h3>
            <p class="error"><?php echo $customerErr ?></p>
            <select name="customer">
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer['id'] ?>"><?= $customer['first_name'] . ' ' . $customer['last_name']?>
                <?php endforeach; ?>
            </select>
            <h3> Auto</h3>  
            <span class="error">*</span>
            <span class="error-text"> <?php echo $brandErr;?></span>           
            <input name="brand" placeholder="Merk">  
            <span class="error">*</span>
            <span class="error-text"><?php echo $typeErr;?></span>              
            <input name="type" placeholder="Type">
            <input class="button" type="submit" value="Invoeren"/>
        </form>
    </div>
</div>
<?php require 'footer.php';?>
