<?php

//TODO: Format according to PSR-2

//TODO: Validate if this data is correct

require_once(__DIR__.'/services/Database.php');

$db = new Database;

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
        <div class="tab-pane fade show active">
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