<?php

// TODO: Splits deze file op naar meerdere losse scripts. Eentje voor customer, eentje voor auto, eentje voor klussen.

// TODO: Maak het mogelijk om een auto aan een bestaande klant toe te voegen

// TODO: Maak het mogelijk om autos, klanten en klussen te verwijderen

require(__DIR__.'/services/Database.php');
$db = new Database;  

//Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
$cars = $db->getAllRows('SELECT car.*, customer.first_name, customer.last_name from car JOIN customer on customer.id = car.customer_id;');

//Na dat de form is gesubmit moeten we de waardes nog even controleren of deze ook valid zijn.
$firstNameErr = $lastNameErr = $ageErr = $brandErr = $typeErr = "";
$firstName = $lastName = $age = $brand = $type = "";

$valid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["first_name"])) {
    $firstNameErr = "Voornaam is verplicht";
    $valid = false;
  } else {
    $firstName = test_input($_POST["first_name"]);
    // controlleer als de waarde alleen letters en spaties bevat
    if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
      $firstNameErr = "Er mogen alleen letters worden gebruikt";
      $valid = false;
    }
  }

  if (empty($_POST["last_name"])) {
    $lastNameErr = "Achternaam is verplicht";
    $valid = false;
  } else {
    $lastName = test_input($_POST["last_name"]);
    // controlleer als de waarde alleen letters en spaties bevat
    if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
      $lastNameErr = "Er mogen alleen letters worden gebruikt";
      $valid = false;
    }
  }

  if (empty($_POST["age"])) {
    $ageErr = "Leeftijd is verplicht";
    $valid = false;
  } else {
    $age = test_input($_POST["age"]);
    // controlleer als de waarde alleen cijfers
    if (!preg_match("/^[0-9]*$/",$age)) {
      $ageErr = "Er mogen alleen cijfers worden gebruikt";
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
    // require(__DIR__.'/classes/Customer.php');
    require(__DIR__.'/classes/Car.php');
    $newCustomer = new Customer();
    $newCustomer->addCustomer($firstName, $lastName, $age);
    $newCar = new Car();
    $newCar->addCar($newCustomer->getId(), $brand, $type);
    header('Location: overview.php');
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
        <form action="klant.php" method="POST" class="login-form">
            <h3>Persoon</h3>  
            <span class="error">*</span>  
            <span class="error-text"><?php echo $firstNameErr;?></span>              
            <input name="first_name" placeholder="Voornaam" require></<input>
            <span class="error">*</span>
            <span class="error-text"><?php echo $lastNameErr;?></span> 
            <input name="last_name" placeholder="Achternaam"></<input>
            <span class="error">*</span> 
            <span class="error-text"><?php echo $ageErr;?></span> 
            <input name="age" placeholder="Leeftijd"></<input>

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
