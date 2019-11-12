<?php



//TODO: Format according to PSR-2

//TODO: Validate if this data is correct


require_once(__DIR__.'/services/Database.php');
require(__DIR__.'/classes/Car.php');

//aangezien html forms geen delete of put meer ondersteunen heb ik er voor gekozen om een post tegebruiken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["carId"])) {
      $carId =$_POST["carId"];
      $car = new Car((int)$carId);
      $car->deleteCar();
    } 
}

$db = new Database;

//Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
$cars = $db->getAllRows('SELECT car.id FROM car');
?>

<?php require 'header.php';?>

<!-- TODO: Separate each page into a template page, thus avoiding massive hard-to-read swathes of code -->

<div class="container">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active">
            <table class="table">
                <thead>
                <tr>
                    <th>Klant</th>
                    <th>Merk</th>
                    <th>Type</th>
                    <th>Klussen</th>
                    <th>verwijderen</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $car = new Car();
                foreach ($cars as $car_id):
                    $car->loadCar($car_id['id']);
                    $owner = $car->getCustomerOfCar();
                    ?>
                    <tr>
                        <td><?= $owner->getFirstName() . ' ' . $owner->getLastName() ?></td>
                        <td><?= $car->getBrand() ?></td>
                        <td><?= $car->getType() ?></td>
                        <td><?= $car->getNumberOfTasksOfCar() ?></td>
                        <td>
                            <form method="POST" action="overview_autos.php">
                                <input type="hidden" value="<?= $car->getId()?>" name="carId">
                                <input class="button" type="submit" value="X"/>
                            </form>
                        </td>


                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require 'footer.php';?>