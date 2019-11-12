<?php

//TODO: Format according to PSR-2

//TODO: Get all customers

//TODO: Validate if this data is correct


require_once(__DIR__.'/services/Database.php');

$db = new Database;


// TODO: Make sure what they returned is sorted by name
// Dit is opgelost door een ORDER BY toe te voegen aan de query
// Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
$customers = $db->getAllRows('SELECT customer.*, COUNT(car.id) as number_of_cars 
                                    FROM customer
                                    JOIN car on car.customer_id = customer.id
                                    GROUP BY customer.id
                                    ORDER BY customer.first_name, customer.last_name ASC');
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
    </div>
</div>
<?php require 'footer.php';?>