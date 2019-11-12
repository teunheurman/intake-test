<?php
declare(strict_types=1);

include_once(__DIR__.'/../services/Database.php');


/**
 * Class Customer
 */
class Customer
{
    /**
     * @var Database
     */
    private $db;

    /**
     * Id of the customer.
     * @var int
     */
    private $id;

    /**
     * the first name of this customer
     * @var string
     */
    private $first_name;

    /**
     * the last name of the customer
     * @var string
     */
    private $last_name;

    /**
     * The age of the customer
     * @var int
     */
    private $age;

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
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * Customer constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = new Database;

        if (!empty($id)) {
            $this->loadCustomer($id);
        }
    }

    /**
     * Loads customer by id from database;
     * @param $id int Customer_id
     */
    public function loadCustomer($id): void
    {
        $query = 'SELECT * FROM customer WHERE id = :id;';
        $parameters = array();
        $parameters['id'] = $id;        
        $customer = $this->db->getAllRowsSafe($query, $parameters);

        if (count($customer) == 1) {
            $this->setId($customer[0]['id']);
            $this->setFirstName($customer[0]['first_name']);
            $this->setLastName($customer[0]['last_name']);
            $this->setAge($customer[0]['age']);
        }

    }


    public function addCustomer($first_name, $last_name, $age){
        try {
            $query = "INSERT INTO `customer`(`first_name`, `last_name`, `age`) VALUES (:first_name, :last_name, :age)";
            $parameters = array();
            $parameters['first_name'] = $first_name;
            $parameters['last_name'] = $last_name;
            $parameters['age'] = $age;
            $this->db->execQuerySafe($query, $parameters);

            //Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
            //nadat we een nieuwe customer hebben toegevoegd moeten we alleen nog even het object setten.
            $maxId = (int)$this->db->getAllRows('SELECT max(ID) as id From customer')[0]['id'];
            $this->loadCustomer($maxId);
            

        } catch (Exception $e) {
            echo $e->getMessage();
        }        
    }

    public function deleteCustomer(){
        $query = "DELETE FROM customer WHERE id = :id";
        $parameters = array();
        $parameters['id'] = $this->id;
        $this->db->execQuerySafe($query, $parameters);
    }
}