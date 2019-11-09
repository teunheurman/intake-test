<?php
declare(strict_types=1);

include_once(__DIR__.'/../services/Database.php');


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

    /**
     * Returns the owner of the car
     * @return array/null
     */
    public function getCustomerOfCar()
    {

        $query = 'SELECT * FROM customer WHERE id = :id';
        $parameters = array();
        $parameters['id'] = $this->getCustomerId();
        $customer = $this->db->getAllRowsSafe($query, $parameters);
        if (count($customer) > 0) {
            return $customer[0];
        }
        return null;
    }

    /**
     * Returns the number of tasks associated with this car
     * @return int
     */
    public function getNumberOfTasksOfCar() : int
    {
        $query = "SELECT COUNT(*) as 'nr_of_tasks' FROM task WHERE car_id = :car_id";
        $parameters = array();
        $parameters['car_id'] = $this->getId();
        $countedTasks = $this->db->getAllRowsSafe($query, $parameters);
        return (int)($countedTasks[0]['nr_of_tasks']);
    }

}