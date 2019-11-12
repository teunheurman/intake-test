<?php
declare(strict_types=1);

include_once(__DIR__.'/../services/Database.php');


/**
 * Class Task
 */
class Task
{
    /**
     * @var Database
     */
    private $db;

    /**
     * Id of the task.
     * @var int
     */
    private $id;

    /**
     * Id of the car
     * @var int
     */
    private $car_id;

    /**
     * the task that needs to be done on car
     * @var string
     */
    private $task;

    /**
     * the Current status of the task
     * @var int
     */
    private $status;

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
    public function getCarId()
    {
        return $this->car_id;
    }

    /**
     * @param int $status_id
     */
    public function setCarId($car_id)
    {
        $this->car_id = $car_id;
    }

    /**
     * @return string
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param string $task
     */
    public function setTask($task)
    {
        $this->task = $task;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Task constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = new Database;

        if (!empty($id)) {
            $this->loadTask($id);
        }
    }

    /**
     * Loads task by id from database;
     * @param $id int Task_id
     */
    public function loadTask($id): void
    {
        $query = 'SELECT * FROM task WHERE id = :id;';
        $parameters = array();
        $parameters['id'] = $id;        
        $task = $this->db->getAllRowsSafe($query, $parameters);

        if (count($task) == 1) {
            $this->setId($task[0]['id']);
            $this->setCarId($task[0]['car_id']);
            $this->setTask($task[0]['task']);
            $this->setStatus($task[0]['status']);
        }
    }

    public function addTask($car_id, $task){
        try {
            $query = "INSERT INTO `task`(`car_id`, `task`, `status`) VALUES (:car_id, :task, :status)";
            $parameters = array();
            //Ik hoef hier niet car id om te zetten naar een int, hier houdt die zelf rekening mee.
            $parameters['car_id'] = $car_id;
            $parameters['task'] = $task;
            $parameters['status'] = 0;
            $this->db->execQuerySafe($query, $parameters);

            //Hier wordt niks gedaan met een parameter, daarom wordt de getAllRows gebruikt in plaats van de getAllRowsSafe
            //nadat we een nieuwe task hebben toegevoegd moeten we alleen nog even het object setten.
            $maxId = (int)$this->db->getAllRows('SELECT max(ID) as id From task')[0]['id'];
            $this->loadTask($maxId);
        } catch (Exception $e) {
            $e->getMessage();
        }        
    }

    public function deleteTask(){
        $query = "DELETE FROM task WHERE id = :id";
        $parameters = array();
        $parameters['id'] = $this->id;
        $this->db->execQuerySafe($query, $parameters);
    }
}