<?php
declare(strict_types=1);

include_once(__DIR__.'/../services/Database.php');

//het importeren van de Customer classe
include "Customer.php";

/**
 * Class Car
 */
class Car
{
    /**
     * @var Database
     */
    private $db;

    /**
     * Id of the car.
     * @var int
     */
    private $id;

    /**
     * Id of the owner of the car
     * @var int
     */
    private $customer_id;

    /**
     * Brand of the car
     * @var string
     */
    private $brand;

    /**
     * Specific type/model/designation of the car
     * @var string
     */
    private $type;

    /**
     * For testing purposes
     * @param $db
     */
    public function setDb($db): void
    {
        $this->db = $db;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param int $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Car constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = new Database;

        if (!empty($id)) {
            $this->loadCar($id);
        }
    }

    /**
     * Loads car by id from database;
     * @param $id int Car_id
     */
    public function loadCar($id): void
    {
        $query = 'SELECT * FROM car WHERE id = :id';
        $parameters = array();
        $parameters['id'] = $id;
        $car = $this->db->getAllRowsSafe($query, $parameters);

        if (count($car) == 1) {
            $this->setId($car[0]['id']);
            $this->setCustomerId($car[0]['customer_id']);
            $this->setBrand($car[0]['brand']);
            $this->setType($car[0]['type']);
        }

    }

    //TODO: Return an instance of classes/Customer instead of array/null
    //DONE: omdit op te lossen heb ik een nieuwe klasse Customer toegevoegd aan dit project

    /**
     * Returns the owner of the car
     * @return Customer
     */
    public function getCustomerOfCar() : Customer
    {  
        // Aangezien ik al een klasse Customer heb aangemaakt kan ik deze 
        // hier net zogoed gebruiken om de customer van deze auto op te halen
        return new Customer($this->getCustomerId());
    }


    /**
     * Returns the number of tasks associated with this car
     * @return int
     */
    public function getNumberOfTasksOfCar() : int
    {
        //SQL heeft zijn eigen count methode dit scheeld weer een beetje data over de lijn :D
        $countedTasks = $this->db->getAllRows(sprintf("SELECT COUNT(*) as 'nr_of_tasks' FROM task WHERE car_id = %d", $this->getId()));
        return (int)($countedTasks[0]['nr_of_tasks']);
    }



    // TODO: Maak het mogelijk om een auto aan een bestaande klant toe te voegen
    // Ik heb dit opgelost om in mijn classe Car een functie addCar toe te voegen 
    // ik vind het personelijke netter om alle 
    /**
     * this funtion will add a new car to the database.
     */
    public function addCar($customer_id, $brand, $type){       
        try {
            $query = "INSERT INTO `car`(`customer_id`, `brand`, `type`)  VALUES (:customer_id, :brand, :type)";
            $parameters = array();
            $parameters['customer_id'] = $customer_id;
            $parameters['brand'] = $brand;
            $parameters['type'] = $type;
            $this->db->execQuerySafe($query, $parameters);

            //Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
            //nadat we een nieuwe car hebben toegevoegd moeten we alleen nog even het object setten.
            $maxId = (int)$this->db->getAllRows('SELECT max(ID) as id From car')[0]['id'];
            $this->loadCar($maxId);

        } catch (Exception $e) {
            echo $e->getMessage();
        }    
    }

}