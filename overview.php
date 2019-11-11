<?php

//TODO: Format according to PSR-2

//TODO: Get all customers

//TODO: Validate if this data is correct


require_once(__DIR__.'/services/Database.php');
require(__DIR__.'/classes/Car.php');

$db = new Database;


// TODO: Make sure what they returned is sorted by name
// Dit is opgelost door een ORDER BY toe te voegen aan de query
// Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
$customers = $db->getAllRows('SELECT customer.*, COUNT(car.id) as number_of_cars 
                                    FROM customer
                                    JOIN car on car.customer_id = customer.id
                                    GROUP BY customer.id
                                    ORDER BY customer.first_name, customer.last_name ASC');

//Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
$cars = $db->getAllRows('SELECT car.id FROM car');

//Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
$jobs = $db->getAllRows('SELECT task.*, customer.*, car.*
                                FROM task
                                JOIN car on task.car_id = car.id
                                JOIN customer on car.customer_id = customer.id');


?>

<?php require 'header.php';?>

<!-- TODO: Separate each page into a template page, thus avoiding massive hard-to-read swathes of code -->

<div class="container">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="klanten" role="tabpanel">
            <table class="table">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Aantal autos</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= $customer['first_name'] . ' ' . $customer['last_name'] ?></td>
                        <td><?= $customer['number_of_cars'] ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

        </div>
        <div class="tab-pane fade" id="autos" role="tabpanel">
            <table class="table">
                <thead>
                <tr>
                    <th>Klant</th>
                    <th>Merk</th>
                    <th>Type</th>
                    <th>Klussen</th>
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
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="klussen" role="tabpanel">
            <table class="table">
                <thead>
                <tr>
                    <th>Klant</th>
                    <th>Merk</th>
                    <th>Type</th>
                    <th>Taak</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?= $job['first_name'] . ' ' . $job['last_name'] ?></td>
                        <td><?= $job['brand'] ?></td>
                        <td><?= $job['type'] ?></td>
                        <td><?= $job['task'] ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require 'footer.php';?>