<?php
require(__DIR__.'/services/Database.php');
$db = new Database;
$type = $_POST['save_type'];


// TODO: Splits deze file op naar meerdere losse scripts. Eentje voor customer, eentje voor auto, eentje voor klussen.

switch ($type) {
    case 'klant':


        $query = "INSERT INTO `customer`(`first_name`, `last_name`, `age`) VALUES (:first_name, :last_name, :age)";
        $parameters = array();
        $parameters['first_name'] = $_POST['first_name'];
        $parameters['last_name'] = $_POST['last_name'];
        $parameters['age'] = $_POST['leeftijd'];
        $db->execQuerySafe($query, $parameters);
       
        //Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
        $maxId = (int)$db->getAllRows('SELECT max(ID) as id From customer')[0]['id'];

        $query = "INSERT INTO `car`(`customer_id`, `brand`, `type`)  VALUES (:customer_id, :brand, :type)";
        $parameters = array();
        $parameters['customer_id'] = $maxId;
        $parameters['brand'] = $_POST['brand'];
        $parameters['type'] = $_POST['type'];
        $db->execQuerySafe($query, $parameters);
    
        break;

    case 'task':

        try {
            $query = "INSERT INTO `task`(`car_id`, `task`, `status`) VALUES (:car_id, :task, :status)";
            $parameters = array();
            //Ik hoef hier niet car id om te zetten naar een int, hier houdt die zelf rekening mee.
            $parameters['car_id'] = $_POST['car'];;
            $parameters['task'] = $_POST['task'];
            $parameters['status'] = 0;
            echo $db->execQuerySafe($query, $parameters);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        break;
}
header('Location: overview.php');
